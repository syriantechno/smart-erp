<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckDataTableLibraries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datatables:check {--update : Update libraries from CDN}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and optionally update DataTables local libraries';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $config = config('datatables_local', []);
        $libraries = $config['libraries'] ?? [];

        if (empty($libraries)) {
            $this->error('No libraries configured in datatables_local config');
            return 1;
        }

        $this->info('🔍 Checking DataTables libraries...');
        $this->newLine();

        $statusTable = [];
        $needsUpdate = false;

        foreach ($libraries as $name => $library) {
            $path = $library['path'];
            $exists = file_exists($path);
            $size = $exists ? filesize($path) : 0;

            $status = $exists ? '✅ Exists' : '❌ Missing';
            $sizeFormatted = $exists ? $this->formatBytes($size) : '0 B';

            $statusTable[] = [
                $name,
                $library['version'],
                $status,
                $sizeFormatted,
                $library['url']
            ];

            if (!$exists) {
                $needsUpdate = true;
            }
        }

        $this->table(
            ['Library', 'Version', 'Status', 'Size', 'URL'],
            $statusTable
        );

        if ($this->option('update') || $needsUpdate) {
            if ($this->option('update') || $this->confirm('Some libraries are missing. Update them from CDN?', true)) {
                $this->updateLibraries($libraries);
            }
        }

        return 0;
    }

    /**
     * Update libraries from CDN
     */
    protected function updateLibraries(array $libraries)
    {
        $this->info('📥 Updating libraries from CDN...');

        $progressBar = $this->output->createProgressBar(count($libraries));
        $progressBar->start();

        $results = [];

        foreach ($libraries as $name => $library) {
            $url = $library['url'];
            $path = $library['path'];

            // Create directory if it doesn't exist
            $dir = dirname($path);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            try {
                $this->info("Downloading {$name}...");
                $content = file_get_contents($url);

                if ($content !== false) {
                    file_put_contents($path, $content);
                    $results[$name] = [
                        'success' => true,
                        'size' => strlen($content),
                        'message' => "Downloaded successfully"
                    ];
                    $this->info("✅ {$name} downloaded (" . $this->formatBytes(strlen($content)) . ")");
                } else {
                    $results[$name] = [
                        'success' => false,
                        'message' => "Failed to download from {$url}"
                    ];
                    $this->error("❌ Failed to download {$name}");
                }
            } catch (\Exception $e) {
                $results[$name] = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
                $this->error("❌ Error downloading {$name}: " . $e->getMessage());
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info('📊 Update Summary:');
        foreach ($results as $name => $result) {
            if ($result['success']) {
                $this->line("✅ {$name}: " . $result['message'] . " (" . $this->formatBytes($result['size']) . ")");
            } else {
                $this->line("❌ {$name}: " . $result['message']);
            }
        }
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
