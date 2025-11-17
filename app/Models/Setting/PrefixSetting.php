<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class PrefixSetting extends Model
{
    protected $fillable = [
        'document_type',
        'prefix',
        'padding',
        'start_number',
        'current_number',
        'include_year',
        'is_active',
    ];

    protected $casts = [
        'include_year' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function generateCode()
    {
        $number = str_pad($this->current_number, $this->padding, '0', STR_PAD_LEFT);
        
        if ($this->include_year) {
            $year = date('Y');
            return "{$this->prefix}-{$year}-{$number}";
        }
        
        return "{$this->prefix}-{$number}";
    }

    public function getNextNumber()
    {
        $this->increment('current_number');
        return $this->generateCode();
    }

    public function previewCode()
    {
        // Preview the NEXT code that will be generated
        $nextNumber = $this->current_number + 1;
        $number = str_pad($nextNumber, $this->padding, '0', STR_PAD_LEFT);
        
        if ($this->include_year) {
            $year = date('Y');
            return "{$this->prefix}-{$year}-{$number}";
        }
        
        return "{$this->prefix}-{$number}";
    }
}
