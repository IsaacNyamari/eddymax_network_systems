// resources/js/wysiwyg-editor.js

// Store all editor instances globally
window.wysiwygEditors = {};

// WysiwygEditor Class
export class WysiwygEditor {
    constructor(containerId, options = {}) {
        this.containerId = containerId;
        this.container = document.getElementById(containerId);

        if (!this.container) {
            console.error(`Container with ID "${containerId}" not found`);
            return;
        }

        // Get the textarea from the container
        this.textarea = this.container.querySelector('textarea');
        if (!this.textarea) {
            console.error(`Textarea not found in container "${containerId}"`);
            return;
        }

        // Store original textarea ID for Livewire
        this.textareaId = this.textarea.id;

        // Default options
        this.options = {
            toolbar: ['bold', 'italic', 'underline', 'strike', 'heading', 'list', 'link', 'image', 'code'],
            height: this.textarea.getAttribute('rows') * 24 || 150,
            placeholder: this.textarea.getAttribute('placeholder') || '',
            ...options
        };

        // Track HTML mode state
        this.htmlMode = false;

        // Create editor
        this.init();

        // Store instance globally
        window.wysiwygEditors[containerId] = this;
    }

    init() {
        // Hide the original textarea but keep it for Livewire binding
        this.textarea.classList.add('hidden');

        // Check if editor already exists (on Livewire re-render)
        const existingEditor = this.container.querySelector('.wysiwyg-editor-container');
        if (existingEditor) {
            existingEditor.remove();
        }

        // Create editor structure
        this.createEditorStructure();

        // Set initial content from textarea
        this.editorContent.innerHTML = this.textarea.value || '';

        // Set up toolbar functionality
        this.setupToolbar();

        // Set up content sync with original textarea
        this.setupContentSync();

        // Handle placeholder
        this.setupPlaceholder();
    }

