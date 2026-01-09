<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind WYSIWYG Editor for Laravel</title>
    <!-- Using Tailwind via CDN for demo, in your app use Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom styles for the editor */
        .editor-toolbar button.active {
            @apply bg-indigo-100 text-indigo-600 border-indigo-300;
        }
        
        .editor-content {
            min-height: 150px;
        }
        
        .editor-content:focus {
            @apply outline-none ring-2 ring-indigo-500 ring-opacity-50;
        }
        
        .editor-content h1 {
            @apply text-3xl font-bold mt-4 mb-2;
        }
        
        .editor-content h2 {
            @apply text-2xl font-bold mt-3 mb-2;
        }
        
        .editor-content h3 {
            @apply text-xl font-bold mt-2 mb-2;
        }
        
        .editor-content ul, .editor-content ol {
            @apply ml-6 my-2;
        }
        
        .editor-content ul {
            @apply list-disc;
        }
        
        .editor-content ol {
            @apply list-decimal;
        }
        
        .editor-content blockquote {
            @apply border-l-4 border-gray-300 pl-4 italic my-3;
        }
        
        .editor-content a {
            @apply text-indigo-600 hover:underline;
        }
        
        .editor-content table {
            @apply border-collapse w-full my-3;
        }
        
        .editor-content table, .editor-content th, .editor-content td {
            @apply border border-gray-300;
        }
        
        .editor-content th, .editor-content td {
            @apply p-2;
        }
    </style>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Tailwind WYSIWYG Editor for Laravel</h1>
        <p class="text-gray-600 mb-8">A modular editor that integrates with Laravel Livewire and can be used for multiple fields on the same page.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Example 1: Product Short Description -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Example 1: Product Short Description</h2>
                
                <div>
                    <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                    
                    <!-- This is where the editor will be injected -->
                    <div id="editor-short-description-container">
                        <textarea 
                            wire:model="short_description" 
                            id="short_description" 
                            rows="3"
                            class="w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 h-48"
                            placeholder="Enter product short description...">This is a <strong>product short description</strong>. You can format text with the toolbar above.</textarea>
                    </div>
                    
                    <!-- Error message (Laravel Livewire style) -->
                    <p class="mt-1 text-sm text-red-600 hidden">Error message would appear here</p>
                </div>
            </div>
            
            <!-- Example 2: Product Long Description -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Example 2: Product Long Description</h2>
                
                <div>
                    <label for="long_description" class="block text-sm font-medium text-gray-700 mb-2">Long Description</label>
                    
                    <!-- This is where the editor will be injected -->
                    <div id="editor-long-description-container">
                        <textarea 
                            wire:model="long_description" 
                            id="long_description" 
                            rows="6"
                            class="w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 h-64"
                            placeholder="Enter product long description..."><h2>Product Features</h2>
