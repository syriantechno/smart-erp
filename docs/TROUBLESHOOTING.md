# Troubleshooting Guide

This guide provides solutions for common issues encountered in the Smart ERP system.

## 🚀 Quick Start Issues

### Laravel Installation Problems

**Issue:** `composer install` fails with dependency errors
```bash
Problem 1
- Installation request for laravel/framework ^11.0 -> satisfiable by laravel/framework[11.x-dev]
```

**Solution:**
```bash
# Clear Composer cache
composer clear-cache

# Update Composer
composer self-update

# Install dependencies
composer install --no-dev

# If still failing, try with ignore platform requirements
composer install --ignore-platform-reqs
```

**Issue:** PHP version compatibility errors
```bash
This package requires php ^8.2 but your php version (8.1.0) does not satisfy that requirement
```

**Solution:**
```bash
# Check current PHP version
php --version

# Switch to PHP 8.2+ if available
# On Ubuntu/Debian:
sudo update-alternatives --set php /usr/bin/php8.2

# On macOS with Homebrew:
brew link php@8.2 --force

# Verify version
php --version
```

### Database Connection Issues

**Issue:** `SQLSTATE[HY000] [2002] Connection refused`
```bash
Illuminate\Database\QueryException
SQLSTATE[HY000] [2002] Connection refused
```

**Solution:**
```bash
# Check if MySQL is running
sudo systemctl status mysql  # Linux
brew services list | grep mysql  # macOS

# Start MySQL service
sudo systemctl start mysql  # Linux
brew services start mysql  # macOS

# Verify connection
mysql -u root -p -e "SELECT 1;"
```

**Issue:** Access denied for user
```bash
SQLSTATE[HY000] [1698] Access denied for user 'root'@'localhost'
```

**Solution:**
```bash
# Login to MySQL as root
sudo mysql -u root

# Create database user
CREATE USER 'smarterp'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON smarterp.* TO 'smarterp'@'localhost';
FLUSH PRIVILEGES;

# Update .env file
DB_USERNAME=smarterp
DB_PASSWORD=password
```

### Migration Errors

**Issue:** Migration fails with table already exists
```bash
SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'users' already exists
```

**Solution:**
```bash
# Reset database (WARNING: This will delete all data)
php artisan migrate:fresh

# Or rollback and migrate
php artisan migrate:rollback --step=1
php artisan migrate

# Check migration status
php artisan migrate:status
```

## 🤖 AI Assistant Issues

### OpenAI API Key Problems

**Issue:** AI features not working, showing setup required message

**Solution:**
```bash
# Edit .env file
nano .env

# Add OpenAI configuration
OPENAI_API_KEY=sk-your-api-key-here
OPENAI_MODEL=gpt-3.5-turbo
OPENAI_MAX_TOKENS=2000
OPENAI_TEMPERATURE=0.7

# Clear config cache
php artisan config:clear
php artisan cache:clear

# Restart application
php artisan serve
```

**Issue:** OpenAI API quota exceeded
```json
{
  "error": {
    "message": "You exceeded your current quota",
    "type": "insufficient_quota"
  }
}
```

**Solution:**
1. Check OpenAI billing dashboard: https://platform.openai.com/account/billing
2. Upgrade your plan or add credits
3. Monitor usage in OpenAI dashboard
4. Implement rate limiting in your application

**Issue:** Slow AI responses or timeouts

**Solution:**
```php
// Adjust timeout in AiService
$this->client->timeout(30); // Increase timeout

// Or reduce max tokens
OPENAI_MAX_TOKENS=1000
```

### AI Command Execution Issues

**Issue:** Commands not executing properly

**Debug Steps:**
```php
// Enable AI debug mode
// In .env
AI_DEBUG=true

// Check logs
tail -f storage/logs/laravel.log

// Test command manually
php artisan tinker
AiService::executeCommand('create task for testing');
```

**Issue:** AI responses in wrong language

**Solution:**
```php
// Add language specification to prompts
$prompt = "Respond in Arabic/English: " . $userInput;

// Or set system prompt
$systemPrompt = "You are an AI assistant. Always respond in Arabic.";
```

## 📄 Document Management Issues

### File Upload Problems

**Issue:** File uploads failing with size errors

