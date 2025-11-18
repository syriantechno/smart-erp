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
        // Use atomic increment with lock to prevent race conditions
        $newNumber = DB::table('prefix_settings')
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
        
        if (!$tableName) {
            throw new RuntimeException("Unknown table for document type: {$documentType}");
        }

        // Get the highest code number from the database
        $lastRecord = DB::table($tableName)
            ->where('code', 'like', $setting->prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord && $lastRecord->code) {
            // Extract number from code (e.g., "EMP-0005" -> 5)
            $pattern = '/^' . preg_quote($setting->prefix, '/') . '-(?:\d{4}-)?(\d+)$/';
            if (preg_match($pattern, $lastRecord->code, $matches)) {
                $lastNumber = (int) $matches[1];
                $setting->update(['current_number' => $lastNumber]);
            }
        }
    }

    protected function getTableName(string $documentType): ?string
    {
        $tableMap = [
            'employees' => 'employees',
            'departments' => 'departments',
            'positions' => 'positions',
            'tasks' => 'tasks',
            'projects' => 'projects',
            'materials' => 'materials',
            'warehouses' => 'warehouses',
            'categories' => 'categories',
            // Add more mappings as needed
        ];

        return $tableMap[$documentType] ?? null;
    }
}
