<?php

/**
 * Script to check and fix model import paths
 * Run: php check-model-imports.php
 */

$controllersPath = __DIR__ . '/app/Http/Controllers';
$modelsPath = __DIR__ . '/app/Models';

echo "🔍 Checking model imports in controllers...\n\n";

// Get all controller files
$controllerFiles = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($controllersPath)
);

$issues = [];

foreach ($controllerFiles as $file) {
    if ($file->getExtension() !== 'php') continue;
    
    $content = file_get_contents($file->getPathname());
    $relativePath = str_replace(__DIR__ . '/', '', $file->getPathname());
    
    // Check for incorrect model imports
    if (preg_match_all('/use App\\\\Models\\\\([^\\\\;]+);/', $content, $matches)) {
        foreach ($matches[1] as $modelName) {
            // Check if this should be a namespaced model
            $namespacedPath = $modelsPath . '/' . $modelName . '/' . $modelName . '.php';
            
            if (file_exists($namespacedPath)) {
                $issues[] = [
                    'file' => $relativePath,
                    'issue' => "Should use App\\Models\\{$modelName}\\{$modelName} instead of App\\Models\\{$modelName}",
                    'model' => $modelName
                ];
            }
        }
    }
}

if (empty($issues)) {
    echo "✅ All model imports are correct!\n";
} else {
    echo "⚠️  Found " . count($issues) . " import issues:\n\n";
    
    foreach ($issues as $issue) {
        echo "📁 {$issue['file']}\n";
        echo "   {$issue['issue']}\n\n";
    }
    
    echo "💡 Run 'php artisan optimize:clear' after fixing imports.\n";
}

echo "\n🎯 Model structure check:\n";

// Check model organization
$modelDirs = glob($modelsPath . '/*', GLOB_ONLYDIR);
foreach ($modelDirs as $dir) {
    $dirName = basename($dir);
    $models = glob($dir . '/*.php');
    echo "📂 {$dirName}: " . count($models) . " models\n";
}

echo "\n✅ Check complete!\n";