**Solution:**
```ini
# Edit php.ini
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300

# Or add to .htaccess
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
```

**Issue:** File type not allowed

**Solution:**
```php
// Check allowed extensions in config
// config/documents.php
'allowed_extensions' => [
    'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt',
    'jpg', 'jpeg', 'png', 'gif', 'bmp'
],

// Or add custom extension
'allowed_extensions' => array_merge(config('documents.allowed_extensions'), ['zip', 'rar'])
```

**Issue:** Files not displaying correctly

**Debug Steps:**
```bash
# Check file permissions
ls -la storage/app/documents/

# Fix permissions
chmod -R 755 storage/
chown -R www-data:www-data storage/

# Clear file cache
php artisan view:clear
php artisan cache:clear
```

### Access Control Issues

**Issue:** Users can't access documents they're supposed to see

**Debug Steps:**
```php
// Check user permissions
php artisan tinker
$user = User::find(1);
$document = Document::find(1);
$document->canBeAccessedBy($user);

// Check document settings
$document->access_level;
$user->department_id;
```

**Issue:** Document sharing not working

**Solution:**
```php
// Check share permissions
$share = DocumentShare::where('document_id', $documentId)
                     ->where('shared_with_user_id', $userId)
                     ->first();

if ($share && $share->isExpired()) {
    // Share has expired, create new share
}
```

## 💬 Chat System Issues

### Real-time Messaging Problems

**Issue:** Messages not appearing in real-time

**Solution:**
```bash
# Check Pusher configuration
# In .env
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1

# Clear cache
php artisan config:clear

# Check Pusher debug
// In browser console
window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('Connected to Pusher');
});
```

**Issue:** WebSocket connection failing

**Alternative Solution:**
```bash
# Use log driver for testing
BROADCAST_CONNECTION=log

# Check logs for broadcast events
tail -f storage/logs/laravel.log
```

### File Sharing Issues

**Issue:** Chat file uploads failing

**Solution:**
```php
// Check chat config
// config/chat.php
'max_file_size' => env('CHAT_MAX_FILE_SIZE', 10240), // KB
'allowed_extensions' => explode(',', env('CHAT_ALLOWED_EXTENSIONS', 'jpg,jpeg,png,gif,pdf,doc,docx,txt')),

// Increase limits if needed
CHAT_MAX_FILE_SIZE=20480  // 20MB
```

## ✅ Approval System Issues

### Workflow Problems

**Issue:** Approvals getting stuck

**Debug Steps:**
```php
// Check approval request status
php artisan tinker
$request = ApprovalRequest::find(1);
$request->status;
$request->current_approver_id;

// Check workflow configuration
config('approvals.workflows.' . $request->type);
```

**Issue:** Notifications not sending

**Solution:**
```bash
# Check mail configuration
php artisan config:list | grep mail

# Test email sending
php artisan tinker
Mail::raw('Test email', function($message) {
    $message->to('test@example.com')->subject('Test');
});
```

### Auto-approval Issues

**Issue:** Requests not auto-approving

**Debug Steps:**
```php
// Check auto-approval conditions
$workflow = config('approvals.workflows.leave_request');
$condition = $workflow['auto_approve']['condition'];

// Test condition
$days = 2; // Test value
eval("return {$days} {$condition};"); // Should return true/false
```

## 📧 Email System Issues

### Email Sending Problems

**Issue:** Emails not being sent

**Solution:**
```bash
# Check mail configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls

# Test email configuration
php artisan mail:send-test
```

**Issue:** Gmail SMTP authentication issues

**Solution:**
1. Enable 2-factor authentication on Gmail
2. Generate App Password: https://support.google.com/accounts/answer/185833
3. Use App Password instead of regular password

**Issue:** Emails going to spam

**Solutions:**
```php
// Add proper headers
$message->from('noreply@yourdomain.com', 'Your App Name')
        ->replyTo('support@yourdomain.com')
        ->subject($subject)
        ->priority(1); // High priority

// Add SPF, DKIM, DMARC records to your domain
// Use consistent sending domain
```

### Email Template Issues

**Issue:** Email templates not loading

**Solution:**
```php
// Check template files
ls -la resources/views/emails/

// Clear view cache
php artisan view:clear

// Check template configuration
config('mail.markdown.theme');
```