    createEditorStructure() {
        // Create editor container
        this.editorContainer = document.createElement('div');
        this.editorContainer.className = 'wysiwyg-editor-container border border-gray-300 rounded-lg overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500';

        // Create toolbar
        const toolbar = document.createElement('div');
        toolbar.className = 'editor-toolbar bg-gray-50 border-b border-gray-300 p-2 flex flex-wrap gap-1';

        // Toolbar buttons configuration
        const toolbarButtons = [
            { command: 'bold', icon: 'fas fa-bold', title: 'Bold' },
            { command: 'italic', icon: 'fas fa-italic', title: 'Italic' },
            { command: 'underline', icon: 'fas fa-underline', title: 'Underline' },
            { command: 'strikeThrough', icon: 'fas fa-strikethrough', title: 'Strikethrough' },
            { separator: true },
            {
                command: 'formatBlock',
                value: 'h2',
                icon: 'fas fa-heading',
                title: 'Heading',
                text: 'H2',
                dropdown: [
                    { value: 'h1', text: 'Heading 1' },
                    { value: 'h2', text: 'Heading 2' },
                    { value: 'h3', text: 'Heading 3' },
                    { value: 'p', text: 'Paragraph' }
                ]
            },
            { command: 'insertUnorderedList', icon: 'fas fa-list-ul', title: 'Bullet List' },
            { command: 'insertOrderedList', icon: 'fas fa-list-ol', title: 'Numbered List' },
            { separator: true },
            { command: 'createLink', icon: 'fas fa-link', title: 'Insert Link' },
            { command: 'insertImage', icon: 'fas fa-image', title: 'Insert Image' },
            { command: 'code', icon: 'fas fa-code', title: 'Toggle HTML Code' },
            { separator: true },
            { command: 'undo', icon: 'fas fa-undo', title: 'Undo' },
            { command: 'redo', icon: 'fas fa-redo', title: 'Redo' }
        ];

        // Add buttons to toolbar
        toolbarButtons.forEach(btn => {
            if (btn.separator) {
                const separator = document.createElement('div');
                separator.className = 'w-px h-6 bg-gray-300 mx-1';
                toolbar.appendChild(separator);
            } else {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'w-8 h-8 flex items-center justify-center rounded hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-300';
                button.title = btn.title;

                if (btn.icon) {
                    const icon = document.createElement('i');
                    icon.className = btn.icon;
                    button.appendChild(icon);
                }

                if (btn.text) {
                    button.innerHTML += ` ${btn.text}`;
                }

                // Store command data
                if (btn.command) {
                    button.dataset.command = btn.command;
                }

                if (btn.value) {
                    button.dataset.value = btn.value;
                }

                if (btn.dropdown) {
                    button.classList.add('relative', 'group');
                    button.innerHTML += ' <i class="fas fa-chevron-down text-xs"></i>';

                    // Create dropdown
                    const dropdown = document.createElement('div');
                    dropdown.className = 'absolute top-full left-0 mt-1 bg-white shadow-lg rounded-md border border-gray-200 z-10 hidden group-hover:block min-w-max';

                    btn.dropdown.forEach(item => {
                        const dropdownItem = document.createElement('button');
                        dropdownItem.type = 'button';
                        dropdownItem.className = 'block w-full text-left px-4 py-2 hover:bg-gray-100 whitespace-nowrap focus:outline-none focus:bg-gray-100';
                        dropdownItem.textContent = item.text;
                        dropdownItem.dataset.command = 'formatBlock';
                        dropdownItem.dataset.value = item.value;
                        dropdown.appendChild(dropdownItem);
                    });

                    button.appendChild(dropdown);
                }

                toolbar.appendChild(button);
            }
        });

        // Create editor content area
        this.editorContent = document.createElement('div');
        this.editorContent.className = 'editor-content bg-white p-4';
        this.editorContent.style.minHeight = `${this.options.height}px`;
        this.editorContent.contentEditable = true;
        this.editorContent.setAttribute('data-editor-for', this.textareaId);

        // Assemble editor
        this.editorContainer.appendChild(toolbar);
        this.editorContainer.appendChild(this.editorContent);

        // Insert editor before the original textarea
        this.textarea.parentNode.insertBefore(this.editorContainer, this.textarea);

        // Store reference to toolbar
        this.toolbar = toolbar;
    }

    setupToolbar() {
        this.toolbar.addEventListener('click', (e) => {
            const button = e.target.closest('button');
            if (!button) return;

            e.preventDefault();

            const command = button.dataset.command;
            const value = button.dataset.value;

            // If we're in HTML mode, toggle back to WYSIWYG mode first
            if (this.htmlMode && command !== 'code') {
                this.toggleHTMLMode();
                return;
            }

            // Focus on editor content if not in HTML mode
            if (!this.htmlMode) {
                this.editorContent.focus();
            }

            // Handle special commands
            if (command === 'createLink') {
                this.insertLink();
            } else if (command === 'insertImage') {
                this.insertImage();
            } else if (command === 'code') {
                this.toggleHTMLMode();
            } else if (command === 'undo' || command === 'redo') {
                document.execCommand(command, false, null);
                this.updateTextareaValue();
            } else if (command) {
                document.execCommand(command, false, value || null);
                this.updateTextareaValue();
            }
        });
    }

    setupContentSync() {
        // Update textarea on editor content changes
        this.editorContent.addEventListener('input', () => {
            this.updateTextareaValue();
        });

        // Also update on paste
        this.editorContent.addEventListener('paste', (e) => {
            // Allow paste to happen, then update
            setTimeout(() => {
                this.updateTextareaValue();
            }, 10);
        });

        // Update on keyup for certain commands that don't trigger input event
        this.editorContent.addEventListener('keyup', () => {
            this.updateTextareaValue();
        });
    }

