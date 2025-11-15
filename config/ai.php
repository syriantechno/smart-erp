<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenAI API Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your OpenAI API settings here. You can get your API key
    | from https://platform.openai.com/api-keys
    |
    */

    // Which provider to use: 'openai' or 'ollama'
    'provider' => env('AI_PROVIDER', 'openai'),

    // OpenAI settings (default)
    'api_key' => env('OPENAI_API_KEY'),
    'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
    'max_tokens' => env('OPENAI_MAX_TOKENS', 2000),
    'temperature' => env('OPENAI_TEMPERATURE', 0.7),

    // Ollama local server settings
    'ollama_base_url' => env('OLLAMA_BASE_URL', 'http://127.0.0.1:11434'),
    'ollama_model' => env('OLLAMA_MODEL', 'llama3'),

    /*
    |--------------------------------------------------------------------------
    | AI System Settings
    |--------------------------------------------------------------------------
    */

    'enabled' => env('AI_ENABLED', true),
    'max_daily_interactions' => env('AI_MAX_DAILY_INTERACTIONS', 100),
    'max_monthly_cost' => env('AI_MAX_MONTHLY_COST', 50.00), // in USD

    /*
    |--------------------------------------------------------------------------
    | Supported Commands
    |--------------------------------------------------------------------------
    |
    | Commands that AI can execute in the system
    |
    */

    'supported_commands' => [
        'create_task' => [
            'patterns' => ['create task', 'add task', 'new task'],
            'action' => 'create_task',
            'requires_confirmation' => false,
        ],
        'create_material' => [
            'patterns' => ['create material', 'add material', 'new material'],
            'action' => 'create_material',
            'requires_confirmation' => false,
        ],
        'generate_report' => [
            'patterns' => ['generate report', 'create report', 'make report'],
            'action' => 'generate_report',
            'requires_confirmation' => false,
        ],
        'send_email' => [
            'patterns' => ['send email', 'create email', 'write email'],
            'action' => 'send_email',
            'requires_confirmation' => true,
        ],
        'analyze_data' => [
            'patterns' => ['analyze', 'analysis', 'insights'],
            'action' => 'analyze_data',
            'requires_confirmation' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | AI Response Templates
    |--------------------------------------------------------------------------
    */

    'response_templates' => [
        'command_success' => "✅ **Command Executed Successfully**\n\n{result}\n\nIs there anything else I can help you with?",
        'command_failed' => "❌ **Command Failed**\n\n{error}\n\nPlease try rephrasing your request or contact support if the issue persists.",
        'analysis_complete' => "📊 **Analysis Complete**\n\n{result}\n\nWould you like me to generate a detailed report or perform additional analysis?",
        'content_generated' => "✨ **Content Generated**\n\n{result}\n\nYou can now use, edit, or save this content. Would you like me to make any adjustments?",
    ],
];
