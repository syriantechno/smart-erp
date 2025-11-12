<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AiInteraction;
use App\Models\AiAutomation;
use App\Models\AiGeneratedContent;
use App\Models\User;

class AiSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@erp.com')->first();

        if (!$admin) {
            $this->command->error('Admin user not found. Please run AdminUserSeeder first.');
            return;
        }

        // Create sample AI interactions
        $interactions = [
            [
                'session_id' => 'session_' . now()->timestamp . '_001',
                'interaction_type' => 'chat',
                'user_input' => 'Hello, can you help me with my ERP system?',
                'ai_response' => 'Hello! Yes, I\'m your AI assistant for the ERP system. I can help you with various tasks like creating content, analyzing data, executing commands, and answering questions about your system.',
                'status' => 'completed',
                'model_used' => 'gpt-3.5-turbo',
                'tokens_used' => 150,
                'cost' => 0.00225,
            ],
            [
                'session_id' => 'session_' . now()->timestamp . '_002',
                'interaction_type' => 'command',
                'user_input' => 'Create a task for website development',
                'ai_response' => 'I\'ll create a task for website development. Let me extract the details and create it in your system.',
                'status' => 'completed',
                'model_used' => 'gpt-3.5-turbo',
                'tokens_used' => 200,
                'cost' => 0.00300,
                'metadata' => [
                    'command_result' => [
                        'success' => true,
                        'type' => 'task_created',
                        'message' => 'Task "Website Development" created successfully'
                    ]
                ]
            ],
            [
                'session_id' => 'session_' . now()->timestamp . '_003',
                'interaction_type' => 'analysis',
                'user_input' => 'Analyze my system performance',
                'ai_response' => 'Based on your ERP system data, here\'s a performance analysis:\n\n📊 **System Overview**\n- Total Users: 1\n- Active Tasks: 0\n- Materials: 0\n- Recent Activity: Low\n\n💡 **Recommendations**\n1. Start by creating some tasks and materials\n2. Monitor user activity\n3. Set up automated reports\n\nWould you like me to generate a detailed report?',
                'status' => 'completed',
                'model_used' => 'gpt-3.5-turbo',
                'tokens_used' => 300,
                'cost' => 0.00450,
            ],
            [
                'session_id' => 'session_' . now()->timestamp . '_004',
                'interaction_type' => 'generation',
                'user_input' => 'Write an email about project update',
                'ai_response' => 'Subject: Project Update - [Current Date]\n\nDear Team,\n\nI hope this email finds you well. I wanted to provide you with an important update on our current projects.\n\n**Key Updates:**\n• All major milestones have been completed on schedule\n• Quality assurance testing is underway\n• Expected completion date remains [Date]\n\n**Next Steps:**\n• Final review meeting scheduled for next week\n• Documentation will be completed by end of month\n• Training sessions for end-users to begin soon\n\nPlease let me know if you have any questions or concerns. I\'m happy to discuss any aspect of the project in more detail.\n\nBest regards,\n[Your Name]\nProject Manager',
                'status' => 'completed',
                'model_used' => 'gpt-3.5-turbo',
                'tokens_used' => 400,
                'cost' => 0.00600,
            ],
            [
                'session_id' => 'session_' . now()->timestamp . '_005',
                'interaction_type' => 'query',
                'user_input' => 'What features does this ERP system have?',
                'ai_response' => 'Your ERP system includes several powerful modules:\n\n🏭 **Warehouse Management**\n• Materials management\n• Inventory tracking\n• Purchase/Sale orders\n• Categories and warehouses\n\n📋 **Task Management**\n• Project task creation\n• Assignment and tracking\n• Priority and status management\n\n👥 **Human Resources**\n• Employee management\n• Departments and positions\n• Attendance tracking\n• Payroll system\n\n📧 **Communication**\n• Internal chat system\n• Email integration\n• Approval workflows\n\n🤖 **AI Assistant** (Me!)\n• Intelligent content creation\n• Data analysis and insights\n• Automated workflows\n• Natural language commands\n\nIs there a specific area you\'d like to know more about?',
                'status' => 'completed',
                'model_used' => 'gpt-3.5-turbo',
                'tokens_used' => 350,
                'cost' => 0.00525,
            ],
        ];

        foreach ($interactions as $interactionData) {
            $interactionData['user_id'] = $admin->id;
            AiInteraction::create($interactionData);
        }

        // Create sample AI automations
        $automations = [
            [
                'name' => 'Daily Sales Report',
                'description' => 'Automatically generate daily sales reports',
                'automation_type' => 'report_generation',
                'configuration' => [
                    'schedule' => 'daily',
                    'time' => '09:00',
                    'recipients' => ['admin@erp.com'],
                    'template' => 'sales_summary'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Low Stock Alerts',
                'description' => 'Alert when materials are running low',
                'automation_type' => 'workflow_automation',
                'configuration' => [
                    'threshold' => 10,
                    'materials' => ['all'],
                    'notification_method' => 'email',
                    'frequency' => 'daily'
                ],
                'is_active' => false,
            ],
            [
                'name' => 'Task Due Date Reminders',
                'description' => 'Send reminders for upcoming task deadlines',
                'automation_type' => 'workflow_automation',
                'configuration' => [
                    'days_before' => 3,
                    'reminder_type' => 'email',
                    'assignees_only' => true
                ],
                'is_active' => true,
            ],
        ];

        foreach ($automations as $automationData) {
            $automationData['created_by'] = $admin->id;
            AiAutomation::create($automationData);
        }

        // Create sample generated content
        $generatedContent = [
            [
                'content_type' => 'email',
                'content_title' => 'Welcome Email Template',
                'generated_content' => 'Subject: Welcome to Our Team!\n\nDear [Employee Name],\n\nWelcome to our organization! We are excited to have you join our team.\n\nYour start date is [Start Date], and you will be working in the [Department] department under [Manager Name].\n\nPlease find attached your employee handbook and other important documents.\n\nIf you have any questions, feel free to reach out to HR.\n\nBest regards,\nHR Team',
                'parameters_used' => ['type' => 'welcome_email', 'template' => true],
            ],
            [
                'content_type' => 'report',
                'content_title' => 'Monthly Performance Analysis',
                'generated_content' => '# Monthly Performance Report - ' . now()->format('F Y') . '\n\n## Executive Summary\nThis report provides an analysis of system performance and key metrics.\n\n## Key Metrics\n- **Total Users**: Growing steadily\n- **Task Completion Rate**: 85%\n- **System Uptime**: 99.9%\n- **User Satisfaction**: High\n\n## Recommendations\n1. Continue monitoring performance\n2. Implement suggested improvements\n3. Regular system maintenance\n\n## Conclusion\nOverall system performance is excellent with room for optimization.',
                'parameters_used' => ['period' => 'monthly', 'metrics' => ['users', 'tasks', 'performance']],
            ],
            [
                'content_type' => 'task',
                'content_title' => 'System Optimization Tasks',
                'generated_content' => '## System Optimization Tasks\n\n### High Priority\n1. **Database Optimization**\n   - Analyze query performance\n   - Optimize indexes\n   - Clean up old data\n\n2. **Security Updates**\n   - Update dependencies\n   - Review access controls\n   - Implement 2FA\n\n### Medium Priority\n3. **User Interface Improvements**\n   - Enhance mobile responsiveness\n   - Add dark mode toggle\n   - Improve loading speeds\n\n### Low Priority\n4. **Feature Enhancements**\n   - Add export functionality\n   - Implement notifications\n   - Create user guides',
                'parameters_used' => ['category' => 'optimization', 'priority_levels' => ['high', 'medium', 'low']],
            ],
        ];

        foreach ($generatedContent as $contentData) {
            $contentData['user_id'] = $admin->id;
            AiGeneratedContent::create($contentData);
        }

        $this->command->info('AI system data seeded successfully!');
        $this->command->info('Created ' . count($interactions) . ' AI interactions');
        $this->command->info('Created ' . count($automations) . ' AI automations');
        $this->command->info('Created ' . count($generatedContent) . ' generated content samples');
    }
}
