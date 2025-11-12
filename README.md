# Smart ERP System

A comprehensive Enterprise Resource Planning (ERP) system built with Laravel, featuring advanced AI integration, document management, communication tools, and workflow automation.

## 🚀 Features

### 🤖 AI Assistant
- **Intelligent Chat**: Natural language conversation with AI
- **Command Execution**: Execute system commands via AI
- **Data Analysis**: Generate insights and reports
- **Content Generation**: Create emails, reports, and documents
- **OpenAI Integration**: Powered by GPT-3.5 Turbo

### 📄 Document Management
- **Hierarchical Categories**: Unlimited nested document categories
- **File Upload**: Support for PDF, DOC, XLS, images, and more
- **Access Control**: Public, Internal, Confidential, and Restricted access
- **Version Control**: Track document versions and changes
- **Sharing System**: Share documents with users or departments
- **Search & Filter**: Advanced search and filtering capabilities

### 💬 Internal Chat
- **Real-time Messaging**: Instant messaging between employees
- **Group Chats**: Create and manage group conversations
- **File Sharing**: Share documents and media in chats
- **Message History**: Persistent chat history
- **Online Status**: See who's online

### ✅ Approval System
- **Workflow Management**: Multi-level approval workflows
- **Request Types**: Leave, Purchase, Expense, Loan, and more
- **Approval Hierarchy**: Configurable approval levels
- **Document Generation**: Generate approval request documents
- **Dashboard**: Track pending approvals and history

### 📧 Electronic Mail
- **Email Management**: Send and receive emails within the system
- **Folders**: Inbox, Starred, Sent, Draft, Archived
- **Attachments**: Support for file attachments
- **Templates**: Email templates and signatures
- **Search**: Advanced email search and filtering

## 🏗️ System Architecture

### Tech Stack
- **Backend**: Laravel 11.x
- **Database**: MySQL 8.0
- **Frontend**: Blade Templates + Tailwind CSS
- **JavaScript**: jQuery, DataTables, SweetAlert2
- **Icons**: Lucide Icons
- **AI**: OpenAI GPT-3.5 Turbo API

### Key Components
- **Authentication**: Laravel Sanctum
- **Authorization**: Spatie Laravel Permission
- **File Storage**: Laravel Storage (Local/Public)
- **Real-time**: Laravel Broadcasting (Pusher/WebSockets)
- **Background Jobs**: Laravel Queues
- **Caching**: Laravel Cache (Database)

## 📋 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0
- Redis (optional, for caching)

### Setup Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd smarterp
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Database Setup**
```bash
# Configure database in .env file
php artisan migrate
php artisan db:seed
```

6. **AI Configuration** (Optional)
```env
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_MODEL=gpt-3.5-turbo
AI_ENABLED=true
```

7. **Build Assets**
```bash
npm run build
```

8. **Start the application**
```bash
php artisan serve
```

## 👥 User Roles & Permissions

### System Roles
- **Super Admin**: Full system access
- **Admin**: Company-level administration
- **Manager**: Department management
- **Employee**: Standard user access

### Permission Groups
- **User Management**: CRUD operations on users
- **Document Management**: File upload, organization, sharing
- **Communication**: Chat, email, notifications
- **Approvals**: Request creation, approval workflows
- **AI Access**: AI assistant usage permissions

## 📁 Project Structure

```
smarterp/
├── app/
│   ├── Http/Controllers/      # Controllers
│   ├── Models/               # Eloquent Models
│   ├── Services/             # Business Logic Services
│   ├── Events/               # Event Classes
│   └── Main/                 # Core System Classes
├── database/
│   ├── migrations/           # Database Migrations
│   └── seeders/             # Database Seeders
├── resources/
│   ├── views/               # Blade Templates
│   │   ├── documents/       # Document Management
│   │   ├── ai/             # AI Assistant
│   │   ├── chat/           # Internal Chat
│   │   ├── approval-system/ # Approval Workflows
│   │   └── electronic-mail/ # Email System
│   └── js/                  # Frontend JavaScript
├── routes/
│   └── web.php              # Route Definitions
├── docs/                    # Documentation
└── config/                  # Configuration Files
```

## 🔧 Configuration

### AI Assistant Setup
1. Get OpenAI API key from [OpenAI Platform](https://platform.openai.com/api-keys)
2. Add to `.env` file:
```env
OPENAI_API_KEY=sk-your-api-key-here
OPENAI_MODEL=gpt-3.5-turbo
OPENAI_MAX_TOKENS=2000
AI_ENABLED=true
```

### File Storage
Configure storage disks in `config/filesystems.php`:
```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
    'documents' => [
        'driver' => 'local',
        'root' => storage_path('app/documents'),
        'url' => env('APP_URL').'/storage/documents',
        'visibility' => 'private',
    ],
]
```

### Broadcasting (Real-time Features)
Configure broadcasting in `.env`:
```env
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_key
PUSHER_APP_SECRET=your_pusher_secret
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1
```

## 📚 API Documentation

### AI Assistant Endpoints
```
POST   /ai/interact          # Interact with AI
GET    /ai/available         # Check AI availability
GET    /ai/datatable         # Get AI interactions
```

### Document Management
```
GET    /documents            # List documents
POST   /documents            # Upload document
GET    /documents/categories # List categories
POST   /documents/categories # Create category
```

### Chat System
```
GET    /chat                  # Chat interface
GET    /chat/conversations    # Get conversations
POST   /chat/messages         # Send message
```

### Approval System
```
GET    /approval-system       # Approval dashboard
POST   /approval-system       # Create request
POST   /approval-system/{id}/approve  # Approve request
```

## 🔍 Troubleshooting

### Common Issues

**AI Assistant Not Working**
- Check OpenAI API key in `.env`
- Verify API quota and billing
- Check network connectivity

**File Upload Issues**
- Check file permissions on `storage/` directory
- Verify PHP upload limits in `php.ini`
- Check disk space availability

**Real-time Features Not Working**
- Configure Pusher credentials
- Run `php artisan queue:work` for background jobs
- Check WebSocket connection

**Permission Errors**
- Clear cache: `php artisan config:clear`
- Run migrations: `php artisan migrate`
- Check user roles and permissions

## 📈 Performance Optimization

### Database Optimization
```bash
# Run database optimizations
php artisan db:monitor
php artisan db:show
```

### Caching
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Queue Management
```bash
# Start queue worker
php artisan queue:work

# Monitor queues
php artisan queue:monitor
```

## 🔐 Security Features

- **CSRF Protection**: All forms protected
- **XSS Prevention**: Input sanitization
- **SQL Injection**: Parameterized queries
- **File Upload Security**: Type and size validation
- **Role-based Access**: Granular permissions
- **Audit Logging**: Track all system activities

## 🚀 Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Configure production database
3. Set up SSL certificate
4. Configure file storage (AWS S3, etc.)
5. Set up monitoring and logging

### Docker Deployment
```dockerfile
FROM php:8.2-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    mysql-client

# Copy application
COPY . /var/www/html

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

# Configure nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
```

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

For support and questions:
- Email: support@smarterp.com
- Documentation: [docs/](docs/)
- Issues: [GitHub Issues](https://github.com/your-repo/issues)

## 🔄 Changelog

### Version 1.0.0
- ✅ Initial release with core ERP features
- ✅ AI Assistant integration
- ✅ Document Management System
- ✅ Internal Chat functionality
- ✅ Approval Workflow system
- ✅ Electronic Mail system

---

**Built with ❤️ using Laravel & Modern Web Technologies**