    setupPlaceholder() {
        if (this.options.placeholder) {
            // Handle placeholder on focus
            this.editorContent.addEventListener('focus', () => {
                if (this.editorContent.innerHTML === '' ||
                    this.editorContent.innerHTML === `<div>${this.options.placeholder}</div>` ||
                    this.editorContent.innerHTML === this.options.placeholder) {
                    this.editorContent.innerHTML = '';
                }
            });

            this.editorContent.addEventListener('blur', () => {
                if (this.editorContent.innerHTML === '' ||
                    this.editorContent.innerHTML === '<div><br></div>' ||
                    this.editorContent.innerHTML === '<br>') {
                    this.editorContent.innerHTML = this.options.placeholder;
                }
            });

            // Set initial placeholder if content is empty
            if (!this.textarea.value.trim()) {
                this.editorContent.innerHTML = this.options.placeholder;
            }
        }
    }

    updateTextareaValue() {
        let content = '';

        if (this.htmlMode && this.htmlTextarea) {
            content = this.htmlTextarea.value;
        } else {
            content = this.editorContent.innerHTML;

            // Handle placeholder
            if (this.options.placeholder &&
                (content === this.options.placeholder ||
                    content === `<div>${this.options.placeholder}</div>`)) {
                content = '';
            }
        }

        // Update the hidden textarea
        this.textarea.value = content;

        // Trigger Livewire update
        this.triggerLivewireUpdate();
    }

    triggerLivewireUpdate() {
        // Dispatch input event for Livewire
        const inputEvent = new Event('input', { bubbles: true });
        this.textarea.dispatchEvent(inputEvent);

        // Also trigger change event
        const changeEvent = new Event('change', { bubbles: true });
        this.textarea.dispatchEvent(changeEvent);

        // For Livewire v3
        const livewireUpdateEvent = new Event('livewire:input', {
            bubbles: true,
            detail: { value: this.textarea.value }
        });
        this.textarea.dispatchEvent(livewireUpdateEvent);
    }

    insertLink() {
        const url = prompt('Enter URL:', 'https://');
        if (url) {
            document.execCommand('createLink', false, url);
            this.updateTextareaValue();
        }
    }

    insertImage() {
        const url = prompt('Enter image URL:', 'https://');
        if (url) {
            document.execCommand('insertImage', false, url);
            this.updateTextareaValue();
        }
    }

