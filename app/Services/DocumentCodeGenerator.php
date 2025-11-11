<?php

namespace App\Services;

use App\Models\PrefixSetting;
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
            $setting->increment('current_number');
            $setting->refresh();

            return $setting->generateCode();
        }

        return DB::transaction(function () use ($setting) {
            $setting->increment('current_number');
            $setting->refresh();

            return $setting->generateCode();
        });
    }

    protected function findActiveSetting(string $documentType): ?PrefixSetting
    {
        return PrefixSetting::where('document_type', $documentType)
            ->where('is_active', true)
            ->first();
    }
}
