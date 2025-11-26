<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if table already exists
        if (!Schema::hasTable('expiry_notification_settings')) {
            Schema::create('expiry_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique(); // employee_documents, company_documents, tasks, projects, contracts, etc.
            $table->string('label'); // Display name
            $table->text('description')->nullable();
            $table->boolean('enabled')->default(true);
            $table->integer('days_before')->default(30); // Days before expiry to send notification
            $table->json('notify_roles')->nullable(); // Array of role IDs to notify
            $table->boolean('notify_super_admin')->default(true);
            $table->boolean('notify_owner')->default(true); // Notify the owner/assignee
            $table->string('frequency')->default('daily'); // daily, weekly, once
            $table->timestamps();
            });

            // Insert default settings only if table is empty
            if (DB::table('expiry_notification_settings')->count() == 0) {
                $defaults = [
            [
                'type' => 'employee_documents',
                'label' => 'Employee Documents',
                'description' => 'Passport, Visa, ID, Work Permit, etc.',
                'days_before' => 30,
                'notify_roles' => json_encode([3]), // hr-manager
                'notify_super_admin' => true,
                'notify_owner' => false,
            ],
            [
                'type' => 'company_documents',
                'label' => 'Company Documents',
                'description' => 'Licenses, Certificates, Contracts, etc.',
                'days_before' => 30,
                'notify_roles' => json_encode([1, 2]), // admin, super-admin
                'notify_super_admin' => true,
                'notify_owner' => false,
            ],
            [
                'type' => 'tasks',
                'label' => 'Tasks Due Date',
                'description' => 'Tasks approaching their due date',
                'days_before' => 3,
                'notify_roles' => json_encode([4]), // project-manager
                'notify_super_admin' => false,
                'notify_owner' => true,
            ],
            [
                'type' => 'projects',
                'label' => 'Projects Deadline',
                'description' => 'Projects approaching their deadline',
                'days_before' => 7,
                'notify_roles' => json_encode([4]), // project-manager
                'notify_super_admin' => true,
                'notify_owner' => true,
            ],
            [
                'type' => 'contracts',
                'label' => 'Employee Contracts',
                'description' => 'Employment contracts expiring soon',
                'days_before' => 30,
                'notify_roles' => json_encode([3]), // hr-manager
                'notify_super_admin' => true,
                'notify_owner' => false,
            ],
        ];

        foreach ($defaults as $default) {
                    DB::table('expiry_notification_settings')->insert(array_merge($default, [
                        'enabled' => true,
                        'frequency' => 'daily',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]));
                }
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('expiry_notification_settings');
    }
};