## 🔧 General System Issues

### Performance Problems

**Issue:** Slow page loading

**Solutions:**
```bash
# Enable query logging
DB::enableQueryLog();

# Check slow queries
php artisan tinker
dd(DB::getQueryLog());

# Optimize queries
// Add eager loading
$users = User::with('roles')->get();

// Add database indexes
php artisan db:show
```

**Issue:** High memory usage

**Solutions:**
```php
// Optimize memory usage
ini_set('memory_limit', '512M');

// Use chunking for large datasets
User::chunk(100, function($users) {
    foreach ($users as $user) {
        // Process user
    }
});

// Clear unnecessary data
unset($largeArray);
gc_collect_cycles();
```

### Caching Issues

**Issue:** Changes not reflecting after updates

**Solutions:**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear browser cache
# Ctrl+Shift+R (Chrome/Firefox)

# Clear opcode cache (if using OPcache)
php artisan opcache:clear
```

### Session Issues

**Issue:** Users getting logged out randomly

**Solutions:**
```bash
# Check session configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Clear expired sessions
php artisan session:clear

# Check session table size
php artisan tinker
DB::table('sessions')->count();
```

## 🔐 Security Issues

### CSRF Token Problems

**Issue:** CSRF token mismatch errors

**Solutions:**
```php
// Check CSRF token in forms
@csrf

// For AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Check session domain
SESSION_DOMAIN=.yourdomain.com
```

### File Permission Issues

**Issue:** File upload/storage permission errors

**Solutions:**
```bash
# Set proper permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/

# For SELinux (if applicable)
chcon -R -t httpd_sys_rw_content_t storage/
```

## 📊 Monitoring & Debugging

### Log Analysis

```bash
# View recent logs
tail -f storage/logs/laravel.log

# Search for specific errors
grep "ERROR" storage/logs/laravel.log

# Log levels
LOG_LEVEL=debug  # Show all logs
LOG_LEVEL=error  # Show only errors
```

### Performance Monitoring

```php
// Add performance monitoring
use Illuminate\Support\Facades\DB;

DB::listen(function ($query) {
    if ($query->time > 1000) { // Log slow queries
        Log::warning('Slow query detected', [
            'sql' => $query->sql,
            'time' => $query->time,
            'bindings' => $query->bindings
        ]);
    }
});
```

### Health Checks

```php
// Create health check route
Route::get('/health', function () {
    return [
        'status' => 'ok',
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::store()->getStore() ? 'working' : 'failed',
        'storage' => Storage::disk('public')->exists('test.txt') ? 'writable' : 'not writable',
    ];
});
```

## 🚀 Deployment Issues

### Production Environment Problems

**Issue:** Assets not loading in production

**Solutions:**
```bash
# Build assets for production
npm run build

# Set proper asset URL
ASSET_URL=https://yourdomain.com

# Clear compiled views
php artisan view:clear
```

**Issue:** Database connection issues in production

**Solutions:**
```bash
# Use production database credentials
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=smarterp_prod
DB_USERNAME=prod_user
DB_PASSWORD=secure_password

# Enable database SSL if required
DB_SSL=true
```

### SSL/HTTPS Issues

**Issue:** Mixed content warnings

**Solutions:**
```php
// Force HTTPS in production
if (config('app.env') === 'production') {
    URL::forceScheme('https');
}

// Update asset URLs
config(['app.url' => 'https://yourdomain.com']);
```

## 📞 Getting Help

### Support Resources
1. **Check Documentation**: Review relevant `.md` files in `/docs`
2. **Laravel Docs**: https://laravel.com/docs
3. **Community Forums**: https://laracasts.com/discuss
4. **GitHub Issues**: Create detailed bug reports
5. **Stack Overflow**: Search for similar issues

### Debug Information to Include
When reporting issues, please include:
- Laravel version: `php artisan --version`
- PHP version: `php --version`
- Server OS and version
- Database type and version
- Error messages and stack traces
- Steps to reproduce the issue
- Recent changes made to the code

### Emergency Contacts
- **Development Team**: dev@smarterp.com
- **System Administration**: admin@smarterp.com
- **Security Issues**: security@smarterp.com

---

**Last Updated:** November 12, 2024
**Version:** 1.0.0
