<?php

namespace App\Models;

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
        $number = str_pad($this->current_number, $this->padding, '0', STR_PAD_LEFT);
        
        if ($this->include_year) {
            $year = date('Y');
            return "{$this->prefix}-{$year}-{$number}";
        }
        
        return "{$this->prefix}-{$number}";
    }
}