    toggleHTMLMode() {
        if (!this.htmlMode) {
            // Switch to HTML mode
            this.htmlMode = true;

            // Get current content
            let html = this.editorContent.innerHTML;

            // Clean up placeholder if present
            if (this.options.placeholder &&
                (html === this.options.placeholder ||
                    html === `<div>${this.options.placeholder}</div>`)) {
                html = '';
            }

            // Create textarea for HTML editing
            this.htmlTextarea = document.createElement('textarea');
            this.htmlTextarea.className = 'w-full font-mono text-sm p-4 border-0 focus:ring-0';
            this.htmlTextarea.value = html;
            this.htmlTextarea.style.minHeight = `${this.options.height}px`;
            this.htmlTextarea.rows = Math.floor(this.options.height / 24);

            // Disable toolbar buttons (except code toggle)
            const toolbarButtons = this.toolbar.querySelectorAll('button');
            toolbarButtons.forEach(btn => {
                if (btn.dataset.command !== 'code') {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });

            // Update the code button
            const codeButton = this.toolbar.querySelector('[data-command="code"]');
            if (codeButton) {
                codeButton.innerHTML = '<i class="fas fa-eye mr-1"></i> Visual';
                codeButton.title = 'Switch to Visual Editor';
            }

            // Replace editor content with textarea
            this.editorContent.replaceWith(this.htmlTextarea);

            // Focus on the textarea
            this.htmlTextarea.focus();

            // Update textarea when HTML changes
            this.htmlTextarea.addEventListener('input', () => {
                this.updateTextareaValue();
            });
        } else {
            // Switch back to WYSIWYG mode
            this.htmlMode = false;

            // Get HTML content
            const html = this.htmlTextarea.value;

            // Update the code button
            const codeButton = this.toolbar.querySelector('[data-command="code"]');
            if (codeButton) {
                codeButton.innerHTML = '<i class="fas fa-code"></i>';
                codeButton.title = 'Switch to HTML Code';
            }

            // Re-enable toolbar buttons
            const toolbarButtons = this.toolbar.querySelectorAll('button');
            toolbarButtons.forEach(btn => {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            });

            // Restore editor content
            const content = html || (this.options.placeholder ? this.options.placeholder : '');
            this.editorContent.innerHTML = content;
            this.htmlTextarea.replaceWith(this.editorContent);

            // Clean up
            this.htmlTextarea = null;

            // Focus back on editor
            this.editorContent.focus();

            // Update the hidden textarea
            this.updateTextareaValue();
        }
    }

    // Save content to textarea before Livewire updates
    saveContent() {
        this.updateTextareaValue();
    }

    // Re-initialize editor (for Livewire re-renders)
    reinit() {
        // Save current content
        const currentContent = this.getContent();

        // Destroy current editor UI
        if (this.editorContainer && this.editorContainer.parentNode) {
            this.editorContainer.remove();
        }

        // Re-initialize
        this.init();

        // Restore content
        this.setContent(currentContent);
    }

    // Public method to get content
    getContent() {
        return this.htmlMode ? this.htmlTextarea.value : this.editorContent.innerHTML;
    }

    // Public method to set content
    setContent(content) {
        if (this.htmlMode && this.htmlTextarea) {
            this.htmlTextarea.value = content;
        } else {
            this.editorContent.innerHTML = content;
        }
        this.updateTextareaValue();
    }

    // Public method to destroy editor
    destroy() {
        if (this.editorContainer && this.editorContainer.parentNode) {
            this.editorContainer.remove();
        }
        this.textarea.classList.remove('hidden');

        // Remove from global store
        delete window.wysiwygEditors[this.containerId];
    }
}

// Initialize editors with data attributes
export function autoInitializeWysiwyg() {
    document.querySelectorAll('[data-wysiwyg]').forEach(container => {
        const containerId = container.id;
        if (!containerId) {
            console.error('WYSIWYG container must have an ID');
            return;
        }

        // Skip if already initialized
        if (window.wysiwygEditors[containerId]) {
            window.wysiwygEditors[containerId].reinit();
            return;
        }

        const options = {
            height: container.getAttribute('data-height') || undefined,
            placeholder: container.getAttribute('data-placeholder') || undefined
        };

        new WysiwygEditor(containerId, options);
    });
}

// Reinitialize all editors (for Livewire updates)
export function reinitializeAllEditors() {
    Object.values(window.wysiwygEditors).forEach(editor => {
        editor.reinit();
    });
}

// Make available globally
window.WysiwygEditor = WysiwygEditor;
window.autoInitializeWysiwyg = autoInitializeWysiwyg;
window.reinitializeAllEditors = reinitializeAllEditors;

// Initialize on DOM content loaded
document.addEventListener('DOMContentLoaded', () => {
    autoInitializeWysiwyg();
});

// Listen for Livewire events
if (window.livewire) {
    // Before Livewire updates
    document.addEventListener('livewire:before-update', () => {
        // Save all editor contents before Livewire updates the DOM
        Object.values(window.wysiwygEditors).forEach(editor => {
            editor.saveContent();
        });
    });

    // After Livewire updates
    document.addEventListener('livewire:after-update', () => {
        // Reinitialize editors after DOM update
        setTimeout(() => {
            autoInitializeWysiwyg();
        }, 50);
    });

    // After Livewire initializes
    document.addEventListener('livewire:init', () => {
        setTimeout(() => {
            autoInitializeWysiwyg();
        }, 100);
    });
}

// Alpine.js compatibility
if (window.Alpine) {
    document.addEventListener('alpine:init', () => {
        autoInitializeWysiwyg();
    });
}