<ul>
<li><strong>High Quality</strong>: Made with premium materials</li>
<li><strong>Durable</em>: Built to last for years</li>
<li><strong>Easy to Use</strong>: Simple setup process</li>
</ul>
<p>This is a detailed description with <a href="#">links</a> and formatted content.</p></textarea>
                    </div>
                    
                    <!-- Error message (Laravel Livewire style) -->
                    <p class="mt-1 text-sm text-red-600 hidden">Error message would appear here</p>
                </div>
            </div>
        </div>
        
        <!-- Example 3: Blog Content -->
        <div class="bg-white rounded-xl shadow p-6 mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Example 3: Blog Content</h2>
            
            <div>
                <label for="blog_content" class="block text-sm font-medium text-gray-700 mb-2">Blog Content</label>
                
                <!-- This is where the editor will be injected -->
                <div id="editor-blog-content-container">
                    <textarea 
                        wire:model="blog_content" 
                        id="blog_content" 
                        rows="8"
                        class="w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 h-72"
                        placeholder="Enter blog content..."></textarea>
                </div>
                
                <!-- Error message (Laravel Livewire style) -->
                <p class="mt-1 text-sm text-red-600 hidden">Error message would appear here</p>
            </div>
        </div>
        
        <div class="mt-10 bg-indigo-50 border border-indigo-100 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-indigo-800 mb-3">Implementation Instructions</h3>
            <div class="text-gray-700 space-y-3">
                <p><strong>1.</strong> Include the JavaScript file in your Laravel project (via Vite).</p>
                <p><strong>2.</strong> Add the CSS classes to your Tailwind configuration if needed.</p>
                <p><strong>3.</strong> Initialize editors by calling <code class="bg-gray-800 text-gray-100 px-2 py-1 rounded">new WysiwygEditor(containerId, options)</code>.</p>
                <p><strong>4.</strong> The editor automatically syncs with the original textarea for Livewire binding.</p>
                <p><strong>5.</strong> Use the same textarea ID in your Livewire component to handle the data.</p>
            </div>
        </div>
    </div>

    <!-- The JavaScript file that creates the WYSIWYG editor -->
    <script>
        // WysiwygEditor Class - Modular and reusable
        class WysiwygEditor {
            constructor(containerId, options = {}) {
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
                
                // Default options
                this.options = {
                    toolbar: ['bold', 'italic', 'underline', 'strike', 'heading', 'list', 'link', 'image', 'code'],
                    height: this.textarea.getAttribute('rows') * 24 || 150,
                    placeholder: this.textarea.getAttribute('placeholder') || '',
                    ...options
                };
                
                // Create editor
                this.init();
            }
            
            init() {
                // Store original textarea value and attributes
                const originalValue = this.textarea.value;
                const originalId = this.textarea.id;
                const originalName = this.textarea.name;
                const wireModel = this.textarea.getAttribute('wire:model');
                
                // Hide the original textarea but keep it for Livewire binding
                this.textarea.classList.add('hidden');
                
                // Create editor structure
                this.createEditorStructure();
                
                // Set initial content
                this.editorContent.innerHTML = originalValue;
                
                // Set up toolbar functionality
                this.setupToolbar();
                
                // Set up content sync with original textarea
                this.setupContentSync();
                
                // Store reference to original textarea
                this.editorContainer.dataset.targetTextarea = originalId;
                if (wireModel) {
                    this.editorContainer.dataset.wireModel = wireModel;
                }
            }
            
            createEditorStructure() {
                // Create editor container
                this.editorContainer = document.createElement('div');
                this.editorContainer.className = 'border border-gray-300 rounded-lg overflow-hidden';
                
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
                    { command: 'code', icon: 'fas fa-code', title: 'HTML Code' },
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
                        button.className = 'w-8 h-8 flex items-center justify-center rounded hover:bg-gray-200 transition-colors';
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
                                dropdownItem.className = 'block w-full text-left px-4 py-2 hover:bg-gray-100 whitespace-nowrap';
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
                
                // Add placeholder if specified
                if (this.options.placeholder) {
                    this.editorContent.setAttribute('data-placeholder', this.options.placeholder);
                    this.editorContent.addEventListener('focus', () => {
                        if (this.editorContent.textContent === '' || this.editorContent.textContent === this.options.placeholder) {
                            this.editorContent.textContent = '';
                        }
                    });
                    
                    this.editorContent.addEventListener('blur', () => {
                        if (this.editorContent.textContent === '') {
                            this.editorContent.textContent = this.options.placeholder;
                        }
                    });
                    
                    // Set initial placeholder if content is empty
                    if (!this.textarea.value.trim()) {
                        this.editorContent.textContent = this.options.placeholder;
                    }
                }
                
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
                    
                    // Focus on editor content
                    this.editorContent.focus();
                    
                    // Handle special commands
                    if (command === 'createLink') {
                        this.insertLink();
                    } else if (command === 'insertImage') {
                        this.insertImage();
                    } else if (command === 'code') {
                        this.toggleHTMLMode();
                    } else if (command === 'undo' || command === 'redo') {
                        document.execCommand(command, false, null);
                    } else if (command) {
                        document.execCommand(command, false, value || null);
                    }
                    
                    // Update textarea value
                    this.updateTextareaValue();
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
            
            updateTextareaValue() {
                // Update the hidden textarea with current editor content
                this.textarea.value = this.editorContent.innerHTML;
                
                // Trigger Livewire update if wire:model is present
                if (this.textarea.hasAttribute('wire:model')) {
                    // Dispatch input event to trigger Livewire binding
                    const inputEvent = new Event('input', { bubbles: true });
                    this.textarea.dispatchEvent(inputEvent);
                }
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
                // Toggle between WYSIWYG and HTML code mode
                if (this.editorContent.contentEditable === 'true') {
                    // Switch to HTML mode
                    this.htmlMode = true;
                    const html = this.editorContent.innerHTML;
                    
                    // Create textarea for HTML editing
                    this.htmlTextarea = document.createElement('textarea');
                    this.htmlTextarea.className = 'w-full h-64 font-mono text-sm p-3 border border-gray-300 rounded';
                    this.htmlTextarea.value = html;
                    
                    // Replace editor content with textarea
                    this.editorContent.replaceWith(this.htmlTextarea);
                    
                    // Update textarea when HTML changes
                    this.htmlTextarea.addEventListener('input', () => {
                        this.textarea.value = this.htmlTextarea.value;
                        if (this.textarea.hasAttribute('wire:model')) {
                            const inputEvent = new Event('input', { bubbles: true });
                            this.textarea.dispatchEvent(inputEvent);
                        }
                    });
                } else {
                    // Switch back to WYSIWYG mode
                    this.htmlMode = false;
                    const html = this.htmlTextarea.value;
                    
                    // Restore editor content
                    this.editorContent.innerHTML = html;
                    this.htmlTextarea.replaceWith(this.editorContent);
                    this.updateTextareaValue();
                }
            }
            
            // Public method to get content
            getContent() {
                return this.editorContent.innerHTML;
            }
            
            // Public method to set content
            setContent(content) {
                this.editorContent.innerHTML = content;
                this.updateTextareaValue();
            }
            
            // Public method to destroy editor
            destroy() {
                if (this.editorContainer && this.editorContainer.parentNode) {
                    this.editorContainer.parentNode.removeChild(this.editorContainer);
                }
                this.textarea.classList.remove('hidden');
            }
        }

        // Initialize editors when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize editor for short description
            const shortDescEditor = new WysiwygEditor('editor-short-description-container');
            
            // Initialize editor for long description
            const longDescEditor = new WysiwygEditor('editor-long-description-container');
            
            // Initialize editor for blog content
            const blogEditor = new WysiwygEditor('editor-blog-content-container', {
                height: 300,
                toolbar: ['bold', 'italic', 'underline', 'heading', 'list', 'link', 'image', 'code', 'undo', 'redo']
            });
            
            // Store references if needed for external access
            window.wysiwygEditors = {
                shortDesc: shortDescEditor,
                longDesc: longDescEditor,
                blog: blogEditor
            };
            
            console.log('WYSIWYG editors initialized. Access via window.wysiwygEditors');
        });
    </script>
</body>
</html>