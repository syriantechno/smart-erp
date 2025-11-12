<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\AiInteraction;
use App\Models\AiGeneratedContent;

class AiService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->baseUrl = 'https://api.openai.com/v1';
        $this->model = config('services.openai.model', 'gpt-3.5-turbo');
    }

    /**
     * Generate AI response for user query
     */
    public function generateResponse(string $userInput, array $context = [], string $type = 'chat'): array
    {
        try {
            $systemPrompt = $this->buildSystemPrompt($type, $context);
            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userInput]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/chat/completions", [
                'model' => $this->model,
                'messages' => $messages,
                'max_tokens' => 2000,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiResponse = $data['choices'][0]['message']['content'];
                $tokensUsed = $data['usage']['total_tokens'];
                $cost = $this->calculateCost($tokensUsed);

                return [
                    'success' => true,
                    'response' => $aiResponse,
                    'metadata' => [
                        'model' => $this->model,
                        'tokens_used' => $tokensUsed,
                        'cost' => $cost,
                    ]
                ];
            } else {
                Log::error('OpenAI API Error: ' . $response->body());
                return [
                    'success' => false,
                    'error' => 'Failed to get AI response',
                    'details' => $response->json()
                ];
            }
        } catch (\Exception $e) {
            Log::error('AI Service Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'AI service unavailable',
                'details' => $e->getMessage()
            ];
        }
    }

    /**
     * Execute AI command to create/edit system entities
     */
    public function executeCommand(string $command, array $context = []): array
    {
        // Parse the command and determine what to do
        $command = strtolower(trim($command));

        if (str_contains($command, 'create task') || str_contains($command, 'add task')) {
            return $this->createTaskFromCommand($command, $context);
        }

        if (str_contains($command, 'create material') || str_contains($command, 'add material')) {
            return $this->createMaterialFromCommand($command, $context);
        }

        if (str_contains($command, 'generate report') || str_contains($command, 'create report')) {
            return $this->generateReportFromCommand($command, $context);
        }

        if (str_contains($command, 'send email') || str_contains($command, 'create email')) {
            return $this->createEmailFromCommand($command, $context);
        }

        if (str_contains($command, 'analyze') || str_contains($command, 'analysis')) {
            return $this->performAnalysisFromCommand($command, $context);
        }

        // Default to general AI response
        return $this->generateResponse($command, $context, 'command');
    }

    /**
     * Create task from AI command
     */
    protected function createTaskFromCommand(string $command, array $context): array
    {
        // Extract task details from command using AI
        $extractionPrompt = "Extract task information from this command: '{$command}'. Return JSON with: title, description, priority (low/medium/high), due_date (if mentioned)";

        $result = $this->generateResponse($extractionPrompt, [], 'extraction');

        if (!$result['success']) {
            return $result;
        }

        try {
            $taskData = json_decode($result['response'], true);

            if (!$taskData || !isset($taskData['title'])) {
                return [
                    'success' => false,
                    'error' => 'Could not extract task information from command'
                ];
            }

            // Create the task
            $task = \App\Models\Task::create([
                'code' => app(\App\Services\DocumentCodeGenerator::class)->generate('tasks'),
                'title' => $taskData['title'],
                'description' => $taskData['description'] ?? null,
                'priority' => $taskData['priority'] ?? 'medium',
                'status' => 'pending',
                'due_date' => isset($taskData['due_date']) ? \Carbon\Carbon::parse($taskData['due_date']) : null,
                'assigned_by' => $context['user_id'] ?? auth()->id(),
                'is_active' => true,
            ]);

            return [
                'success' => true,
                'message' => 'Task created successfully',
                'data' => $task,
                'type' => 'task_created'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to create task: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create material from AI command
     */
    protected function createMaterialFromCommand(string $command, array $context): array
    {
        $extractionPrompt = "Extract material information from this command: '{$command}'. Return JSON with: name, description, unit (piece/kg/liter/etc), price";

        $result = $this->generateResponse($extractionPrompt, [], 'extraction');

        if (!$result['success']) {
            return $result;
        }

        try {
            $materialData = json_decode($result['response'], true);

            if (!$materialData || !isset($materialData['name'])) {
                return [
                    'success' => false,
                    'error' => 'Could not extract material information from command'
                ];
            }

            // Find or create category
            $category = \App\Models\Category::firstOrCreate(
                ['name' => 'General'],
                ['code' => 'CAT001', 'description' => 'General category']
            );

            $material = \App\Models\Material::create([
                'code' => app(\App\Services\DocumentCodeGenerator::class)->generate('materials'),
                'name' => $materialData['name'],
                'description' => $materialData['description'] ?? null,
                'category_id' => $category->id,
                'unit' => $materialData['unit'] ?? 'piece',
                'price' => $materialData['price'] ?? 0,
                'is_active' => true,
            ]);

            return [
                'success' => true,
                'message' => 'Material created successfully',
                'data' => $material,
                'type' => 'material_created'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to create material: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Generate report from AI command
     */
    protected function generateReportFromCommand(string $command, array $context): array
    {
        // Analyze system data and generate insights
        $dataSummary = $this->getSystemDataSummary();

        $reportPrompt = "Generate a comprehensive report based on this system data: {$dataSummary}. Command: {$command}";

        $result = $this->generateResponse($reportPrompt, $context, 'analysis');

        if ($result['success']) {
            // Save generated content
            AiGeneratedContent::create([
                'content_type' => 'report',
                'content_title' => 'AI Generated Report',
                'generated_content' => $result['response'],
                'parameters_used' => ['command' => $command, 'context' => $context],
                'user_id' => $context['user_id'] ?? auth()->id(),
            ]);

            $result['type'] = 'report_generated';
        }

        return $result;
    }

    /**
     * Create email from AI command
     */
    protected function createEmailFromCommand(string $command, array $context): array
    {
        $extractionPrompt = "Extract email information from this command: '{$command}'. Return JSON with: subject, recipient_name, content";

        $result = $this->generateResponse($extractionPrompt, [], 'extraction');

        if (!$result['success']) {
            return $result;
        }

        try {
            $emailData = json_decode($result['response'], true);

            if (!$emailData || !isset($emailData['subject'])) {
                return [
                    'success' => false,
                    'error' => 'Could not extract email information from command'
                ];
            }

            $email = \App\Models\ElectronicMail::create([
                'code' => app(\App\Services\DocumentCodeGenerator::class)->generate('electronic_mails'),
                'subject' => $emailData['subject'],
                'content' => $emailData['content'] ?? 'Generated by AI Assistant',
                'type' => 'outgoing',
                'status' => 'draft', // Save as draft first
                'priority' => 'normal',
                'sender_name' => auth()->user()->name,
                'sender_email' => auth()->user()->email,
                'sender_user_id' => auth()->id(),
                'recipient_name' => $emailData['recipient_name'] ?? 'Recipient',
            ]);

            return [
                'success' => true,
                'message' => 'Email draft created successfully',
                'data' => $email,
                'type' => 'email_created'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to create email: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Perform data analysis
     */
    protected function performAnalysisFromCommand(string $command, array $context): array
    {
        $dataSummary = $this->getSystemDataSummary();

        $analysisPrompt = "Analyze this ERP system data and provide insights: {$dataSummary}. Specific request: {$command}";

        $result = $this->generateResponse($analysisPrompt, $context, 'analysis');

        if ($result['success']) {
            AiGeneratedContent::create([
                'content_type' => 'analysis',
                'content_title' => 'AI Data Analysis',
                'generated_content' => $result['response'],
                'parameters_used' => ['command' => $command, 'data_summary' => $dataSummary],
                'user_id' => $context['user_id'] ?? auth()->id(),
            ]);

            $result['type'] = 'analysis_completed';
        }

        return $result;
    }

    /**
     * Get system data summary for AI context
     */
    protected function getSystemDataSummary(): string
    {
        try {
            $stats = [
                'users' => \App\Models\User::count(),
                'tasks' => \App\Models\Task::count(),
                'materials' => \App\Models\Material::count(),
                'warehouses' => \App\Models\Warehouse::count(),
                'approval_requests' => \App\Models\ApprovalRequest::count(),
                'emails' => \App\Models\ElectronicMail::count(),
                'companies' => \App\Models\Company::count(),
                'departments' => \App\Models\Department::count(),
                'employees' => \App\Models\Employee::count(),
            ];

            return "System Statistics: " . json_encode($stats);

        } catch (\Exception $e) {
            return "Unable to retrieve system statistics";
        }
    }

    /**
     * Build system prompt based on interaction type
     */
    protected function buildSystemPrompt(string $type, array $context = []): string
    {
        $basePrompt = "You are an AI assistant for an ERP (Enterprise Resource Planning) system. ";

        switch ($type) {
            case 'command':
                return $basePrompt . "You can execute commands to create, update, or analyze system data. Available actions include:
                - Creating tasks, materials, emails, and reports
                - Analyzing system data and generating insights
                - Generating content and automating workflows
                Always confirm actions and provide clear feedback.";

            case 'analysis':
                return $basePrompt . "You are analyzing ERP system data. Provide insights, trends, and recommendations based on the available data. Be specific and actionable.";

            case 'generation':
                return $basePrompt . "Generate content for the ERP system such as reports, emails, documentation, or other business content.";

            default:
                return $basePrompt . "Help users with their ERP system tasks, provide information, and assist with system operations.";
        }
    }

    /**
     * Calculate API cost based on tokens used
     */
    protected function calculateCost(int $tokens): float
    {
        // OpenAI pricing (approximate)
        $costPerThousandTokens = 0.002; // For GPT-3.5-turbo
        return ($tokens / 1000) * $costPerThousandTokens;
    }

    /**
     * Check if AI service is available
     */
    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }
}
