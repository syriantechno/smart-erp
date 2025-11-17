@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>AI Chat - {{ config('app.name') }}</title>
@endsection

@push('styles')
    <style>
        .chat-container {
            height: calc(100vh - 220px);
            display: flex;
            flex-direction: column;
            background: radial-gradient(circle at top left, rgba(59,130,246,0.08), transparent 55%),
                        radial-gradient(circle at bottom right, rgba(147,51,234,0.08), transparent 55%);
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(to bottom, #f9fafb, #f3f4f6);
        }

        .chat-bubble {
            max-width: 78%;
            margin-bottom: 1rem;
            animation: fadeIn 0.25s ease-out;
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
            padding: 0.9rem 1.1rem;
            border-radius: 1.25rem;
            position: relative;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        }

        .message-content.user {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: #f9fafb;
        }

        .message-content.ai {
            background: rgba(255, 255, 255, 0.96);
            color: #1f2933;
            border: 1px solid rgba(148, 163, 184, 0.35);
            backdrop-filter: blur(10px);
        }

        .typing-indicator {
            display: none;
            padding: 0.75rem 1.25rem;
            color: #6b7280;
            font-style: italic;
            background: rgba(255, 255, 255, 0.9);
            border-top: 1px solid #e5e7eb;
        }

        .typing-indicator.show {
            display: block;
        }

        .suggestion-chip {
            display: inline-block;
            padding: 0.4rem 0.95rem;
            margin: 0.25rem;
            background: rgba(15,23,42,0.03);
            border-radius: 9999px;
            cursor: pointer;
            transition: all 0.18s ease-out;
            font-size: 0.8rem;
            border: 1px solid rgba(148, 163, 184, 0.4);
            color: #475569;
        }

        .suggestion-chip:hover {
            background: rgba(59,130,246,0.08);
            border-color: rgba(59,130,246,0.5);
            transform: translateY(-1px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <!-- AI Status Banner -->
    <div id="ai-status-banner" class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white p-5 rounded-2xl mb-6 shadow-lg shadow-indigo-500/20" style="display: none;">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="h-11 w-11 rounded-2xl bg-white/10 flex items-center justify-center shadow-inner">
                    <x-base.lucide icon="Bot" class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-semibold text-base">AI Assistant Connected</h3>
                    <p class="text-xs md:text-sm text-white/80">Smart assistant ready to help you across the ERP modules.</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-xs md:text-sm">
                <div class="px-3 py-1 rounded-full bg-white/10 border border-white/20 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    <span>Online</span>
                </div>
                <div class="px-3 py-1 rounded-full bg-white/10 border border-white/20">
                    <span class="font-medium">Mode:</span>
                    <span class="ml-1">Context-aware ERP assistant</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <!-- Main Chat Area -->
        <div class="col-span-12 xl:col-span-8">
            <div class="bg-white dark:bg-darkmode-600 rounded-2xl shadow-sm border border-slate-200/70 dark:border-darkmode-400 chat-container overflow-hidden">
                <!-- Chat Header -->
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200/70 dark:border-darkmode-400 bg-slate-50/80 dark:bg-darkmode-700/80 backdrop-blur">
                    <div class="flex items-center gap-3">
                        <div class="relative h-11 w-11">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 opacity-80"></div>
                            <div class="relative h-full w-full rounded-full flex items-center justify-center bg-white/10 border border-white/40">
                                <x-base.lucide icon="Bot" class="w-5 h-5 text-white" />
                            </div>
                        </div>
                        <div>
                            <div class="font-semibold text-slate-900 dark:text-slate-50 text-sm md:text-base">AI Assistant</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>Ready to assist with tasks, reports and analysis</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-base.form-select id="interaction-mode" class="text-xs md:text-sm w-32 md:w-40">
                            <option value="chat">💬 Chat</option>
                            <option value="command">⚡ Command</option>
                            <option value="analysis">📊 Analysis</option>
                            <option value="generation">✨ Generation</option>
                        </x-base.form-select>
                        <x-base.button
                            type="button"
                            variant="outline-secondary"
                            size="sm"
                            class="hidden sm:inline-flex"
                            onclick="clearChat()"
                            title="Clear Conversation"
                        >
                            <x-base.lucide icon="Trash2" class="w-4 h-4" />
                        </x-base.button>
                    </div>
                </div>

                <!-- Messages Area -->
                <div id="chat-messages" class="chat-messages">
                    <!-- Welcome Message -->
                    <div class="chat-bubble ai">
                        <div class="message-content ai">
                            <div class="flex items-center mb-2">
                                <x-base.lucide icon="Bot" class="w-4 h-4 mr-2 text-blue-600" />
                                <span class="font-medium text-xs md:text-sm">AI Assistant</span>
                                <span class="text-[10px] md:text-xs text-gray-400 ml-auto">{{ now()->format('H:i') }}</span>
                            </div>
                            <div class="mb-3">
                                <p class="text-xs md:text-sm">
                                    👋 Welcome! I can help you create tasks, materials, analyze data, and generate ERP-related content.
                                </p>
                            </div>
                            <div class="border-t border-slate-200 pt-3">
                                <p class="text-[11px] md:text-xs text-gray-500 mb-2">Quick suggestions:</p>
                                <div class="flex flex-wrap">
                                    <span class="suggestion-chip" onclick="useSuggestion('Create a task for website development')">Create a task</span>
                                    <span class="suggestion-chip" onclick="useSuggestion('Analyze sales performance this month')">Analyze sales</span>
                                    <span class="suggestion-chip" onclick="useSuggestion('Generate a monthly sales report')">Monthly report</span>
                                    <span class="suggestion-chip" onclick="useSuggestion('Draft an email to the accounting team')">Draft email</span>
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
                <div class="border-t border-slate-200/70 dark:border-darkmode-400 px-4 py-3 bg-white/80 dark:bg-darkmode-600/90 backdrop-blur">
                    <div class="flex items-end gap-3">
                        <div class="flex-1">
                            <x-base.form-textarea
                                id="message-input"
                                class="resize-none text-xs md:text-sm"
                                rows="1"
                                placeholder="Type your question or command..."
                                onkeydown="handleKeyPress(event)"
                                oninput="autoResize(this)"
                            ></x-base.form-textarea>
                            <div class="flex justify-between items-center mt-2">
                                <div class="text-[11px] md:text-xs text-gray-500">
                                    <span id="mode-indicator">💬 Chat Mode - General conversation</span>
                                </div>
                                <div class="text-[10px] md:text-xs text-gray-400">
                                    Enter to send · Shift+Enter for new line
                                </div>
                            </div>
                        </div>
                        <x-base.button
                            id="send-button"
                            type="button"
                            variant="primary"
                            class="rounded-full p-3 md:p-3.5 shadow-sm shadow-blue-500/20"
                            onclick="sendMessage()"
                            disabled
                        >
                            <x-base.lucide icon="Send" class="w-4 h-4 md:w-5 md:h-5" />
                        </x-base.button>
                    </div>

                    <!-- Quick Commands -->
                    <div id="quick-commands" class="mt-3 flex flex-wrap gap-2">
                        <button onclick="quickCommand('create task')" class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-[11px] md:text-xs hover:bg-blue-100 transition-colors border border-blue-100">
                            + Task
                        </button>
                        <button onclick="quickCommand('add material')" class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[11px] md:text-xs hover:bg-emerald-100 transition-colors border border-emerald-100">
                            + Material
                        </button>
                        <button onclick="quickCommand('generate report')" class="px-3 py-1 bg-purple-50 text-purple-700 rounded-full text-[11px] md:text-xs hover:bg-purple-100 transition-colors border border-purple-100">
                            📊 Report
                        </button>
                        <button onclick="quickCommand('analyze data')" class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-[11px] md:text-xs hover:bg-amber-100 transition-colors border border-amber-100">
                            📈 Analyze
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-span-12 xl:col-span-4 space-y-6">
            <!-- Recent Interactions -->
            <div class="bg-white dark:bg-darkmode-600 rounded-2xl p-5 shadow-sm border border-slate-200/70 dark:border-darkmode-400">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-sm md:text-base flex items-center gap-2">
                        <x-base.lucide icon="Clock" class="w-4 h-4 text-gray-600" />
                        Recent Interactions
                    </h3>
                </div>
                <div id="recent-interactions" class="space-y-3 max-h-64 overflow-y-auto pr-1">
                    <!-- Recent interactions will be loaded here -->
                    <div class="text-center py-4 text-gray-500 text-xs md:text-sm">
                        <x-base.lucide icon="Loader" class="w-5 h-5 mx-auto mb-2 animate-spin" />
                        Loading...
                    </div>
                </div>
            </div>

            <!-- AI Capabilities -->
            <div class="bg-white dark:bg-darkmode-600 rounded-2xl p-5 shadow-sm border border-slate-200/70 dark:border-darkmode-400">
                <h3 class="font-semibold mb-4 flex items-center text-sm md:text-base">
                    <x-base.lucide icon="Brain" class="w-5 h-5 mr-2 text-purple-600" />
                    AI Capabilities
                </h3>
                <div class="space-y-3 text-xs md:text-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-base.lucide icon="Plus" class="w-4 h-4 text-blue-600" />
                        </div>
                        <div>
                            <h4 class="font-medium text-sm">Content Creation</h4>
                            <p class="text-xs text-gray-600">Create tasks, materials, emails, and ERP documents from natural language.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-base.lucide icon="BarChart3" class="w-4 h-4 text-green-600" />
                        </div>
                        <div>
                            <h4 class="font-medium text-sm">Data Analysis</h4>
                            <p class="text-xs text-gray-600">Analyze sales, HR, and accounting data for trends and insights.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-base.lucide icon="Settings" class="w-4 h-4 text-purple-600" />
                        </div>
                        <div>
                            <h4 class="font-medium text-sm">Automation</h4>
                            <p class="text-xs text-gray-600">Trigger workflows and automate repetitive ERP operations.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <x-base.lucide icon="MessageSquare" class="w-4 h-4 text-amber-600" />
                        </div>
                        <div>
                            <h4 class="font-medium text-sm">Natural Chat</h4>
                            <p class="text-xs text-gray-600">Ask questions across modules and get contextual assistance.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Stats -->
            <div class="bg-white dark:bg-darkmode-600 rounded-2xl p-5 shadow-sm border border-slate-200/70 dark:border-darkmode-400">
                <h3 class="font-semibold mb-4 flex items-center text-sm md:text-base">
                    <x-base.lucide icon="TrendingUp" class="w-5 h-5 mr-2 text-green-600" />
                    Usage Statistics
                </h3>
                <div class="space-y-3 text-xs md:text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Interactions</span>
                        <span class="font-semibold" id="total-interactions">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Success Rate</span>
                        <span class="font-semibold text-emerald-600" id="success-rate">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Tokens Used</span>
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
