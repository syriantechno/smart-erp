@extends('themes.icewall.side-menu')

@section('subhead')
    <title>AI Chat - {{ config('app.name') }}</title>
@endsection

@push('styles')
    <style>
        .chat-container {
            height: calc(100vh - 200px);
            display: flex;
            flex-direction: column;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            background: #f8fafc;
        }
        .chat-bubble {
            max-width: 70%;
            margin-bottom: 1rem;
            animation: fadeIn 0.3s ease-in;
        }
        .chat-bubble.user {
            margin-left: auto;
            margin-right: 0;
        }
        .chat-bubble.ai {
            margin-left: 0;
            margin-right: auto;
        }
        .message-content {
            padding: 1rem;
            border-radius: 1rem;
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .message-content.user {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .message-content.ai {
            background: white;
            color: #374151;
            border: 1px solid #e5e7eb;
        }
        .typing-indicator {
            display: none;
            padding: 1rem;
            color: #6b7280;
            font-style: italic;
        }
        .typing-indicator.show {
            display: block;
        }
        .suggestion-chip {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin: 0.25rem;
            background: #f3f4f6;
            border-radius: 2rem;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.875rem;
        }
        .suggestion-chip:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <!-- AI Status Banner -->
    <div id="ai-status-banner" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 rounded-lg mb-6" style="display: none;">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-base.lucide icon="Bot" class="w-6 h-6 mr-3" />
                <div>
                    <h3 class="font-semibold">AI Assistant Active</h3>
                    <p class="text-sm opacity-90">Ready to help with your ERP tasks</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-sm">
                    <span class="font-medium">Model:</span> GPT-3.5 Turbo
                </div>
                <div class="text-sm">
                    <span class="font-medium">Status:</span> <span class="text-green-300">Online</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <!-- Main Chat Area -->
        <div class="col-span-12 lg:col-span-8">
            <div class="bg-white rounded-lg shadow-sm border chat-container">
                <!-- Chat Header -->
                <div class="flex items-center justify-between p-5 border-b border-slate-200/60">
                    <div class="flex items-center">
                        <div class="image-fit h-10 w-10 relative">
                            <img class="rounded-full" src="https://via.placeholder.com/40x40/667eea/ffffff?text=AI" alt="AI Assistant" />
                        </div>
                        <div class="ml-3">
                            <div class="font-medium text-slate-900 dark:text-white">AI Assistant</div>
                            <div class="text-slate-500 text-sm flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                Online - Ready to help
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select id="interaction-mode" class="form-select text-sm">
                            <option value="chat">💬 Chat</option>
                            <option value="command">⚡ Command</option>
                            <option value="analysis">📊 Analysis</option>
                            <option value="generation">✨ Generation</option>
                        </select>
                        <button onclick="clearChat()" class="btn btn-outline-secondary btn-sm" title="Clear Chat">
                            <x-base.lucide icon="Trash2" class="w-4 h-4" />
                        </button>
                    </div>
                </div>

                <!-- Messages Area -->
                <div id="chat-messages" class="chat-messages">
                    <!-- Welcome Message -->
                    <div class="chat-bubble ai">
                        <div class="message-content ai">
                            <div class="flex items-center mb-2">
                                <x-base.lucide icon="Bot" class="w-4 h-4 mr-2 text-blue-600" />
                                <span class="font-medium text-sm">AI Assistant</span>
                                <span class="text-xs text-gray-500 ml-auto">{{ now()->format('H:i') }}</span>
                            </div>
                            <div class="mb-3">
                                <p class="text-sm">👋 Hello! I'm your intelligent ERP assistant. I can help you with:</p>
                                <ul class="text-sm mt-2 space-y-1">
                                    <li>• 📝 Creating tasks, materials, and emails</li>
                                    <li>• 📊 Analyzing your business data</li>
                                    <li>• 📄 Generating reports and content</li>
                                    <li>• ⚡ Executing system commands</li>
                                </ul>
                            </div>
                            <div class="border-t pt-3">
                                <p class="text-xs text-gray-600 mb-2">💡 Try these suggestions:</p>
                                <div class="flex flex-wrap">
                                    <span class="suggestion-chip" onclick="useSuggestion('Create a task for website development')">Create a task</span>
                                    <span class="suggestion-chip" onclick="useSuggestion('Analyze sales performance this month')">Analyze sales</span>
                                    <span class="suggestion-chip" onclick="useSuggestion('Generate a monthly report')">Generate report</span>
                                    <span class="suggestion-chip" onclick="useSuggestion('Show system statistics')">System stats</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Typing Indicator -->
                <div id="typing-indicator" class="typing-indicator">
                    <div class="flex items-center">
                        <x-base.lucide icon="Bot" class="w-4 h-4 mr-2 text-blue-600" />
                        <span>AI is thinking...</span>
                        <div class="ml-2 flex space-x-1">
                            <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="border-t border-slate-200/60 p-4">
                    <div class="flex items-end space-x-3">
                        <div class="flex-1">
                            <textarea
                                id="message-input"
                                class="form-control resize-none"
                                rows="1"
                                placeholder="Ask me anything..."
                                onkeydown="handleKeyPress(event)"
                                oninput="autoResize(this)"
                            ></textarea>
                            <div class="flex justify-between items-center mt-2">
                                <div class="text-xs text-gray-500">
                                    <span id="mode-indicator">💬 Chat Mode</span>
                                </div>
                                <div class="text-xs text-gray-400">
                                    Press Enter to send, Shift+Enter for new line
                                </div>
                            </div>
                        </div>
                        <button
                            id="send-button"
                            onclick="sendMessage()"
                            class="btn btn-primary rounded-full p-3"
                            disabled
                        >
                            <x-base.lucide icon="Send" class="w-5 h-5" />
                        </button>
                    </div>

                    <!-- Quick Commands -->
                    <div id="quick-commands" class="mt-3 flex flex-wrap gap-2">
                        <button onclick="quickCommand('create task')" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs hover:bg-blue-200 transition-colors">
                            + Task
                        </button>
                        <button onclick="quickCommand('add material')" class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs hover:bg-green-200 transition-colors">
                            + Material
                        </button>
                        <button onclick="quickCommand('generate report')" class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs hover:bg-purple-200 transition-colors">
                            📊 Report
                        </button>
                        <button onclick="quickCommand('analyze data')" class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs hover:bg-yellow-200 transition-colors">
                            📈 Analyze
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-span-12 lg:col-span-4 space-y-6">
            <!-- Recent Interactions -->
            <div class="bg-white rounded-lg p-5 shadow-sm border">
                <h3 class="font-semibold mb-4 flex items-center">
                    <x-base.lucide icon="Clock" class="w-5 h-5 mr-2 text-gray-600" />
                    Recent Interactions
                </h3>
                <div id="recent-interactions" class="space-y-3 max-h-64 overflow-y-auto">
                    <!-- Recent interactions will be loaded here -->
                    <div class="text-center py-4 text-gray-500 text-sm">
                        <x-base.lucide icon="Loader" class="w-5 h-5 mx-auto mb-2 animate-spin" />
                        Loading...
                    </div>
                </div>
            </div>

            <!-- AI Capabilities -->
            <div class="bg-white rounded-lg p-5 shadow-sm border">
                <h3 class="font-semibold mb-4 flex items-center">
                    <x-base.lucide icon="Brain" class="w-5 h-5 mr-2 text-purple-600" />
                    AI Capabilities
                </h3>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <x-base.lucide icon="Plus" class="w-4 h-4 text-blue-600" />
                        </div>
                        <div>
                            <h4 class="font-medium text-sm">Content Creation</h4>
                            <p class="text-xs text-gray-600">Create tasks, materials, emails, and more</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <x-base.lucide icon="BarChart3" class="w-4 h-4 text-green-600" />
                        </div>
                        <div>
                            <h4 class="font-medium text-sm">Data Analysis</h4>
                            <p class="text-xs text-gray-600">Analyze trends and generate insights</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <x-base.lucide icon="Settings" class="w-4 h-4 text-purple-600" />
                        </div>
                        <div>
                            <h4 class="font-medium text-sm">Automation</h4>
                            <p class="text-xs text-gray-600">Automate workflows and processes</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <x-base.lucide icon="MessageSquare" class="w-4 h-4 text-yellow-600" />
                        </div>
                        <div>
                            <h4 class="font-medium text-sm">Natural Chat</h4>
                            <p class="text-xs text-gray-600">Conversational AI assistance</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Stats -->
            <div class="bg-white rounded-lg p-5 shadow-sm border">
                <h3 class="font-semibold mb-4 flex items-center">
                    <x-base.lucide icon="TrendingUp" class="w-5 h-5 mr-2 text-green-600" />
                    Usage Statistics
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Interactions</span>
                        <span class="font-semibold" id="total-interactions">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Success Rate</span>
                        <span class="font-semibold text-green-600" id="success-rate">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Tokens Used</span>
                        <span class="font-semibold" id="tokens-used">-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentSessionId = null;
        let aiAvailable = false;

        $(document).ready(function() {
            checkAIAvailability();
            loadRecentInteractions();
            updateStats();
            setupModeIndicator();
        });

        function checkAIAvailability() {
            $.get('{{ route("ai.available") }}')
                .done(function(response) {
                    aiAvailable = response.available;
                    if (aiAvailable) {
                        $('#ai-status-banner').show();
                    } else {
                        showToast('AI Assistant is not configured. Please set up your OpenAI API key first.', 'warning');
                        setTimeout(() => {
                            window.location.href = '{{ route("ai.index") }}';
                        }, 3000);
                    }
                })
                .fail(function() {
                    aiAvailable = false;
                    showToast('Unable to check AI availability. Please check your connection.', 'error');
                    setTimeout(() => {
                        window.location.href = '{{ route("ai.index") }}';
                    }, 3000);
                });
        }

        function setupModeIndicator() {
            $('#interaction-mode').on('change', function() {
                const mode = $(this).val();
                const indicators = {
                    'chat': '💬 Chat Mode - General conversation',
                    'command': '⚡ Command Mode - Execute system actions',
                    'analysis': '📊 Analysis Mode - Data insights',
                    'generation': '✨ Generation Mode - Create content'
                };
                $('#mode-indicator').text(indicators[mode] || '💬 Chat Mode');

                // Update quick commands based on mode
                updateQuickCommands(mode);
            }).trigger('change');
        }

        function updateQuickCommands(mode) {
            const commands = {
                'chat': ['create task', 'add material', 'generate report', 'analyze data'],
                'command': ['create task for', 'add material:', 'send email to', 'generate report'],
                'analysis': ['analyze sales', 'show trends', 'compare performance', 'predict future'],
                'generation': ['write email', 'create report', 'draft document', 'generate summary']
            };

            const modeCommands = commands[mode] || commands['chat'];
            const buttons = modeCommands.map(cmd =>
                `<button onclick="quickCommand('${cmd}')" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs hover:bg-blue-200 transition-colors">${cmd}</button>`
            ).join('');

            $('#quick-commands').html(buttons);
        }

        function loadRecentInteractions() {
            $.get('{{ route("ai.datatable") }}', {
                length: 5,
                start: 0
            })
            .done(function(response) {
                renderRecentInteractions(response.data || []);
            });
        }

        function renderRecentInteractions(interactions) {
            const container = $('#recent-interactions');

            if (interactions.length === 0) {
                container.html('<div class="text-center py-4 text-gray-500 text-sm">No recent interactions</div>');
                return;
            }

            let html = '';
            interactions.forEach(function(interaction) {
                const typeIcon = getTypeIcon(interaction.interaction_type);
                const statusColor = getStatusColor(interaction.status);

                html += `
                    <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer" onclick="retryInteraction(${interaction.id})">
                        <div class="flex-shrink-0 w-8 h-8 ${typeIcon.bg} rounded-full flex items-center justify-center">
                            ${typeIcon.icon}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                ${interaction.user_input.substring(0, 40)}${interaction.user_input.length > 40 ? '...' : ''}
                            </p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${statusColor}">
                                    ${interaction.status}
                                </span>
                                <span class="text-xs text-gray-500">${interaction.formatted_date}</span>
                            </div>
                        </div>
                    </div>
                `;
            });

            container.html(html);
        }

        function getTypeIcon(type) {
            switch(type) {
                case 'query': return { bg: 'bg-blue-100', icon: '💬' };
                case 'command': return { bg: 'bg-green-100', icon: '⚡' };
                case 'analysis': return { bg: 'bg-purple-100', icon: '📊' };
                case 'generation': return { bg: 'bg-yellow-100', icon: '✨' };
                case 'chat': return { bg: 'bg-indigo-100', icon: '💬' };
                default: return { bg: 'bg-gray-100', icon: '❓' };
            }
        }

        function getStatusColor(status) {
            switch(status) {
                case 'completed': return 'bg-green-100 text-green-800';
                case 'processing': return 'bg-blue-100 text-blue-800';
                case 'failed': return 'bg-red-100 text-red-800';
                default: return 'bg-yellow-100 text-yellow-800';
            }
        }

        function sendMessage() {
            if (!aiAvailable) {
                showToast('AI Assistant is currently unavailable', 'warning');
                return;
            }

            const input = $('#message-input');
            const message = input.val().trim();
            const mode = $('#interaction-mode').val();

            if (!message) return;

            currentSessionId = currentSessionId || ('session_' + Date.now());
            addMessage(message, 'user');
            input.val('').trigger('input');

            $('#send-button').prop('disabled', true);
            $('#typing-indicator').addClass('show');

            $.post('{{ route("ai.interact") }}', {
                message: message,
                type: mode,
                session_id: currentSessionId,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                $('#typing-indicator').removeClass('show');
                $('#send-button').prop('disabled', false);

                if (response.success) {
                    addMessage(response.response, 'ai');

                    // Handle command results
                    if (response.metadata && response.metadata.command_result) {
                        const result = response.metadata.command_result;
                        if (result.success && result.type) {
                            addMessage(`✅ ${result.message}`, 'ai', 'success');
                        }
                    }

                    loadRecentInteractions();
                    updateStats();
                } else {
                    addMessage(response.error || 'Sorry, I encountered an error.', 'ai', 'error');
                }
            })
            .fail(function(xhr) {
                $('#typing-indicator').removeClass('show');
                $('#send-button').prop('disabled', false);

                const error = xhr.responseJSON?.error || 'Network error occurred';
                addMessage(`❌ ${error}`, 'ai', 'error');
            });
        }

        function addMessage(content, sender, type = 'normal') {
            const messagesContainer = $('#chat-messages');
            const messageClass = sender === 'user' ? 'user' : 'ai';
            const contentClass = type === 'success' ? 'bg-green-50 border-green-200' :
                               type === 'error' ? 'bg-red-50 border-red-200' : '';

            const messageHtml = `
                <div class="chat-bubble ${messageClass}">
                    <div class="message-content ${messageClass} ${contentClass}">
                        <div class="flex items-center mb-2">
                            ${sender === 'ai' ?
                                '<x-base.lucide icon="Bot" class="w-4 h-4 mr-2 text-blue-600" />' :
                                '<x-base.lucide icon="User" class="w-4 h-4 mr-2 text-green-600" />'
                            }
                            <span class="font-medium text-sm">${sender === 'ai' ? 'AI Assistant' : 'You'}</span>
                            <span class="text-xs text-gray-500 ml-auto">${new Date().toLocaleTimeString()}</span>
                        </div>
                        <div class="text-sm whitespace-pre-wrap">${content}</div>
                    </div>
                </div>
            `;

            messagesContainer.append(messageHtml);
            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);

            // Reinitialize Lucide icons
            lucide.createIcons();
        }

        function handleKeyPress(event) {
            const input = $('#message-input');
            const hasContent = input.val().trim().length > 0;

            $('#send-button').prop('disabled', !hasContent);

            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                if (hasContent) {
                    sendMessage();
                }
            }
        }

        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
        }

        function useSuggestion(suggestion) {
            $('#message-input').val(suggestion).trigger('input').focus();
        }

        function quickCommand(command) {
            $('#message-input').val(command + ' ').trigger('input').focus();
        }

        function clearChat() {
            if (confirm('Are you sure you want to clear the chat?')) {
                $('#chat-messages').html(`
                    <div class="chat-bubble ai">
                        <div class="message-content ai">
                            <div class="flex items-center mb-2">
                                <x-base.lucide icon="Bot" class="w-4 h-4 mr-2 text-blue-600" />
                                <span class="font-medium text-sm">AI Assistant</span>
                            </div>
                            <p class="text-sm">Chat cleared! How can I help you today?</p>
                        </div>
                    </div>
                `);
                currentSessionId = null;
                lucide.createIcons();
            }
        }

        function retryInteraction(id) {
            // This would open the interaction details or retry it
            console.log('Retry interaction:', id);
        }

        function updateStats() {
            // This would fetch and update usage statistics
            // For now, just placeholder
            $('#total-interactions').text('Loading...');
            $('#success-rate').text('Loading...');
            $('#tokens-used').text('Loading...');
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

        // Global functions
        window.sendMessage = sendMessage;
        window.clearChat = clearChat;
        window.useSuggestion = useSuggestion;
        window.quickCommand = quickCommand;
    </script>
@endpush
