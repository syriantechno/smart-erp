# AI Assistant Documentation

## Overview
The AI Assistant is an intelligent conversational interface powered by OpenAI's GPT-3.5 Turbo, designed to help users interact with the ERP system through natural language commands and queries.

## Features

### 🤖 Core Capabilities
- **Natural Language Processing**: Understands and responds to natural language queries
- **Command Execution**: Executes system commands through AI
- **Content Generation**: Creates emails, reports, and other documents
- **Data Analysis**: Provides insights and analytics
- **Contextual Help**: Assists with system operations

### 💬 Interaction Modes
1. **Chat Mode**: General conversation and assistance
2. **Command Mode**: Execute specific system commands
3. **Analysis Mode**: Data analysis and reporting
4. **Generation Mode**: Content creation and drafting

## Technical Implementation

### Database Schema
```sql
-- AI Interactions Table
CREATE TABLE ai_interactions (
    id BIGINT PRIMARY KEY,
    session_id VARCHAR(255),
    interaction_type ENUM('query', 'command', 'analysis', 'generation', 'chat'),
    user_input TEXT,
    ai_response TEXT NULL,
    metadata JSON NULL,
    status ENUM('pending', 'processing', 'completed', 'failed') DEFAULT 'pending',
    model_used VARCHAR(255) NULL,
    tokens_used INT DEFAULT 0,
    cost DECIMAL(8,4) DEFAULT 0,
    user_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- AI Automations Table
CREATE TABLE ai_automations (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    automation_type ENUM('data_entry', 'report_generation', 'analysis', 'workflow_automation'),
    configuration JSON,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- AI Generated Content Table
CREATE TABLE ai_generated_contents (
    id BIGINT PRIMARY KEY,
    content_type VARCHAR(255),
    content_title VARCHAR(255),
    generated_content TEXT,
    parameters_used JSON NULL,
    quality_rating ENUM('poor', 'fair', 'good', 'excellent') NULL,
    user_feedback TEXT NULL,
    interaction_id BIGINT NULL,
    user_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Models

#### AiInteraction Model
```php
class AiInteraction extends Model
{
    protected $fillable = [
        'session_id', 'interaction_type', 'user_input', 'ai_response',
        'metadata', 'status', 'model_used', 'tokens_used', 'cost', 'user_id'
    ];

    protected $casts = [
        'metadata' => 'array',
        'tokens_used' => 'integer',
        'cost' => 'decimal:4'
    ];

    // Relationships
    public function user() { return $this->belongsTo(User::class); }
    public function generatedContent() { return $this->hasMany(AiGeneratedContent::class, 'interaction_id'); }

    // Scopes
    public function scopeCompleted($query) { return $query->where('status', 'completed'); }
    public function scopeByType($query, $type) { return $query->where('interaction_type', $type); }
    public function scopeForUser($query, $userId) { return $query->where('user_id', $userId); }
}
```

### AI Service Class
```php
class AiService
{
    public function generateResponse(string $userInput, array $context = [], string $type = 'chat'): array
    public function executeCommand(string $command, array $context = []): array
    protected function buildSystemPrompt(string $type, array $context = []): string
    protected function calculateCost(int $tokens): float
    public function isAvailable(): bool
}
```

## Configuration

### Environment Variables
```env
# AI Configuration
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_MODEL=gpt-3.5-turbo
OPENAI_MAX_TOKENS=2000
OPENAI_TEMPERATURE=0.7

# AI System Settings
AI_ENABLED=true
AI_MAX_DAILY_INTERACTIONS=100
AI_MAX_MONTHLY_COST=50.00
```

### Config File (config/ai.php)
```php
return [
    'api_key' => env('OPENAI_API_KEY'),
    'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
    'max_tokens' => env('OPENAI_MAX_TOKENS', 2000),
    'temperature' => env('OPENAI_TEMPERATURE', 0.7),

    'enabled' => env('AI_ENABLED', true),
    'max_daily_interactions' => env('AI_MAX_DAILY_INTERACTIONS', 100),
    'max_monthly_cost' => env('AI_MAX_MONTHLY_COST', 50.00),

    'supported_commands' => [
        'create_task' => [
            'patterns' => ['create task', 'add task', 'new task'],
            'action' => 'create_task',
            'requires_confirmation' => false,
        ],
        // ... more commands
    ],

    'response_templates' => [
        'command_success' => "✅ **Command Executed Successfully**\n\n{result}\n\nIs there anything else I can help you with?",
        'command_failed' => "❌ **Command Failed**\n\n{error}\n\nPlease try rephrasing your request or contact support if the issue persists.",
        // ... more templates
    ],
];
```

## API Endpoints

### Interact with AI
```http
POST /ai/interact
Content-Type: application/json

