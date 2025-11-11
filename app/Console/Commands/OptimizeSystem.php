<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the entire system for maximum performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting system optimization...');
        $this->newLine();

        // Clear all caches
        $this->info('📦 Clearing caches...');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->newLine();

        // Rebuild caches
        $this->info('⚡ Building optimized caches...');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
        $this->newLine();

        // Optimize
        $this->info('🎯 Running final optimization...');
        $this->call('optimize');
        $this->newLine();

        $this->info('✅ System optimization completed successfully!');
        $this->info('💡 Your application should now be significantly faster.');
        
        return Command::SUCCESS;
    }
}
