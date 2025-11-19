@echo off
echo ========================================
echo    Smart ERP Performance Optimization
echo ========================================
echo.

echo [1/8] Clearing all caches...
php artisan optimize:clear

echo [2/8] Caching configuration...
php artisan config:cache

echo [3/8] Caching routes...
php artisan route:cache

echo [4/8] Caching views...
php artisan view:cache

echo [5/8] Caching events...
php artisan event:cache

echo [6/8] Building optimized assets...
npm run build

echo [7/8] Optimizing Composer autoloader...
composer dump-autoload --optimize --classmap-authoritative

echo [8/8] Final optimization...
php artisan optimize

echo.
echo ========================================
echo    Performance Optimization Complete!
echo ========================================
echo.
echo System is now optimized for maximum speed!
pause
