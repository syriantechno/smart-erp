<?php

namespace App\Console\Commands;

use App\Models\Setting\ExpiryNotificationSetting;
use App\Models\Notification;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeDocument;
use App\Models\Document\Document;
use App\Models\Work\Task;
use App\Models\Work\Project;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendExpiryNotifications extends Command
{
    protected $signature = 'notifications:send-expiry {--type= : Specific type to check (employee_documents, company_documents, tasks, projects, contracts)}';
    protected $description = 'Send notifications for items approaching their expiry/due date';

    public function handle()
    {
        $specificType = $this->option('type');
        
        $settings = ExpiryNotificationSetting::enabled();
        
        if ($specificType) {
            $settings->where('type', $specificType);
        }
        
        $settings = $settings->get();

        if ($settings->isEmpty()) {
            $this->info('No enabled expiry notification settings found.');
            return 0;
        }

        $totalNotifications = 0;

        foreach ($settings as $setting) {
            $this->info("Processing: {$setting->label}");
            
            $count = match ($setting->type) {
                'employee_documents' => $this->checkEmployeeDocuments($setting),
                'company_documents' => $this->checkCompanyDocuments($setting),
                'tasks' => $this->checkTasks($setting),
                'projects' => $this->checkProjects($setting),
                'contracts' => $this->checkContracts($setting),
                default => 0,
            };
            
            $totalNotifications += $count;
            $this->info("  - Sent {$count} notifications");
        }

        $this->info("Total notifications sent: {$totalNotifications}");
        
        return 0;
    }

    /**
     * Check employee documents (passport, visa, ID, etc.)
     */
    protected function checkEmployeeDocuments(ExpiryNotificationSetting $setting): int
    {
        $count = 0;
        $targetDate = Carbon::now()->addDays($setting->days_before);

        // Check EmployeeDocument table
        $documents = EmployeeDocument::whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', $targetDate)
            ->whereDate('expiry_date', '>=', Carbon::now())
            ->where('is_active', true)
            ->with('employee')
            ->get();

        foreach ($documents as $doc) {
            $daysLeft = Carbon::now()->diffInDays($doc->expiry_date, false);
            $employeeName = $doc->employee ? ($doc->employee->first_name . ' ' . $doc->employee->last_name) : 'Unknown';
            $ownerId = $doc->employee?->user_id;
            
            $recipientIds = $setting->getRecipientUserIds($ownerId);
            
            if (!empty($recipientIds)) {
                $docType = $doc->document_type ?? $doc->document_name ?? 'Document';
                $this->sendNotification(
                    $recipientIds,
                    'Employee Document Expiring',
                    "{$docType} for {$employeeName} expires in {$daysLeft} days",
                    route('employees.show', $doc->employee_id ?? 0),
                    'id-card',
                    'warning'
                );
                $count++;
            }
        }

        return $count;
    }

    /**
     * Check company documents
     */
    protected function checkCompanyDocuments(ExpiryNotificationSetting $setting): int
    {
        $count = 0;
        $targetDate = Carbon::now()->addDays($setting->days_before);

        if (!class_exists(Document::class)) {
            return 0;
        }

        $documents = Document::whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', $targetDate)
            ->whereDate('expiry_date', '>=', Carbon::now())
            ->get();

        foreach ($documents as $doc) {
            $daysLeft = Carbon::now()->diffInDays($doc->expiry_date, false);
            $ownerId = $doc->created_by ?? $doc->user_id;
            
            $recipientIds = $setting->getRecipientUserIds($ownerId);
            
            if (!empty($recipientIds)) {
                $this->sendNotification(
                    $recipientIds,
                    'Document Expiring',
                    "Document '{$doc->title}' expires in {$daysLeft} days",
                    route('documents.show', $doc->id),
                    'file-text',
                    'warning'
                );
                $count++;
            }
        }

        return $count;
    }

    /**
     * Check tasks due date
     */
    protected function checkTasks(ExpiryNotificationSetting $setting): int
    {
        $count = 0;
        $targetDate = Carbon::now()->addDays($setting->days_before);

        if (!class_exists(Task::class)) {
            return 0;
        }

        $tasks = Task::whereNotNull('due_date')
            ->whereDate('due_date', '<=', $targetDate)
            ->whereDate('due_date', '>=', Carbon::now())
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with('employee')
            ->get();

        foreach ($tasks as $task) {
            $daysLeft = Carbon::now()->diffInDays($task->due_date, false);
            $ownerId = $task->employee?->user_id;
            
            $recipientIds = $setting->getRecipientUserIds($ownerId);
            
            if (!empty($recipientIds)) {
                $this->sendNotification(
                    $recipientIds,
                    'Task Due Soon',
                    "Task '{$task->title}' is due in {$daysLeft} days",
                    route('tasks.show', $task->id),
                    'clipboard-list',
                    'info'
                );
                $count++;
            }
        }

        return $count;
    }

    /**
     * Check projects deadline
     */
    protected function checkProjects(ExpiryNotificationSetting $setting): int
    {
        $count = 0;
        $targetDate = Carbon::now()->addDays($setting->days_before);

        if (!class_exists(Project::class)) {
            return 0;
        }

        $projects = Project::whereNotNull('end_date')
            ->whereDate('end_date', '<=', $targetDate)
            ->whereDate('end_date', '>=', Carbon::now())
            ->whereNotIn('status', ['completed', 'cancelled', 'on_hold'])
            ->get();

        foreach ($projects as $project) {
            $daysLeft = Carbon::now()->diffInDays($project->end_date, false);
            $ownerId = $project->manager_id ?? $project->created_by;
            
            $recipientIds = $setting->getRecipientUserIds($ownerId);
            
            if (!empty($recipientIds)) {
                $this->sendNotification(
                    $recipientIds,
                    'Project Deadline Approaching',
                    "Project '{$project->name}' deadline is in {$daysLeft} days",
                    route('projects.show', $project->id),
                    'folder-kanban',
                    'warning'
                );
                $count++;
            }
        }

        return $count;
    }

    /**
     * Check employee contracts
     * Note: This checks employee_documents with type 'contract' or 'employment_contract'
     */
    protected function checkContracts(ExpiryNotificationSetting $setting): int
    {
        $count = 0;
        $targetDate = Carbon::now()->addDays($setting->days_before);

        // Check contracts in employee_documents table
        $contracts = EmployeeDocument::whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', $targetDate)
            ->whereDate('expiry_date', '>=', Carbon::now())
            ->where('is_active', true)
            ->where(function ($q) {
                $q->where('document_type', 'like', '%contract%')
                  ->orWhere('document_name', 'like', '%contract%');
            })
            ->with('employee')
            ->get();

        foreach ($contracts as $contract) {
            $daysLeft = Carbon::now()->diffInDays($contract->expiry_date, false);
            $employeeName = $contract->employee ? ($contract->employee->first_name . ' ' . $contract->employee->last_name) : 'Unknown';
            $ownerId = $contract->employee?->user_id;
            
            $recipientIds = $setting->getRecipientUserIds($ownerId);
            
            if (!empty($recipientIds)) {
                $this->sendNotification(
                    $recipientIds,
                    'Contract Expiring',
                    "Employment contract for {$employeeName} expires in {$daysLeft} days",
                    route('employees.show', $contract->employee_id ?? 0),
                    'file-signature',
                    'warning'
                );
                $count++;
            }
        }

        return $count;
    }

    /**
     * Send notification to users
     */
    protected function sendNotification(array $recipientIds, string $title, string $message, string $actionUrl, string $icon, string $type = 'info'): void
    {
        foreach (array_unique($recipientIds) as $userId) {
            // Check if similar notification was sent today to avoid duplicates
            $exists = Notification::where('user_id', $userId)
                ->where('title', $title)
                ->where('message', $message)
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if (!$exists) {
                Notification::create([
                    'type' => $type,
                    'title' => $title,
                    'message' => $message,
                    'user_id' => $userId,
                    'action_url' => $actionUrl,
                    'icon' => $icon,
                    'data' => ['source' => 'expiry_notification'],
                ]);
            }
        }
    }
}