{
    "message": "Create a task for website development",
    "type": "command",
    "session_id": "session_123",
    "context": {
        "user_id": 1,
        "company_id": 1
    }
}
```

**Response:**
```json
{
    "success": true,
    "response": "✅ Task created successfully: Website Development",
    "interaction_id": 123,
    "metadata": {
        "model": "gpt-3.5-turbo",
        "tokens_used": 150,
        "cost": 0.00225
    }
}
```

### Check AI Availability
```http
GET /ai/available
```

**Response:**
```json
{
    "available": true
}
```

### Get AI Interactions
```http
GET /ai/datatable?type_filter=command&status_filter=completed
```

## Usage Examples

### Creating Tasks
**User Input:** "Create a task for website development due next week"
**AI Response:** "✅ Task created successfully: Website Development (Due: 2024-11-19)"

### Data Analysis
**User Input:** "Analyze sales performance this month"
**AI Response:** "📊 Sales Analysis:\n\n• Total Sales: $45,230\n• Growth Rate: +12%\n• Top Product: Product A\n• Recommendations: Focus on Product A marketing"

### Content Generation
**User Input:** "Write an email about project update"
**AI Response:** "📧 Generated Email:\n\nSubject: Project Update - November 2024\n\nDear Team,\n\nI wanted to provide you with an update on our current projects...\n\n[Full email content]"

## Command Patterns

### Task Creation Commands
- "Create a task for [description]"
- "Add task: [description]"
- "New task [description] due [date]"

### Material Commands
- "Create material: [name], price $[amount]"
- "Add new material [name] costing $[amount]"
- "New inventory item: [name]"

### Report Commands
- "Generate [type] report"
- "Create report for [period]"
- "Analyze [metric] and create report"

### Email Commands
- "Write email to [recipient] about [subject]"
- "Create email: [subject]"
- "Draft message about [topic]"

## Error Handling

### Common Errors
- **API Key Missing**: "AI Assistant is not configured. Please set up your OpenAI API key."
- **Quota Exceeded**: "OpenAI API quota exceeded. Please check your billing."
- **Network Error**: "Unable to connect to AI service. Please check your internet connection."
- **Invalid Command**: "I didn't understand that command. Try rephrasing or use a different format."

### Error Response Format
```json
{
    "success": false,
    "error": "API quota exceeded",
    "details": {
        "error_code": "insufficient_quota",
        "suggestion": "Check your OpenAI billing settings"
    }
}
```

## Security Considerations

### API Key Protection
- Never store API keys in code repositories
- Use environment variables for configuration
- Rotate API keys regularly
- Monitor API usage and costs

### Input Validation
- Sanitize user inputs before sending to AI
- Limit input length (max 2000 characters)
- Filter potentially harmful commands
- Log all AI interactions for audit

### Rate Limiting
- Implement daily and monthly limits
- Monitor API costs
- Alert when approaching limits
- Graceful degradation when limits exceeded

## Performance Optimization

### Caching
- Cache frequently used AI responses
- Store common command patterns
- Cache system data summaries

### Background Processing
```php
// Process AI requests asynchronously
dispatch(new ProcessAiInteraction($interaction));
```

### Database Optimization
- Index frequently queried columns
- Archive old interactions
- Use database partitioning for large datasets

## Monitoring & Analytics

### Key Metrics
- **Interaction Count**: Total AI interactions
- **Success Rate**: Percentage of successful responses
- **Response Time**: Average AI response time
- **Cost Tracking**: API usage costs
- **User Engagement**: Most used features

### Logging
```php
Log::info('AI Interaction', [
    'user_id' => $userId,
    'type' => $interactionType,
    'input_length' => strlen($input),
    'response_length' => strlen($response),
    'tokens_used' => $tokens,
    'cost' => $cost
]);
```

## Future Enhancements

### Planned Features
- **Custom AI Models**: Fine-tuned models for specific domains
- **Voice Integration**: Voice commands and responses
- **Multi-language Support**: Support for multiple languages
- **Advanced Analytics**: Deeper insights and predictions
- **Integration APIs**: Connect with external systems

### Integration Points
- **CRM Integration**: Customer data analysis
- **Inventory Optimization**: AI-powered stock management
- **Financial Forecasting**: Predictive analytics
- **HR Analytics**: Employee performance insights

## Troubleshooting

### Debug Mode
Enable debug mode in `.env`:
```env
AI_DEBUG=true
```

### Common Issues
1. **Slow Responses**: Check internet connection and API status
2. **Cost Overruns**: Set up billing alerts in OpenAI dashboard
3. **Rate Limits**: Implement request queuing and retry logic
4. **Content Quality**: Adjust temperature and prompt engineering

### Support Resources
- [OpenAI API Documentation](https://platform.openai.com/docs)
- [Laravel Broadcasting](https://laravel.com/docs/broadcasting)
- [System Logs](storage/logs/laravel.log)

---

**Last Updated:** November 12, 2024
**Version:** 1.0.0
