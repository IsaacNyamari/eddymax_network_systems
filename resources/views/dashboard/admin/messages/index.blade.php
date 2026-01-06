@extends('dashboard.layouts.dashboard')
@section('title', 'Messages')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .message-item.active {
        background-color: #eff6ff;
        border-left: 3px solid #3b82f6;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .message-content pre {
        white-space: pre-wrap;
        word-wrap: break-word;
        background-color: #f9fafb;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-top: 1rem;
        font-family: 'Inter', -apple-system, sans-serif;
    }
    
    .filter-btn.active {
        background-color: #dbeafe;
        color: #1d4ed8;
        border-color: #93c5fd;
    }
    
    #messagesList::-webkit-scrollbar {
        width: 6px;
    }
    
    #messagesList::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    #messagesList::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    #messagesList::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(0);
        }
    }
</style>
@endpush

@section('content')
<div class="flex h-[calc(100vh-10rem)]">
    <!-- Sidebar - Message List -->
    <div class="w-full md:w-1/3 lg:w-1/4 border-r border-gray-200 bg-white flex flex-col">
        <!-- Header -->
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-comments mr-2 text-blue-500"></i> Messages
                </h2>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">{{ $unreadCount }} unread</span>
                    <button onclick="location.reload()" class="p-2 text-gray-600 hover:text-blue-600 transition-colors">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            
            <!-- Search and Filters -->
            <div class="mt-4 space-y-2">
                <div class="relative">
                    <input type="text" id="searchMessages" placeholder="Search messages..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex space-x-2">
                    <button onclick="filterMessages('all')" class="filter-btn active px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-layer-group mr-1"></i> All
                    </button>
                    <button onclick="filterMessages('unread')" class="filter-btn px-3 py-1 text-sm rounded-full border border-gray-300 text-gray-600 hover:bg-gray-50">
                        <i class="fas fa-envelope mr-1"></i> Unread
                    </button>
                    <button onclick="filterMessages('read')" class="filter-btn px-3 py-1 text-sm rounded-full border border-gray-300 text-gray-600 hover:bg-gray-50">
                        <i class="fas fa-envelope-open mr-1"></i> Read
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages List -->
        <div class="flex-1 overflow-y-auto" id="messagesList">
            @forelse($messages as $message)
            <div class="message-item border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors duration-150 {{ $message->read ? 'bg-white' : 'bg-blue-50' }}"
                 data-message-id="{{ $message->id }}"
                 data-read="{{ $message->read ? 'true' : 'false' }}">
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-user-circle mr-2 text-gray-400"></i>
                                <span class="font-semibold text-gray-900 truncate mr-2">{{ $message->name }}</span>
                                @if(!$message->read)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-circle text-xs mr-1"></i> New
                                </span>
                                @endif
                            </div>
                            <div class="ml-6">
                                <p class="text-sm text-gray-600 truncate mb-1">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i> {{ $message->email }}
                                </p>
                                @if($message->phone)
                                <p class="text-sm text-gray-500 truncate">
                                    <i class="fas fa-phone mr-2 text-gray-400"></i> {{ $message->phone }}
                                </p>
                                @else
                                <p class="text-sm text-gray-500 truncate">
                                    <i class="fas fa-phone-slash mr-2 text-gray-400"></i> No phone
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="ml-2 flex flex-col items-end">
                            <span class="text-xs text-gray-500 whitespace-nowrap">
                                <i class="far fa-clock mr-1"></i> {{ $message->created_at->format('h:i A') }}
                            </span>
                            <span class="text-xs text-gray-400 mt-1">
                                {{ $message->created_at->format('M d') }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-700 line-clamp-2">
                        <i class="fas fa-quote-left mr-2 text-gray-400"></i> {{ Str::limit($message->message, 100) }}
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                <p class="mt-2 text-gray-500">No messages yet</p>
                <p class="text-sm text-gray-400 mt-1">All your messages will appear here</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Main Content - Message Details -->
    <div class="flex-1 hidden md:flex flex-col bg-white" id="messageDetail">
        <!-- Default state when no message selected -->
        <div class="flex-1 flex items-center justify-center bg-gray-50">
            <div class="text-center">
                <i class="fas fa-comment-alt text-6xl text-gray-400 mb-4"></i>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Select a message</h3>
                <p class="mt-1 text-gray-500">Choose a message from the list to view its content</p>
                <p class="text-sm text-gray-400 mt-2">
                    <i class="fas fa-arrow-left mr-2"></i> Click on any message to read it
                </p>
            </div>
        </div>

        <!-- Message details will be loaded here via AJAX -->
        <div id="messageContent"></div>
    </div>
</div>

<!-- Mobile message detail modal -->
<div id="mobileMessageModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="absolute inset-0 flex flex-col bg-white">
        <div id="mobileMessageContent"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentMessageId = null;
    
    // Initialize message selection
    document.addEventListener('DOMContentLoaded', function() {
        const messageItems = document.querySelectorAll('.message-item');
        const searchInput = document.getElementById('searchMessages');
        
        // Handle message item click
        messageItems.forEach(item => {
            item.addEventListener('click', function() {
                const messageId = this.dataset.messageId;
                selectMessage(messageId);
                
                // Mark as read
                if (this.dataset.read === 'false') {
                    markAsRead(messageId);
                }
            });
        });
        
        // Search functionality
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterMessagesBySearch(searchTerm);
        });
        
        // Auto-select first unread message on desktop
        if (window.innerWidth >= 768) {
            const firstUnread = document.querySelector('.message-item[data-read="false"]');
            const firstMessage = document.querySelector('.message-item');
            if (firstUnread) {
                selectMessage(firstUnread.dataset.messageId);
            } else if (firstMessage) {
                selectMessage(firstMessage.dataset.messageId);
            }
        }
    });
    
    function selectMessage(messageId) {
        currentMessageId = messageId;
        
        // Update active state
        document.querySelectorAll('.message-item').forEach(item => {
            item.classList.remove('active');
            if (item.dataset.messageId === messageId) {
                item.classList.add('active');
            }
        });
        
        // Load message content
        loadMessageContent(messageId);
        
        // On mobile, show modal
        if (window.innerWidth < 768) {
            showMobileMessage();
        }
    }
    
    function loadMessageContent(messageId) {
        fetch(`/admin/messages/${messageId}`)
            .then(response => response.json())
            .then(data => {
                const message = data.message;
                const messageContent = `
                    <div class="flex flex-col h-full">
                        <!-- Message Header -->
                        <div class="border-b border-gray-200 p-4 bg-white">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-user-circle text-2xl text-gray-400 mr-3"></i>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">${message.name}</h3>
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-envelope mr-2"></i> ${message.email}
                                            </p>
                                            ${message.phone ? `
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-phone mr-2"></i> ${message.phone}
                                            </p>` : ''}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <div class="flex items-center space-x-2 mb-2">
                                        ${!message.read ? '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800"><i class="fas fa-circle text-xs mr-1"></i> New</span>' : ''}
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-clock mr-1"></i> ${data.formatted_time}
                                        </span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="replyToMessage('${message.email}')" class="p-2 text-gray-600 hover:text-blue-600 hover:bg-gray-100 rounded-lg transition-colors" title="Reply">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                        <button onclick="markAsRead(${message.id})" class="p-2 text-gray-600 hover:text-green-600 hover:bg-gray-100 rounded-lg transition-colors" title="Mark as Read">
                                            <i class="fas fa-envelope-open"></i>
                                        </button>
                                        <button onclick="markAsUnread(${message.id})" class="p-2 text-gray-600 hover:text-yellow-600 hover:bg-gray-100 rounded-lg transition-colors" title="Mark as Unread">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <button onclick="deleteMessage(${message.id})" class="p-2 text-gray-600 hover:text-red-600 hover:bg-gray-100 rounded-lg transition-colors" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Message Body -->
                        <div class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-50">
                            <div class="max-w-3xl mx-auto">
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
                                    <div class="flex items-center mb-4 border-b pb-3">
                                        <i class="fas fa-quote-left text-blue-500 mr-3 text-xl"></i>
                                        <h4 class="text-lg font-semibold text-gray-800">Message Content</h4>
                                    </div>
                                    <div class="prose max-w-none">
                                        <div class="text-gray-800 whitespace-pre-wrap font-sans leading-relaxed p-4 bg-gray-50 rounded-lg">
                                            ${message.message}
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6 pt-4 border-t border-gray-200">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            <span>Received: ${data.formatted_date} at ${data.formatted_time}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Quick Actions -->
                                <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <button onclick="markAsRead(${message.id})" class="flex items-center justify-center px-4 py-3 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-check-circle mr-2"></i> Mark as Read
                                    </button>
                                    <button onclick="markAsUnread(${message.id})" class="flex items-center justify-center px-4 py-3 text-sm bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                                        <i class="fas fa-envelope mr-2"></i> Mark as Unread
                                    </button>
                                    <a href="mailto:${message.email}" class="flex items-center justify-center px-4 py-3 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fas fa-paper-plane mr-2"></i> Reply via Email
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Footer -->
                        <div class="border-t border-gray-200 p-4 bg-white">
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-info-circle mr-2"></i> Message ID: #${message.id}
                                </div>
                                <div class="flex space-x-3">
                                    <button onclick="previousMessage()" class="flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                                        <i class="fas fa-chevron-left mr-2"></i> Previous
                                    </button>
                                    <button onclick="nextMessage()" class="flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                                        Next <i class="fas fa-chevron-right ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Update content
                const contentDiv = document.getElementById('messageContent');
                const detailDiv = document.getElementById('messageDetail');
                const defaultContent = detailDiv.querySelector('.items-center');
                
                if (defaultContent) {
                    defaultContent.style.display = 'none';
                }
                contentDiv.innerHTML = messageContent;
                contentDiv.style.display = 'flex';
                contentDiv.style.flexDirection = 'column';
                contentDiv.style.height = '100%';
            })
            .catch(error => {
                console.error('Error loading message:', error);
                showNotification('Error loading message', 'error');
            });
    }
    
    function showMobileMessage() {
        const modal = document.getElementById('mobileMessageModal');
        const mobileContent = document.getElementById('mobileMessageContent');
        mobileContent.innerHTML = document.getElementById('messageContent').innerHTML;
        
        // Add close button for mobile
        const closeBtn = `
            <div class="border-b border-gray-200 p-4 bg-white">
                <button onclick="hideMobileMessage()" class="flex items-center text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-3"></i> Back to messages
                </button>
            </div>
        `;
        mobileContent.innerHTML = closeBtn + mobileContent.innerHTML;
        
        modal.classList.remove('hidden');
        modal.querySelector('.bg-white').style.animation = 'slideIn 0.3s ease';
    }
    
    function hideMobileMessage() {
        document.getElementById('mobileMessageModal').classList.add('hidden');
    }
    
    async function markAsRead(messageId) {
        try {
            const response = await fetch(`/admin/messages/${messageId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.ok) {
                // Update UI
                const messageItem = document.querySelector(`.message-item[data-message-id="${messageId}"]`);
                if (messageItem) {
                    messageItem.dataset.read = 'true';
                    messageItem.classList.remove('bg-blue-50');
                    const newBadge = messageItem.querySelector('.bg-blue-100');
                    if (newBadge) {
                        newBadge.remove();
                    }
                }
                
                // Update unread count
                updateUnreadCount();
                showNotification('Message marked as read', 'success');
                
                // Reload message content if it's the current message
                if (currentMessageId == messageId) {
                    loadMessageContent(messageId);
                }
            }
        } catch (error) {
            console.error('Error marking as read:', error);
            showNotification('Error marking as read', 'error');
        }
    }
    
    async function markAsUnread(messageId) {
        try {
            const response = await fetch(`/admin/messages/${messageId}/unread`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.ok) {
                // Update UI
                const messageItem = document.querySelector(`.message-item[data-message-id="${messageId}"]`);
                if (messageItem) {
                    messageItem.dataset.read = 'false';
                    messageItem.classList.add('bg-blue-50');
                    
                    // Add "New" badge
                    const nameSpan = messageItem.querySelector('.font-semibold');
                    if (nameSpan && !messageItem.querySelector('.bg-blue-100')) {
                        const badge = document.createElement('span');
                        badge.className = 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 ml-2';
                        badge.innerHTML = '<i class="fas fa-circle text-xs mr-1"></i> New';
                        nameSpan.after(badge);
                    }
                }
                
                // Update unread count
                updateUnreadCount();
                showNotification('Message marked as unread', 'success');
                
                // Reload message content if it's the current message
                if (currentMessageId == messageId) {
                    loadMessageContent(messageId);
                }
            }
        } catch (error) {
            console.error('Error marking as unread:', error);
            showNotification('Error marking as unread', 'error');
        }
    }
    
    async function deleteMessage(messageId) {
        if (!confirm('Are you sure you want to delete this message? This action cannot be undone.')) return;
        
        try {
            const response = await fetch(`/admin/messages/${messageId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.ok) {
                // Remove from UI
                const messageItem = document.querySelector(`.message-item[data-message-id="${messageId}"]`);
                if (messageItem) {
                    messageItem.remove();
                }
                
                // Clear content if deleted message was selected
                if (currentMessageId == messageId) {
                    document.getElementById('messageContent').innerHTML = '';
                    const defaultContent = document.querySelector('#messageDetail .items-center');
                    if (defaultContent) {
                        defaultContent.style.display = 'flex';
                    }
                    currentMessageId = null;
                }
                
                // Update unread count
                updateUnreadCount();
                
                // Show success message
                showNotification('Message deleted successfully', 'success');
                
                // Hide mobile modal if open
                hideMobileMessage();
            }
        } catch (error) {
            console.error('Error deleting message:', error);
            showNotification('Error deleting message', 'error');
        }
    }
    
    function replyToMessage(email) {
        window.location.href = `mailto:${email}`;
    }
    
    function filterMessages(filter) {
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        const messages = document.querySelectorAll('.message-item');
        messages.forEach(message => {
            switch(filter) {
                case 'unread':
                    message.style.display = message.dataset.read === 'false' ? 'block' : 'none';
                    break;
                case 'read':
                    message.style.display = message.dataset.read === 'true' ? 'block' : 'none';
                    break;
                default:
                    message.style.display = 'block';
            }
        });
    }
    
    function filterMessagesBySearch(term) {
        const messages = document.querySelectorAll('.message-item');
        messages.forEach(message => {
            const text = message.textContent.toLowerCase();
            message.style.display = text.includes(term) ? 'block' : 'none';
        });
    }
    
    function previousMessage() {
        const messages = Array.from(document.querySelectorAll('.message-item[style*="block"]'));
        const currentIndex = messages.findIndex(m => m.dataset.messageId == currentMessageId);
        if (currentIndex > 0) {
            selectMessage(messages[currentIndex - 1].dataset.messageId);
        }
    }
    
    function nextMessage() {
        const messages = Array.from(document.querySelectorAll('.message-item[style*="block"]'));
        const currentIndex = messages.findIndex(m => m.dataset.messageId == currentMessageId);
        if (currentIndex < messages.length - 1 && currentIndex !== -1) {
            selectMessage(messages[currentIndex + 1].dataset.messageId);
        }
    }
    
    function updateUnreadCount() {
        const unreadCount = document.querySelectorAll('.message-item[data-read="false"]').length;
        const countElement = document.querySelector('.text-gray-600');
        if (countElement) {
            countElement.innerHTML = `<i class="fas fa-envelope mr-1"></i> ${unreadCount} unread`;
        }
    }
    
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        document.querySelectorAll('.custom-notification').forEach(n => n.remove());
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `custom-notification fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg flex items-center ${
            type === 'success' ? 'bg-green-600' : 
            type === 'error' ? 'bg-red-600' : 'bg-blue-600'
        } text-white`;
        
        const icon = type === 'success' ? 'fa-check-circle' : 
                    type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        
        notification.innerHTML = `
            <i class="fas ${icon} mr-3 text-xl"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && currentMessageId) {
            hideMobileMessage();
        }
    });
</script>
@endpush