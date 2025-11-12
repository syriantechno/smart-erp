<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing include with app_path:" . PHP_EOL;
$path = app_path('Data/countries.php');
echo "Path: $path" . PHP_EOL;
echo "File exists: " . (file_exists($path) ? 'YES' : 'NO') . PHP_EOL;

if (file_exists($path)) {
    $countries = include $path;
    echo "Include successful: " . count($countries) . " countries loaded" . PHP_EOL;
    
    // Test json_encode
    $json = json_encode($countries);
    echo "JSON length: " . strlen($json) . PHP_EOL;
    echo "JSON starts with: " . substr($json, 0, 50) . "..." . PHP_EOL;
} else {
    echo "File does not exist!" . PHP_EOL;
}
?>
