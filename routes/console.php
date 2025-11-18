<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\DocumentCodeGenerator;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('fix:employee-codes', function (DocumentCodeGenerator $codeGenerator) {
    $this->info('Fixing employee code numbers...');
    
    try {
        $codeGenerator->resetCurrentNumber('employees');
        $this->info('✅ Employee code numbers fixed successfully!');
        
        // Show preview of next code
        $nextCode = $codeGenerator->preview('employees');
        $this->info("Next employee code will be: {$nextCode}");
        
    } catch (\Exception $e) {
        $this->error('❌ Error fixing employee codes: ' . $e->getMessage());
        return 1;
    }
    
    return 0;
})->purpose('Fix employee code numbering');
