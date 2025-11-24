<?php

namespace App\Services\Accounting;

use App\Models\Accounting\Accounting;

class LinkedAccountManager
{
    /**
     * Ensure a customer has a linked receivable account.
     */
    public function ensureCustomerAccount(?int $accountId, string $customerName): ?int
    {
        return $this->ensureAccount($accountId, $customerName, [
            'parent_code' => null, // Will find any asset account
            'type' => 'asset',
            'category' => 'current_asset',
            'label' => 'Customer',
        ]);
    }

    /**
     * Shared account creation pipeline.
     */
    protected function ensureAccount(?int $accountId, string $entityName, array $config): ?int
    {
        if ($accountId && Accounting::whereKey($accountId)->exists()) {
            return $accountId;
        }

        if ($config['parent_code']) {
            $parent = Accounting::where('code', $config['parent_code'])->first();
        } else {
            // Find any account with matching type
            $parent = Accounting::where('type', $config['type'])
                ->when(isset($config['category']), fn($q) => $q->where('category', $config['category']))
                ->first();
        }

        $account = Accounting::create([
            'code' => Accounting::generateUniqueCode(),
            'name' => trim(($config['label'] ?? 'Linked') . ' - ' . $entityName),
            'description' => 'Auto generated for ' . strtolower($config['label'] ?? 'linked entity') . ' ' . $entityName,
            'type' => $config['type'],
            'category' => $config['category'] ?? null,
            'parent_id' => $parent?->id,
            'level' => $parent ? ($parent->level + 1) : 1,
            'is_active' => true,
        ]);

        return $account->id;
    }
}
