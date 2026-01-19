class TailwindToast {
    constructor() {
        this.container = document.getElementById('toast-container');
        if (!this.container) {
            this.createContainer();
        }
        this.toasts = new Set();
    }

    createContainer() {
        this.container = document.createElement('div');
        this.container.id = 'toast-container';
        this.container.className = 'fixed top-4 right-4 z-50 flex flex-col gap-3 w-80 sm:w-96';
        document.body.appendChild(this.container);
    }

    /**
     * Show a toast notification
     * @param {Object} options
     * @param {string} options.title - Toast title
     * @param {string} options.message - Toast message
     * @param {string} options.type - 'success', 'error', 'warning', 'info', 'order'
     * @param {number} options.duration - Duration in ms (default: 5000)
     * @param {Function} options.onClick - Click handler
     * @param {string} options.actionText - Action button text
     * @param {Function} options.onAction - Action button handler
     * @param {Object} options.data - Additional data to pass to handlers
     */
    show(options) {
        const {
            title = 'Notification',
            message = '',
            type = 'info',
            duration = 5000,
            onClick = null,
            actionText = null,
            onAction = null,
            data = null
        } = options;

        // Create toast element
        const toastId = 'toast-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = this.getToastClasses(type);
        toast.setAttribute('role', 'alert');

        // Add animation classes
        toast.classList.add('animate-in', 'slide-in-from-right-2', 'duration-300');

        // Create icon based on type
        const icon = this.getIcon(type);

        // Build toast content
        toast.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    ${icon}
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">${title}</p>
                    ${message ? `<p class="mt-1 text-sm text-gray-500">${message}</p>` : ''}
                    ${actionText ? `
                        <div class="mt-3 flex gap-2">
                            <button type="button" class="inline-flex items-center rounded-md bg-${this.getTypeColor(type)}-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-${this.getTypeColor(type)}-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-${this.getTypeColor(type)}-600">
                                ${actionText}
                            </button>
                            <button type="button" class="rounded-md bg-white px-2.5 py-1.5 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                Dismiss
                            </button>
                        </div>
                    ` : ''}
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button type="button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
            </div>
            ${duration > 0 ? `<div class="progress-bar absolute bottom-0 left-0 h-1 bg-${this.getTypeColor(type)}-500 rounded-b-lg"></div>` : ''}
        `;

        // Add to container
        this.container.appendChild(toast);
        this.toasts.add(toastId);

        // Set up progress bar animation if duration specified
        if (duration > 0) {
            const progressBar = toast.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.transition = `width ${duration}ms linear`;
                progressBar.style.width = '100%';
                setTimeout(() => {
                    progressBar.style.width = '0%';
                }, 10);
            }

            // Auto remove after duration
            setTimeout(() => {
                this.remove(toastId);
            }, duration);
        }

        // Add click handlers
        const closeBtn = toast.querySelector('button[type="button"]');
        closeBtn.addEventListener('click', () => this.remove(toastId));

        const actionBtn = toast.querySelector('button.bg-' + this.getTypeColor(type));
        if (actionBtn && onAction) {
            actionBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                onAction(data);
                this.remove(toastId);
            });
        }

        if (onClick) {
            toast.addEventListener('click', (e) => {
                if (!e.target.closest('button')) {
                    onClick(data);
                    this.remove(toastId);
                }
            });
        }

        // Add mouse events for pause on hover
        toast.addEventListener('mouseenter', () => {
            const progressBar = toast.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.transition = 'none';
                progressBar.style.width = progressBar.style.width;
            }
        });

        toast.addEventListener('mouseleave', () => {
            const progressBar = toast.querySelector('.progress-bar');
            if (progressBar && duration > 0) {
                const remainingWidth = parseFloat(progressBar.style.width);
                const remainingTime = (remainingWidth / 100) * duration;
                progressBar.style.transition = `width ${remainingTime}ms linear`;
                progressBar.style.width = '0%';
            }
        });

        return toastId;
    }

    remove(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.remove('animate-in', 'slide-in-from-right-2');
            toast.classList.add('animate-out', 'slide-out-to-right-2');

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
                this.toasts.delete(toastId);
            }, 300);
        }
    }

    clearAll() {
        this.toasts.forEach(toastId => this.remove(toastId));
    }

    getToastClasses(type) {
        const baseClasses = 'relative rounded-lg p-4 shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden transform transition-all duration-300';
        const typeClasses = {
            success: 'bg-green-50 ring-green-100',
            error: 'bg-red-50 ring-red-100',
            warning: 'bg-yellow-50 ring-yellow-100',
            info: 'bg-blue-50 ring-blue-100',
            order: 'bg-purple-50 ring-purple-100'
        };

        return `${baseClasses} ${typeClasses[type] || typeClasses.info}`;
    }

    getIcon(type) {
        const icons = {
            success: `
                <div class="h-6 w-6 text-green-400">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            `,
            error: `
                <div class="h-6 w-6 text-red-400">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
            `,
            warning: `
                <div class="h-6 w-6 text-yellow-400">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
            `,
            info: `
                <div class="h-6 w-6 text-blue-400">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                </div>
            `,
            order: `
                <div class="h-6 w-6 text-purple-400">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </div>
            `
        };

        return icons[type] || icons.info;
    }

    getTypeColor(type) {
        const colors = {
            success: 'green',
            error: 'red',
            warning: 'yellow',
            info: 'blue',
            order: 'purple'
        };
        return colors[type] || 'blue';
    }

    // Convenience methods
    success(message, title = 'Success!', options = {}) {
        return this.show({ type: 'success', title, message, ...options });
    }

    error(message, title = 'Error!', options = {}) {
        return this.show({ type: 'error', title, message, ...options });
    }

    warning(message, title = 'Warning!', options = {}) {
        return this.show({ type: 'warning', title, message, ...options });
    }

    info(message, title = 'Info', options = {}) {
        return this.show({ type: 'info', title, message, ...options });
    }

    order(message, title = 'New Order!', options = {}) {
        return this.show({ type: 'order', title, message, ...options });
    }
}

// Create global instance
window.Toast = new TailwindToast();