<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

class ChatSystemSeeder extends Seeder
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

        // For demo purposes, create a sample conversation with the admin user only
        // In a real application, you would have multiple users
        $conversation1 = Conversation::create([
            'type' => 'direct',
            'title' => 'Sample Chat',
            'created_by' => $admin->id,
        ]);

        $conversation1->addParticipant($admin->id);

        // Add sample messages (admin chatting with himself for demo)
        Message::create([
            'conversation_id' => $conversation1->id,
            'sender_id' => $admin->id,
            'content' => 'Welcome to the Internal Chat System!',
            'message_type' => 'text',
        ]);

        Message::create([
            'conversation_id' => $conversation1->id,
            'sender_id' => $admin->id,
            'content' => 'This system allows employees to communicate internally.',
            'message_type' => 'text',
        ]);

        Message::create([
            'conversation_id' => $conversation1->id,
            'sender_id' => $admin->id,
            'content' => 'You can create direct messages or group chats.',
            'message_type' => 'text',
        ]);

        // Mark messages as read
        $conversation1->markAsRead($admin->id);

        $this->command->info('Chat system data seeded successfully!');
        $this->command->info('Created sample conversation with messages.');
    }
}
