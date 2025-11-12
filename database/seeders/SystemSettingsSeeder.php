<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            // System Basic Settings
            [
                'key' => 'app_name',
                'value' => 'Smart ERP System',
                'type' => 'string',
                'description' => 'Application name displayed in the system'
            ],
            [
                'key' => 'app_version',
                'value' => '1.0.0',
                'type' => 'string',
                'description' => 'Current application version'
            ],
            [
                'key' => 'unified_code',
                'value' => 'ERP-2024',
                'type' => 'string',
                'description' => 'Unified code for the ERP system'
            ],

            // Theme & Appearance Settings
            [
                'key' => 'theme',
                'value' => 'icewall',
                'type' => 'string',
                'description' => 'Selected theme (icewall, enigma, rubick, tinker)'
            ],
            [
                'key' => 'layout',
                'value' => 'side-menu',
                'type' => 'string',
                'description' => 'Layout type (side-menu, top-menu, simple-menu)'
            ],
            [
                'key' => 'dark_mode',
                'value' => false,
                'type' => 'boolean',
                'description' => 'Enable dark mode'
            ],
            [
                'key' => 'primary_color',
                'value' => '#1e40af',
                'type' => 'string',
                'description' => 'Primary theme color'
            ],
            [
                'key' => 'secondary_color',
                'value' => '#7c3aed',
                'type' => 'string',
                'description' => 'Secondary theme color'
            ],
            [
                'key' => 'accent_color',
                'value' => '#06b6d4',
                'type' => 'string',
                'description' => 'Accent theme color'
            ],
            [
                'key' => 'font_size',
                'value' => 'medium',
                'type' => 'string',
                'description' => 'Font size preference (small, medium, large, extra-large)'
            ],
            [
                'key' => 'sidebar_collapsed',
                'value' => false,
                'type' => 'boolean',
                'description' => 'Sidebar collapsed state'
            ],
            [
                'key' => 'animations_enabled',
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable animations and transitions'
            ],

            // Email Settings
            [
                'key' => 'mail_driver',
                'value' => 'smtp',
                'type' => 'string',
                'description' => 'Mail driver configuration'
            ],
            [
                'key' => 'mail_host',
                'value' => 'smtp.gmail.com',
                'type' => 'string',
                'description' => 'SMTP host'
            ],
            [
                'key' => 'mail_port',
                'value' => '587',
                'type' => 'string',
                'description' => 'SMTP port'
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'tls',
                'type' => 'string',
                'description' => 'Mail encryption type'
            ],

            // Document Settings
            [
                'key' => 'default_document_access',
                'value' => 'private',
                'type' => 'string',
                'description' => 'Default document access level'
            ],
            [
                'key' => 'max_file_size',
                'value' => '10240',
                'type' => 'integer',
                'description' => 'Maximum file size in KB'
            ],
            [
                'key' => 'allowed_file_types',
                'value' => 'pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png,gif,zip,rar',
                'type' => 'string',
                'description' => 'Allowed file extensions'
            ],

            // Chat Settings
            [
                'key' => 'chat_enabled',
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable chat system'
            ],
            [
                'key' => 'max_message_length',
                'value' => '1000',
                'type' => 'integer',
                'description' => 'Maximum message length'
            ],

            // AI Settings
            [
                'key' => 'ai_enabled',
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable AI assistant'
            ],
            [
                'key' => 'ai_provider',
                'value' => 'openai',
                'type' => 'string',
                'description' => 'AI provider (openai, anthropic, etc.)'
            ],

            // Notification Settings
            [
                'key' => 'email_notifications',
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable email notifications'
            ],
            [
                'key' => 'push_notifications',
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable push notifications'
            ],

            // Security Settings
            [
                'key' => 'session_timeout',
                'value' => '7200',
                'type' => 'integer',
                'description' => 'Session timeout in seconds'
            ],
            [
                'key' => 'password_expiry',
                'value' => '90',
                'type' => 'integer',
                'description' => 'Password expiry in days'
            ],

            // Backup Settings
            [
                'key' => 'auto_backup',
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable automatic backups'
            ],
            [
                'key' => 'backup_frequency',
                'value' => 'daily',
                'type' => 'string',
                'description' => 'Backup frequency (daily, weekly, monthly)'
            ],

            // System Performance
            [
                'key' => 'cache_enabled',
                'value' => true,
                'type' => 'boolean',
                'description' => 'Enable system caching'
            ],
            [
                'key' => 'debug_mode',
                'value' => false,
                'type' => 'boolean',
                'description' => 'Enable debug mode'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('================================================');
        $this->command->info('⚙️ System Settings Seeded Successfully!');
        $this->command->info('================================================');
        $this->command->info('✅ Total Settings Created: ' . count($settings));
        $this->command->info('================================================');
        $this->command->info('📋 Settings Categories:');
        $this->command->info('  • System Basic Settings');
        $this->command->info('  • Theme & Appearance');
        $this->command->info('  • Email Configuration');
        $this->command->info('  • Document Management');
        $this->command->info('  • Chat System');
        $this->command->info('  • AI Assistant');
        $this->command->info('  • Notifications');
        $this->command->info('  • Security');
        $this->command->info('  • Backup & Performance');
        $this->command->info('================================================');
    }
}
