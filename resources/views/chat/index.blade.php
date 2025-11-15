@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Internal Chat - {{ config('app.name') }}</title>
@endsection

@push('styles')
    <style>
        .chat-message {
            max-width: 70%;
            margin-bottom: 1rem;
        }
        .chat-message.own {
            margin-left: auto;
            margin-right: 0;
        }
        .chat-message.other {
            margin-left: 0;
            margin-right: auto;
        }
        .chat-bubble {
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            position: relative;
        }
        .chat-bubble.own {
            background-color: #3b82f6;
            color: white;
            border-bottom-right-radius: 0.25rem;
        }
        .chat-bubble.other {
            background-color: #f3f4f6;
            color: #374151;
            border-bottom-left-radius: 0.25rem;
        }
        .chat-messages {
            height: 400px;
            overflow-y: auto;
            padding: 1rem;
        }
        .conversation-item {
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .conversation-item:hover {
            background-color: #f3f4f6;
        }
        .conversation-item.active {
            background-color: #e0f2fe;
            border-right: 3px solid #0ea5e9;
        }
        .unread-badge {
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-3 2xl:col-span-2">
            <h2 class="intro-y mr-auto mt-2 text-lg font-medium">Internal Chat</h2>

            <!-- Start New Chat -->
            <div class="intro-y box mt-6 bg-primary p-5">
                <x-base.button
                    class="mt-1 w-full bg-white text-slate-600 dark:border-darkmode-300 dark:bg-darkmode-300 dark:text-slate-300"
                    type="button"
                    onclick="showNewChatModal()"
                >
                    <x-base.lucide icon="Plus" class="mr-2 h-4 w-4" />
                    New Chat
                </x-base.button>
            </div>

            <!-- Conversations List -->
            <div class="intro-y box mt-6">
                <div class="p-5 border-b border-slate-200/60">
                    <div class="relative text-slate-500">
                        <x-base.form-input
                            id="conversation-search"
                            class="border-transparent bg-slate-100 px-4 py-3 pr-10"
                            type="text"
                            placeholder="Search conversations..."
                        />
                        <x-base.lucide
                            class="absolute inset-y-0 right-0 z-10 my-auto mr-3 h-4 w-4 text-slate-500"
                            icon="Search"
                        />
                    </div>
                </div>

                <div id="conversations-list" class="p-2 max-h-96 overflow-y-auto">
                    <!-- Conversations will be loaded here -->
                    <div class="text-center py-8 text-slate-500">
                        Loading conversations...
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-span-12 lg:col-span-9 2xl:col-span-10">
            <div id="chat-container" class="intro-y box" style="display: none;">
                <!-- Chat Header -->
                <div class="flex items-center justify-between p-5 border-b border-slate-200/60">
                    <div class="flex items-center">
                        <div class="image-fit h-10 w-10 relative">
                            <img id="chat-avatar" class="rounded-full" src="https://via.placeholder.com/40x40/cccccc/666666?text=U" alt="User" />
                        </div>
                        <div class="ml-3">
                            <div id="chat-title" class="font-medium text-slate-900 dark:text-white">Select a conversation</div>
                            <div id="chat-subtitle" class="text-slate-500 text-sm">Choose a conversation to start chatting</div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <x-base.button
                            variant="outline-secondary"
                            size="sm"
                            onclick="refreshMessages()"
                        >
                            <x-base.lucide icon="RefreshCw" class="w-4 h-4" />
                        </x-base.button>
                    </div>
                </div>

                <!-- Messages Area -->
                <div id="messages-area" class="chat-messages bg-slate-50 dark:bg-darkmode-600">
                    <!-- Messages will be loaded here -->
                </div>

                <!-- Message Input -->
                <div class="p-5 border-t border-slate-200/60">
                    <div class="flex items-center gap-3">
                        <div class="flex-1 relative">
                            <x-base.form-textarea
                                id="message-input"
                                class="border-transparent bg-slate-100 px-4 py-3 pr-12 resize-none"
                                rows="1"
                                placeholder="Type your message..."
                                onkeydown="handleKeyPress(event)"
                            ></x-base.form-textarea>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <input type="file" id="file-input" class="hidden" accept="image/*,.pdf,.doc,.docx,.txt" />
                                <button onclick="document.getElementById('file-input').click()" class="text-slate-500 hover:text-slate-700">
                                    <x-base.lucide icon="Paperclip" class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                        <x-base.button
                            id="send-button"
                            variant="primary"
                            onclick="sendMessage()"
                            disabled
                        >
                            <x-base.lucide icon="Send" class="w-4 h-4" />
                        </x-base.button>
                    </div>
                    <div id="file-preview" class="mt-2 hidden">
                        <div class="flex items-center gap-2 p-2 bg-slate-100 rounded">
                            <x-base.lucide icon="File" class="w-4 h-4 text-slate-500" />
                            <span id="file-name" class="text-sm text-slate-700"></span>
                            <button onclick="clearFile()" class="text-red-500 hover:text-red-700">
                                <x-base.lucide icon="X" class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="intro-y box text-center py-16">
                <x-base.lucide icon="MessageSquare" class="w-16 h-16 text-slate-300 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-slate-600 dark:text-slate-400 mb-2">No conversation selected</h3>
                <p class="text-slate-500 mb-4">Choose a conversation from the sidebar to start chatting</p>
                <x-base.button variant="primary" onclick="showNewChatModal()">
                    <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
                    Start New Chat
                </x-base.button>
            </div>
        </div>
    </div>

    <!-- New Chat Modal -->
    <x-modal.form id="new-chat-modal" title="Start New Conversation">
        <form id="new-chat-form">
            <div class="mb-4">
                <label class="form-label">Conversation Type</label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="radio" name="chat_type" value="direct" checked class="mr-2">
                        <span>Direct Message</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="chat_type" value="group" class="mr-2">
                        <span>Group Chat</span>
                    </label>
                </div>
            </div>

            <div id="group-title-section" class="mb-4" style="display: none;">
                <label class="form-label">Group Title</label>
                <x-base.form-input
                    id="group-title"
                    name="group_title"
                    type="text"
                    placeholder="Enter group name"
                    class="w-full"
                />
            </div>

            <div class="mb-4">
                <label class="form-label">Select Participants</label>
                <div id="participants-list" class="max-h-48 overflow-y-auto border border-slate-200 rounded p-2">
                    <!-- Participants will be loaded here -->
                </div>
            </div>
        </form>

        @slot('footer')
            <div class="flex justify-end w-full gap-2">
                <x-base.button
                    type="button"
                    variant="outline-secondary"
                    data-tw-dismiss="modal"
                >
                    Cancel
                </x-base.button>
                <x-base.button
                    type="button"
                    variant="primary"
                    onclick="startNewConversation()"
                >
                    <x-base.lucide icon="MessageCircle" class="w-4 h-4 mr-2" />
                    Start Chat
                </x-base.button>
            </div>
        @endslot
    </x-modal.form>
@endsection

@push('scripts')
    <script>
        let currentConversationId = null;
        let selectedFile = null;

        // Ensure jQuery alias `$` is available even if jQuery is in noConflict mode
        const $ = window.jQuery || window.$;

        if ($) {
            $(document).ready(function() {
                loadConversations();
                setupEventListeners();
                setupRealTimeUpdates();
            });
        } else {
            console.error('jQuery is not available on the chat page.');
        }

        function setupEventListeners() {
            // Message input
            $('#message-input').on('input', function() {
                const hasContent = $(this).val().trim() || selectedFile;
                $('#send-button').prop('disabled', !hasContent);
            });

            // File input
            $('#file-input').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    selectedFile = file;
                    $('#file-name').text(file.name);
                    $('#file-preview').removeClass('hidden');
                    $('#message-input').trigger('input');
                }
            });

            // Conversation search
            $('#conversation-search').on('input', function() {
                filterConversations($(this).val());
            });
        }

        function setupRealTimeUpdates() {
            // Listen for new messages
            window.Echo.private('user.' + {{ auth()->id() }})
                .listen('.message.sent', (e) => {
                    if (e.message.conversation_id === currentConversationId) {
                        appendMessage(e.message);
                        scrollToBottom();
                    }
                    // Refresh conversations list
                    loadConversations();
                });
        }

        function loadConversations() {
            $.get('{{ route("chat.conversations") }}')
                .done(function(response) {
                    if (response.success) {
                        renderConversations(response.conversations);
                    }
                });
        }

        function renderConversations(conversations) {
            const container = $('#conversations-list');
            container.empty();

            if (conversations.length === 0) {
                container.html('<div class="text-center py-8 text-slate-500">No conversations yet</div>');
                return;
            }

            conversations.forEach(function(conversation) {
                const isActive = conversation.id === currentConversationId;
                const unreadBadge = conversation.unread_count > 0 ?
                    `<span class="unread-badge">${conversation.unread_count}</span>` : '';

                const lastMessage = conversation.last_message ?
                    `<div class="text-xs text-slate-500 truncate">${conversation.last_message.sender_name}: ${conversation.last_message.content}</div>` :
                    '<div class="text-xs text-slate-500">No messages yet</div>';

                const item = `
                    <div class="conversation-item p-3 ${isActive ? 'active' : ''}" onclick="openConversation(${conversation.id})">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="image-fit h-10 w-10 relative flex-shrink-0">
                                    <img class="rounded-full" src="https://via.placeholder.com/40x40/cccccc/666666?text=${conversation.display_name.charAt(0)}" alt="User" />
                                </div>
                                <div class="ml-3 flex-1 min-w-0">
                                    <div class="font-medium text-slate-900 dark:text-white truncate">${conversation.display_name}</div>
                                    ${lastMessage}
                                </div>
                            </div>
                            ${unreadBadge}
                        </div>
                    </div>
                `;
                container.append(item);
            });
        }

        function openConversation(conversationId) {
            currentConversationId = conversationId;

            // Update UI
            $('#empty-state').hide();
            $('#chat-container').show();
            $('.conversation-item').removeClass('active');
            $(`.conversation-item:has([onclick="openConversation(${conversationId})"])`).addClass('active');

            // Load messages
            loadMessages(conversationId);
        }

        function loadMessages(conversationId) {
            $.get('{{ route("chat.messages", ":id") }}'.replace(':id', conversationId))
                .done(function(response) {
                    if (response.success) {
                        $('#chat-title').text(response.conversation.display_name);
                        $('#chat-subtitle').text(`${response.conversation.type} conversation`);
                        renderMessages(response.messages);
                        scrollToBottom();
                    }
                });
        }

        function renderMessages(messages) {
            const container = $('#messages-area');
            container.empty();

            if (messages.length === 0) {
                container.html('<div class="text-center py-8 text-slate-500">No messages yet. Start the conversation!</div>');
                return;
            }

            let lastDate = null;
            messages.forEach(function(message) {
                // Add date separator if needed
                if (message.formatted_date !== lastDate) {
                    container.append(`
                        <div class="flex justify-center my-4">
                            <span class="px-3 py-1 bg-slate-200 text-slate-600 text-xs rounded-full">${message.formatted_date}</span>
                        </div>
                    `);
                    lastDate = message.formatted_date;
                }

                const messageClass = message.is_own ? 'own' : 'other';
                const bubbleClass = message.is_own ? 'own' : 'other';

                let messageContent = message.content;

                // Handle file messages
                if (message.message_type === 'image') {
                    messageContent = `<img src="${message.file_url}" class="max-w-xs rounded" alt="Image">`;
                } else if (message.message_type === 'file') {
                    messageContent = `
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <a href="${message.file_url}" target="_blank" class="underline">${message.file_name}</a>
                        </div>
                    `;
                }

                const messageHtml = `
                    <div class="chat-message ${messageClass}">
                        <div class="chat-bubble ${bubbleClass}">
                            ${messageContent}
                            <div class="text-xs mt-1 opacity-70">${message.formatted_time}</div>
                        </div>
                    </div>
                `;

                container.append(messageHtml);
            });
        }

        function sendMessage() {
            if (!currentConversationId) return;

            const content = $('#message-input').val().trim();
            if (!content && !selectedFile) return;

            const formData = new FormData();
            formData.append('conversation_id', currentConversationId);
            if (content) {
                formData.append('content', content);
            }
            if (selectedFile) {
                formData.append('file', selectedFile);
            }

            $.ajax({
                url: '{{ route("chat.send-message") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#message-input').val('');
                        clearFile();
                        // Message will be appended via real-time update
                    }
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'Failed to send message';
                    showToast(error, 'error');
                }
            });
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        function clearFile() {
            selectedFile = null;
            $('#file-input').val('');
            $('#file-preview').addClass('hidden');
            $('#message-input').trigger('input');
        }

        function showNewChatModal() {
            loadUsersForChat();
            const modalEl = document.getElementById('new-chat-modal');
            if (modalEl) {
                modalEl.dispatchEvent(new CustomEvent('open-modal'));
            }
        }

        function loadUsersForChat() {
            // Load users list (excluding current user)
            const usersList = $('#participants-list');
            usersList.html('<div class="text-center py-4 text-slate-500">Loading users...</div>');

            // For demo purposes, we'll use a simple list
            const users = @json($users);
            usersList.empty();

            users.forEach(function(user) {
                const userItem = `
                    <label class="flex items-center p-2 hover:bg-slate-100 rounded cursor-pointer">
                        <input type="checkbox" class="participant-checkbox mr-3" value="${user.id}">
                        <div class="image-fit h-8 w-8 relative mr-3">
                            <img class="rounded-full" src="https://via.placeholder.com/32x32/cccccc/666666?text=${user.name.charAt(0)}" alt="User" />
                        </div>
                        <div>
                            <div class="font-medium">${user.name}</div>
                            <div class="text-sm text-slate-500">${user.email}</div>
                        </div>
                    </label>
                `;
                usersList.append(userItem);
            });
        }

        function startNewConversation() {
            const chatType = $('input[name="chat_type"]:checked').val();
            const selectedParticipants = $('.participant-checkbox:checked');

            if (chatType === 'direct' && selectedParticipants.length !== 1) {
                showToast('Please select exactly one participant for direct messages', 'warning');
                return;
            }

            if (chatType === 'group' && selectedParticipants.length < 2) {
                showToast('Please select at least 2 participants for group chat', 'warning');
                return;
            }

            const participantIds = selectedParticipants.map(function() {
                return $(this).val();
            }).get();

            const data = {
                type: chatType,
                participant_id: participantIds[0], // For direct messages
                participant_ids: participantIds, // For group messages
                title: $('#group-title').val(),
            };

            $.post('{{ route("chat.start-conversation") }}', data)
                .done(function(response) {
                    if (response.success) {
                        const modalEl = document.getElementById('new-chat-modal');
                        if (modalEl) {
                            modalEl.dispatchEvent(new CustomEvent('close-modal'));
                        }
                        loadConversations();
                        if (response.conversation_id) {
                            openConversation(response.conversation_id);
                        }
                        showToast('Conversation started successfully', 'success');
                    } else {
                        showToast(response.message, 'error');
                    }
                })
                .fail(function() {
                    showToast('Failed to start conversation', 'error');
                });
        }

        function refreshMessages() {
            if (currentConversationId) {
                loadMessages(currentConversationId);
            }
        }

        function filterConversations(searchTerm) {
            const term = searchTerm.toLowerCase();
            $('.conversation-item').each(function() {
                const name = $(this).find('.font-medium').text().toLowerCase();
                $(this).toggle(name.includes(term));
            });
        }

        function scrollToBottom() {
            const container = document.getElementById('messages-area');
            container.scrollTop = container.scrollHeight;
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-lg text-white ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Make functions globally available
        window.showNewChatModal = showNewChatModal;
        window.openConversation = openConversation;
        window.sendMessage = sendMessage;
        window.clearFile = clearFile;
        window.startNewConversation = startNewConversation;
        window.refreshMessages = refreshMessages;
    </script>
@endpush
