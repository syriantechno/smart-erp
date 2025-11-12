@extends('themes.icewall.side-menu')

@section('subhead')
    <title>AI Assistant - {{ config('app.name') }}</title>
@endsection

@push('styles')
    <style>
        .ai-card {
            transition: transform 0.2s ease-in-out;
        }
        .ai-card:hover {
            transform: translateY(-2px);
        }
        .feature-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
        }
        .chat-bubble {
            max-width: 80%;
            margin-bottom: 1rem;
        }
        .chat-bubble.user {
            margin-left: auto;
            margin-right: 0;
        }
        .chat-bubble.ai {
            margin-left: 0;
            margin-right: auto;
        }
        .typing-indicator {
            display: none;
            padding: 1rem;
            color: #6b7280;
        }
        .typing-indicator.show {
            display: block;
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <!-- AI Status Check -->
    <div id="ai-status-alert" class="alert alert-warning mb-6" style="display: none;">
        <div class="flex items-center">
            <x-base.lucide icon="AlertTriangle" class="w-5 h-5 mr-2" />
            <span>AI Assistant is currently unavailable. Please check your API configuration.</span>
        </div>
    </div>

    <!-- AI Setup Alert -->
    <div id="ai-setup-alert" class="alert alert-info mb-6" style="display: none;">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-base.lucide icon="Settings" class="w-5 h-5 mr-2" />
                <div>
                    <h4 class="font-semibold">AI Setup Required</h4>
                    <p class="text-sm">To use the AI Assistant, you need to configure your OpenAI API key.</p>
                </div>
            </div>
            <button onclick="showSetupInstructions()" class="btn btn-primary btn-sm">Setup Instructions</button>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-12 gap-6">
        <!-- Welcome Section -->
        <div class="col-span-12">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">AI Assistant</h1>
                        <p class="text-blue-100 text-lg">Your intelligent ERP companion powered by advanced AI</p>
                    </div>
                    <div class="hidden md:block">
                        <x-base.lucide icon="Bot" class="w-16 h-16 text-white/80" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="ai-card bg-white rounded-lg p-6 shadow-sm border">
                        <div class="feature-icon bg-blue-100 text-blue-600">
                            <x-base.lucide icon="MessageSquare" class="w-6 h-6" />
                        </div>
                        <h3 class="text-lg font-semibold text-center mb-2">{{ $stats['total_interactions'] }}</h3>
                        <p class="text-gray-600 text-center">Total Interactions</p>
                    </div>
                </div>

                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="ai-card bg-white rounded-lg p-6 shadow-sm border">
                        <div class="feature-icon bg-green-100 text-green-600">
                            <x-base.lucide icon="CheckCircle" class="w-6 h-6" />
                        </div>
                        <h3 class="text-lg font-semibold text-center mb-2">{{ $stats['completed_interactions'] }}</h3>
                        <p class="text-gray-600 text-center">Completed</p>
                    </div>
                </div>

                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="ai-card bg-white rounded-lg p-6 shadow-sm border">
                        <div class="feature-icon bg-purple-100 text-purple-600">
                            <x-base.lucide icon="FileText" class="w-6 h-6" />
                        </div>
                        <h3 class="text-lg font-semibold text-center mb-2">{{ $stats['generated_content'] }}</h3>
                        <p class="text-gray-600 text-center">Generated Content</p>
                    </div>
                </div>

                <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="ai-card bg-white rounded-lg p-6 shadow-sm border">
                        <div class="feature-icon bg-yellow-100 text-yellow-600">
                            <x-base.lucide icon="Settings" class="w-6 h-6" />
                        </div>
                        <h3 class="text-lg font-semibold text-center mb-2">{{ $stats['active_automations'] }}</h3>
                        <p class="text-gray-600 text-center">Active Automations</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-span-12">
            <div class="bg-white rounded-lg p-6 shadow-sm border">
                <h2 class="text-xl font-semibold mb-6 flex items-center">
                    <x-base.lucide icon="Zap" class="w-6 h-6 mr-2 text-blue-600" />
                    Quick Actions
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button onclick="startChat()" class="p-4 border-2 border-blue-200 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-colors">
                        <x-base.lucide icon="MessageSquare" class="w-8 h-8 text-blue-600 mx-auto mb-2" />
                        <span class="text-sm font-medium text-gray-700">Start Chat</span>
                    </button>

                    <button onclick="showCommandMode()" class="p-4 border-2 border-green-200 rounded-lg hover:border-green-400 hover:bg-green-50 transition-colors">
                        <x-base.lucide icon="Terminal" class="w-8 h-8 text-green-600 mx-auto mb-2" />
                        <span class="text-sm font-medium text-gray-700">Execute Command</span>
                    </button>

                    <button onclick="showAnalysisMode()" class="p-4 border-2 border-purple-200 rounded-lg hover:border-purple-400 hover:bg-purple-50 transition-colors">
                        <x-base.lucide icon="BarChart3" class="w-8 h-8 text-purple-600 mx-auto mb-2" />
                        <span class="text-sm font-medium text-gray-700">Data Analysis</span>
                    </button>

                    <button onclick="showGenerationMode()" class="p-4 border-2 border-yellow-200 rounded-lg hover:border-yellow-400 hover:bg-yellow-50 transition-colors">
                        <x-base.lucide icon="FileText" class="w-8 h-8 text-yellow-600 mx-auto mb-2" />
                        <span class="text-sm font-medium text-gray-700">Generate Content</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- AI Capabilities -->
        <div class="col-span-12 lg:col-span-8">
            <div class="bg-white rounded-lg p-6 shadow-sm border">
                <h2 class="text-xl font-semibold mb-6 flex items-center">
                    <x-base.lucide icon="Brain" class="w-6 h-6 mr-2 text-purple-600" />
                    AI Capabilities
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-800 flex items-center">
                            <x-base.lucide icon="Plus" class="w-5 h-5 mr-2 text-green-600" />
                            Content Creation
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-600 ml-7">
                            <li>• Create tasks automatically</li>
                            <li>• Generate materials and inventory</li>
                            <li>• Draft emails and reports</li>
                            <li>• Create approval requests</li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-800 flex items-center">
                            <x-base.lucide icon="TrendingUp" class="w-5 h-5 mr-2 text-blue-600" />
                            Data Analysis
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-600 ml-7">
                            <li>• Generate business reports</li>
                            <li>• Analyze system performance</li>
                            <li>• Provide insights and recommendations</li>
                            <li>• Trend analysis and forecasting</li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-800 flex items-center">
                            <x-base.lucide icon="Settings" class="w-5 h-5 mr-2 text-orange-600" />
                            Automation
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-600 ml-7">
                            <li>• Workflow automation</li>
                            <li>• Data entry assistance</li>
                            <li>• Report generation</li>
                            <li>• Task scheduling</li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-800 flex items-center">
                            <x-base.lucide icon="MessageSquare" class="w-5 h-5 mr-2 text-indigo-600" />
                            Communication
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-600 ml-7">
                            <li>• Natural language queries</li>
                            <li>• Contextual assistance</li>
                            <li>• Multi-language support</li>
                            <li>• Real-time responses</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-span-12 lg:col-span-4">
            <div class="bg-white rounded-lg p-6 shadow-sm border">
                <h2 class="text-xl font-semibold mb-6 flex items-center">
                    <x-base.lucide icon="Clock" class="w-6 h-6 mr-2 text-gray-600" />
                    Recent Activity
                </h2>

                <div id="recent-activity" class="space-y-4">
                    <div class="text-center py-8 text-gray-500">
                        <x-base.lucide icon="Loader" class="w-8 h-8 mx-auto mb-2 animate-spin" />
                        <p>Loading recent activity...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Chat Modal -->
    <div id="ai-chat-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto flex items-center">
                        <x-base.lucide icon="Bot" class="w-5 h-5 mr-2 text-blue-600" />
                        AI Assistant Chat
                    </h2>
                    <div class="flex items-center space-x-2">
                        <select id="interaction-type" class="form-select text-sm">
                            <option value="chat">Chat</option>
                            <option value="command">Command</option>
                            <option value="analysis">Analysis</option>
                            <option value="generation">Generation</option>
                        </select>
                        <button type="button" class="text-slate-400 hover:text-slate-600" data-tw-dismiss="modal">
                            <x-base.lucide icon="X" class="w-6 h-6" />
                        </button>
                    </div>
                </div>
                <div class="modal-body p-0">
                    <div class="flex flex-col h-96">
                        <!-- Chat Messages -->
                        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
                            <div class="chat-bubble ai">
                                <div class="bg-gray-100 text-gray-800 p-3 rounded-lg max-w-md">
                                    <div class="flex items-center mb-2">
                                        <x-base.lucide icon="Bot" class="w-4 h-4 mr-2 text-blue-600" />
                                        <span class="font-medium text-sm">AI Assistant</span>
                                    </div>
                                    <p class="text-sm">Hello! I'm your AI assistant. I can help you with various tasks in the ERP system. Try asking me to create a task, analyze data, or generate a report!</p>
                                </div>
                            </div>
                        </div>

                        <!-- Typing Indicator -->
                        <div id="typing-indicator" class="typing-indicator">
                            <div class="flex items-center">
                                <x-base.lucide icon="Bot" class="w-4 h-4 mr-2 text-blue-600" />
                                <span>AI is typing...</span>
                                <div class="ml-2 flex space-x-1">
                                    <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce"></div>
                                    <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                    <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Input -->
                        <div class="border-t p-4">
                            <div class="flex space-x-2">
                                <input
                                    type="text"
                                    id="chat-input"
                                    class="flex-1 form-control"
                                    placeholder="Ask me anything..."
                                    onkeydown="handleChatKeyPress(event)"
                                />
                                <button
                                    onclick="sendMessage()"
                                    class="btn btn-primary px-6"
                                    id="send-btn"
                                >
                                    <x-base.lucide icon="Send" class="w-4 h-4" />
                                </button>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                Try: "Create a task for website development", "Generate a sales report", "Analyze employee performance"
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Setup Instructions Modal -->
    <div id="setup-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto flex items-center">
                        <x-base.lucide icon="Settings" class="w-5 h-5 mr-2 text-blue-600" />
                        AI Setup Instructions
                    </h2>
                    <button type="button" class="text-slate-400 hover:text-slate-600" data-tw-dismiss="modal">
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6">
                    <div class="space-y-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-900 mb-2">Step 1: Get OpenAI API Key</h3>
                            <p class="text-blue-800 text-sm mb-3">Visit <a href="https://platform.openai.com/api-keys" target="_blank" class="underline">OpenAI API Keys</a> and create a new API key.</p>
                            <div class="bg-white p-3 rounded border text-sm font-mono">
                                1. Go to https://platform.openai.com/api-keys<br>
                                2. Sign in or create an account<br>
                                3. Click "Create new secret key"<br>
                                4. Copy the API key (keep it safe!)
                            </div>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-900 mb-2">Step 2: Configure Your Application</h3>
                            <p class="text-green-800 text-sm mb-3">Add the API key to your environment file:</p>
                            <div class="bg-white p-3 rounded border text-sm font-mono">
                                # In your .env file<br>
                                OPENAI_API_KEY=sk-your-api-key-here<br>
                                OPENAI_MODEL=gpt-3.5-turbo<br>
                                OPENAI_MAX_TOKENS=2000<br>
                                OPENAI_TEMPERATURE=0.7
                            </div>
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-yellow-900 mb-2">Step 3: Test the AI</h3>
                            <p class="text-yellow-800 text-sm mb-3">After configuration, refresh this page and try the AI assistant.</p>
                            <div class="bg-white p-3 rounded border text-sm">
                                <strong>Example commands to try:</strong><br>
                                • "Create a task for website development"<br>
                                • "Add a new material: Laptop, price $1000"<br>
                                • "Generate a monthly sales report"<br>
                                • "Analyze employee performance"
                            </div>
                        </div>

                        <div class="bg-red-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-red-900 mb-2">Important Notes</h3>
                            <ul class="text-red-800 text-sm space-y-1">
                                <li>• Keep your API key secure and never share it</li>
                                <li>• OpenAI charges based on usage (very low cost for basic usage)</li>
                                <li>• You can set spending limits in your OpenAI account</li>
                                <li>• The system supports GPT-3.5-turbo for best performance</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-tw-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="testAIConnection()">Test Connection</button>
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
            loadRecentActivity();
        });

        function checkAIAvailability() {
            $.get('{{ route("ai.available") }}')
                .done(function(response) {
                    aiAvailable = response.available;

                    if (!aiAvailable) {
                        $('#ai-setup-alert').show();
                        // Disable all interactive buttons
                        $('.btn').not('.btn-secondary').prop('disabled', true).addClass('opacity-50');
                    } else {
                        $('#ai-status-banner').show();
                    }
                })
                .fail(function() {
                    $('#ai-setup-alert').show();
                    $('.btn').not('.btn-secondary').prop('disabled', true).addClass('opacity-50');
                });
        }

        function loadRecentActivity() {
            $.get('{{ route("ai.datatable") }}', {
                length: 5,
                start: 0
            })
            .done(function(response) {
                renderRecentActivity(response.data || []);
            });
        }

        function renderRecentActivity(interactions) {
            const container = $('#recent-activity');

            if (interactions.length === 0) {
                container.html('<div class="text-center py-4 text-gray-500 text-sm">No recent activity</div>');
                return;
            }

            let html = '';
            interactions.forEach(function(interaction) {
                const typeClass = getTypeClass(interaction.interaction_type);
                const statusClass = getStatusClass(interaction.status);

                html += `
                    <div class="flex items-start space-x-3 p-3 rounded-lg bg-gray-50">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 ${typeClass} rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-bold">${interaction.interaction_type.charAt(0).toUpperCase()}</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                ${interaction.user_input.substring(0, 50)}${interaction.user_input.length > 50 ? '...' : ''}
                            </p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${statusClass}">
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

        function getTypeClass(type) {
            switch(type) {
                case 'query': return 'bg-blue-500';
                case 'command': return 'bg-green-500';
                case 'analysis': return 'bg-purple-500';
                case 'generation': return 'bg-yellow-500';
                case 'chat': return 'bg-indigo-500';
                default: return 'bg-gray-500';
            }
        }

        function getStatusClass(status) {
            switch(status) {
                case 'completed': return 'bg-green-100 text-green-800';
                case 'processing': return 'bg-blue-100 text-blue-800';
                case 'failed': return 'bg-red-100 text-red-800';
                default: return 'bg-yellow-100 text-yellow-800';
            }
        }

        function startChat() {
            if (!aiAvailable) {
                showSetupInstructions();
                return;
            }

            currentSessionId = generateSessionId();
            $('#ai-chat-modal').modal('show');
            $('#chat-messages').empty();
            addMessage('Hello! I\'m your AI assistant. I can help you with various tasks in the ERP system. What would you like to do?', 'ai');
        }

        function showCommandMode() {
            if (!aiAvailable) {
                showSetupInstructions();
                return;
            }

            currentSessionId = generateSessionId();
            $('#interaction-type').val('command');
            $('#ai-chat-modal').modal('show');
            $('#chat-messages').empty();
            addMessage('Command Mode Activated! I can execute commands to create, update, or manage system data. Try commands like:', 'ai');
            addMessage('• "Create a task for project planning"<br>• "Add a new material: Laptop, price $1000"<br>• "Generate a sales report"', 'ai');
        }

        function showAnalysisMode() {
            if (!aiAvailable) {
                showSetupInstructions();
                return;
            }

            currentSessionId = generateSessionId();
            $('#interaction-type').val('analysis');
            $('#ai-chat-modal').modal('show');
            $('#chat-messages').empty();
            addMessage('Analysis Mode Activated! I can analyze your ERP data and provide insights. Try asking for:', 'ai');
            addMessage('• "Analyze sales performance"<br>• "Generate employee productivity report"<br>• "Show inventory trends"', 'ai');
        }

        function showGenerationMode() {
            if (!aiAvailable) {
                showSetupInstructions();
                return;
            }

            currentSessionId = generateSessionId();
            $('#interaction-type').val('generation');
            $('#ai-chat-modal').modal('show');
            $('#chat-messages').empty();
            addMessage('Content Generation Mode! I can create various types of content. Try:', 'ai');
            addMessage('• "Write an email about project update"<br>• "Create a monthly report template"<br>• "Generate meeting agenda"', 'ai');
        }

        function showSetupInstructions() {
            $('#setup-modal').modal('show');
        }

        function testAIConnection() {
            $('#setup-modal button').prop('disabled', true);
            $('#setup-modal button:last').text('Testing...');

            $.post('{{ route("ai.interact") }}', {
                message: 'Hello, this is a test message to verify AI connection.',
                type: 'chat',
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Connection Successful!',
                        text: 'AI is working correctly. You can now use all AI features.',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); // Reload to enable buttons
                    });
                } else {
                    Swal.fire('Connection Failed', response.error || 'Unable to connect to AI service', 'error');
                }
            })
            .fail(function(xhr) {
                Swal.fire('Connection Failed', 'Unable to connect to AI service. Please check your API key configuration.', 'error');
            })
            .always(function() {
                $('#setup-modal button').prop('disabled', false);
                $('#setup-modal button:last').text('Test Connection');
            });
        }

        function sendMessage() {
            const input = $('#chat-input');
            const message = input.val().trim();

            if (!message) return;

            addMessage(message, 'user');
            input.val('');

            // Show typing indicator
            $('#typing-indicator').addClass('show');

            const interactionType = $('#interaction-type').val();

            $.post('{{ route("ai.interact") }}', {
                message: message,
                type: interactionType,
                session_id: currentSessionId,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                $('#typing-indicator').removeClass('show');

                if (response.success) {
                    addMessage(response.response, 'ai');

                    // Handle command results
                    if (response.metadata && response.metadata.command_result) {
                        const result = response.metadata.command_result;
                        if (result.type) {
                            addMessage(`✅ ${result.message}`, 'ai', 'success');
                        }
                    }

                    // Refresh activity
                    loadRecentActivity();
                } else {
                    addMessage(response.error || 'Sorry, I encountered an error processing your request.', 'ai', 'error');
                }
            })
            .fail(function(xhr) {
                $('#typing-indicator').removeClass('show');
                const error = xhr.responseJSON?.error || 'Network error occurred';
                addMessage(`❌ ${error}`, 'ai', 'error');
            });
        }

        function addMessage(content, sender, type = 'normal') {
            const messagesContainer = $('#chat-messages');
            const messageClass = sender === 'user' ? 'user' : 'ai';
            const bgClass = type === 'success' ? 'bg-green-100' :
                           type === 'error' ? 'bg-red-100' : 'bg-white';

            const messageHtml = `
                <div class="chat-bubble ${messageClass}">
                    <div class="${bgClass} p-3 rounded-lg shadow-sm max-w-lg">
                        <div class="flex items-center mb-1">
                            ${sender === 'ai' ?
                                '<x-base.lucide icon="Bot" class="w-4 h-4 mr-2 text-blue-600" />' :
                                '<x-base.lucide icon="User" class="w-4 h-4 mr-2 text-green-600" />'
                            }
                            <span class="font-medium text-sm">${sender === 'ai' ? 'AI Assistant' : 'You'}</span>
                        </div>
                        <div class="text-sm">${content}</div>
                    </div>
                </div>
            `;

            messagesContainer.append(messageHtml);
            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);

            // Reinitialize Lucide icons
            lucide.createIcons();
        }

        function handleChatKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        function generateSessionId() {
            return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        }

        // Global functions for quick actions
        window.startChat = startChat;
        window.showCommandMode = showCommandMode;
        window.showAnalysisMode = showAnalysisMode;
        window.showGenerationMode = showGenerationMode;
    </script>
@endpush
