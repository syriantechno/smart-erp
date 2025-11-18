<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DocumentCodeGenerator;

class FixEmployeeCodeNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:employee-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix employee code numbering by resetting current_number based on last employee';

    /**
     * Execute the console command.
     */
    public function handle(DocumentCodeGenerator $codeGenerator)
    {
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
    }
}
