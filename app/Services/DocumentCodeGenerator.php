<?php

namespace App\Services;

use App\Models\Setting\PrefixSetting;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DocumentCodeGenerator
{

    public function generate(string $documentType): string
    {
        return $this->resolveCode($documentType, true);
    }

    public function preview(string $documentType): string
    {
        return $this->resolveCode($documentType, false);
    }

    protected function resolveCode(string $documentType, bool $persist): string
    {
        $setting = $this->findActiveSetting($documentType);

        if (!$setting) {
            throw new RuntimeException("No prefix configuration found for document type: {$documentType}");
        }

        if (!$persist) {
            $this->ensureBaseline($setting);
            return $setting->previewCode();
        }

        if (DB::transactionLevel() > 0) {
            return $this->generateNextCode($setting);
        }

        return DB::transaction(function () use ($setting) {
            return $this->generateNextCode($setting);
        });
    }

    protected function generateNextCode(PrefixSetting $setting): string
    {
        $this->ensureBaseline($setting);

        // Use atomic increment with lock to prevent race conditions
        DB::table('prefix_settings')
            ->where('id', $setting->id)
            ->lockForUpdate()
            ->increment('current_number');
        
        // Refresh the model to get the updated current_number
        $setting->refresh();
        
        return $setting->generateCode();
    }

    protected function findActiveSetting(string $documentType): ?PrefixSetting
    {
        return PrefixSetting::where('document_type', $documentType)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Reset current_number based on the last record in the database
     */
    public function resetCurrentNumber(string $documentType): void
    {
        $setting = $this->findActiveSetting($documentType);
        
        if (!$setting) {
            throw new RuntimeException("No prefix configuration found for document type: {$documentType}");
        }

        // Get the table name based on document type
        $tableName = $this->getTableName($documentType);
        
        $codeColumn = $this->getCodeColumn($documentType);

        if (!$tableName) {
            throw new RuntimeException("Unknown table for document type: {$documentType}");
        }

        // Get the highest code number from the database
        $lastRecord = DB::table($tableName)
            ->where($codeColumn, 'like', $setting->prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord && $lastRecord->{$codeColumn}) {
            // Extract number from code (e.g., "EMP-0005" -> 5)
            $pattern = '/^' . preg_quote($setting->prefix, '/') . '-(?:\d{4}-)?(\d+)$/';
            if (preg_match($pattern, $lastRecord->{$codeColumn}, $matches)) {
                $lastNumber = (int) $matches[1];
                $setting->update(['current_number' => $lastNumber]);
            }
        }
    }

    protected function getTableName(string $documentType): ?string
    {
        $tableMap = [
            'department' => 'departments',
            'employees' => 'employees',
            'departments' => 'departments',
            'position' => 'positions',
            'positions' => 'positions',
            'leave' => 'leaves',
            'tasks' => 'tasks',
            'projects' => 'projects',
            'materials' => 'materials',
            'warehouses' => 'warehouses',
            'categories' => 'categories',
            'purchase_requests' => 'purchase_requests',
            'invoices' => 'invoices',
            'customers' => 'customers',
            // Add more mappings as needed
        ];

        return $tableMap[$documentType] ?? null;
    }

    protected function getCodeColumn(string $documentType): string
    {
        $columnMap = [
            'invoices' => 'number',
        ];

        return $columnMap[$documentType] ?? 'code';
    }

    protected function ensureBaseline(PrefixSetting $setting): void
    {
        $tableName = $this->getTableName($setting->document_type);

        $codeColumn = $this->getCodeColumn($setting->document_type);

        if (! $tableName) {
            return;
        }

        $lastRecord = DB::table($tableName)
            ->where($codeColumn, 'like', $setting->prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord && isset($lastRecord->{$codeColumn})) {
            $pattern = '/^' . preg_quote($setting->prefix, '/') . '-(?:\d{4}-)?(\d+)$/';
            if (preg_match($pattern, $lastRecord->{$codeColumn}, $matches)) {
                $lastNumber = (int) $matches[1];

                if ($setting->current_number < $lastNumber) {
                    DB::table('prefix_settings')
                        ->where('id', $setting->id)
                        ->update(['current_number' => $lastNumber]);

                    $setting->current_number = $lastNumber;
                }

                return;
            }
        }

        $baseline = max(0, ($setting->start_number ?? 1) - 1);

        if ($setting->current_number !== $baseline) {
            DB::table('prefix_settings')
                ->where('id', $setting->id)
                ->update(['current_number' => $baseline]);

            $setting->current_number = $baseline;
        }
    }
}
