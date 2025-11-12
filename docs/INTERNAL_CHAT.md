# Internal Chat System Documentation

## Overview
The Internal Chat System provides real-time messaging capabilities for employees within the ERP system. It supports direct messages, group chats, file sharing, and message history with a modern, intuitive interface.

## Features

### 💬 Core Capabilities
- **Real-time Messaging**: Instant message delivery
- **Direct Messages**: One-on-one conversations
- **Group Chats**: Multi-user conversations
- **File Sharing**: Share documents and media
- **Message History**: Persistent chat history
- **Online Status**: User presence indicators
- **Typing Indicators**: Show when users are typing

### 🔧 Advanced Features
- **Message Search**: Search through chat history
- **Message Reactions**: React to messages with emojis
- **Message Threads**: Reply to specific messages
- **Message Encryption**: Secure message transmission
- **Offline Support**: Queue messages when offline
- **Push Notifications**: Browser notifications

## Technical Implementation

### Database Schema
```sql
-- Conversations Table
CREATE TABLE conversations (
    id BIGINT PRIMARY KEY,
    title VARCHAR(255) NULL,
    type ENUM('direct', 'group') DEFAULT 'direct',
    created_by BIGINT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Conversation Participants Table
CREATE TABLE conversation_participants (
    id BIGINT PRIMARY KEY,
    conversation_id BIGINT,
    user_id BIGINT,
    is_admin BOOLEAN DEFAULT FALSE,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_read_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Messages Table
CREATE TABLE messages (
    id BIGINT PRIMARY KEY,
    conversation_id BIGINT,
    sender_id BIGINT,
    content TEXT,
    message_type ENUM('text', 'file', 'image') DEFAULT 'text',
    metadata JSON NULL,
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Models

#### Conversation Model
```php
class Conversation extends Model
{
    protected $fillable = [
        'title', 'type', 'created_by', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationships
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function participants() { return $this->belongsToMany(User::class, 'conversation_participants'); }
    public function messages() { return $this->hasMany(Message::class)->orderBy('created_at', 'asc'); }
    public function latestMessage() { return $this->hasOne(Message::class)->latest(); }

    // Accessors
    public function getDisplayNameAttribute() { /* Implementation */ }
    public function getUnreadCountAttribute() { /* Implementation */ }

    // Methods
    public function addParticipant($userId, $isAdmin = false) { /* Implementation */ }
    public function markAsRead($userId) { /* Implementation */ }
}
```

#### Message Model
```php
class Message extends Model
{
    protected $fillable = [
        'conversation_id', 'sender_id', 'content', 'message_type',
        'metadata', 'is_read', 'read_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    // Relationships
    public function conversation() { return $this->belongsTo(Conversation::class); }
    public function sender() { return $this->belongsTo(User::class, 'sender_id'); }

    // Accessors
    public function getFormattedTimeAttribute() { return $this->created_at->format('g:i A'); }
    public function getIsOwnAttribute() { return $this->sender_id === auth()->id(); }
    public function getFileUrlAttribute() { /* Implementation */ }
}
```

## Configuration

### Broadcasting Configuration
```php
// config/broadcasting.php
'connections' => [
    'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true,
        ],
    ],
]
```

### Environment Variables
```env
# Broadcasting
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_key
PUSHER_APP_SECRET=your_pusher_secret
PUSHER_APP_CLUSTER=mt1

# Chat Settings
CHAT_MAX_FILE_SIZE=10240
CHAT_ALLOWED_EXTENSIONS=jpg,jpeg,png,gif,pdf,doc,docx,txt
CHAT_MESSAGE_HISTORY_DAYS=365
CHAT_MAX_PARTICIPANTS=50
```

### Chat Configuration
```php
// config/chat.php
return [
    'max_file_size' => env('CHAT_MAX_FILE_SIZE', 10240), // KB
    'allowed_extensions' => explode(',', env('CHAT_ALLOWED_EXTENSIONS', 'jpg,jpeg,png,gif,pdf,doc,docx,txt')),
    'message_history_days' => env('CHAT_MESSAGE_HISTORY_DAYS', 365),
    'max_participants' => env('CHAT_MAX_PARTICIPANTS', 50),
    'real_time_enabled' => env('CHAT_REAL_TIME_ENABLED', true),

    'file_storage' => [
        'disk' => 'public',
        'path' => 'chat-files',
    ],

    'notification_settings' => [
        'browser_notifications' => true,
        'sound_enabled' => true,
        'desktop_notifications' => false,
    ],
];
```

## API Endpoints

### Conversations Management
```http
GET    /chat/conversations           # Get user's conversations
POST   /chat/conversations           # Create new conversation
GET    /chat/conversations/{id}      # Get conversation details
PUT    /chat/conversations/{id}      # Update conversation
DELETE /chat/conversations/{id}      # Delete conversation
```

### Messages Management
```http
GET    /chat/messages/{conversationId}    # Get conversation messages
POST   /chat/messages                     # Send new message
PUT    /chat/messages/{id}                # Update message
DELETE /chat/messages/{id}                # Delete message
POST   /chat/mark-read/{conversationId}   # Mark conversation as read
```

### Real-time Events
```javascript
// Listen for new messages
Echo.private('conversation.' + conversationId)
    .listen('.message.sent', (e) => {
        appendMessage(e.message);
    });

// Listen for user presence
Echo.join('chat')
    .here((users) => {
        updateOnlineUsers(users);
    })
    .joining((user) => {
        userJoined(user);
    })
    .leaving((user) => {
        userLeft(user);
    });
```

## Frontend Implementation

### JavaScript Chat Handler
```javascript
class ChatManager {
    constructor() {
        this.currentConversationId = null;
        this.messagesContainer = $('#messages-container');
        this.messageInput = $('#message-input');
        this.sendButton = $('#send-button');
        this.typingIndicator = $('#typing-indicator');

        this.initialize();
        this.setupEventListeners();
        this.setupRealTimeUpdates();
    }

    initialize() {
        this.loadConversations();
        this.setupAutoResize();
    }

    setupEventListeners() {
        // Send message on Enter
        this.messageInput.on('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });

        // Update send button state
        this.messageInput.on('input', () => {
            const hasContent = this.messageInput.val().trim().length > 0;
            this.sendButton.prop('disabled', !hasContent);
        });

        // File upload
        $('#file-input').on('change', (e) => {
            this.handleFileUpload(e.target.files[0]);
        });
    }

    setupRealTimeUpdates() {
        // Listen for new messages
        window.Echo.private('user.' + {{ auth()->id() }})
            .listen('.message.sent', (e) => {
                if (e.message.conversation_id === this.currentConversationId) {
                    this.appendMessage(e.message);
                    this.scrollToBottom();
                }
                this.updateConversationList();
            });
    }

    async loadConversations() {
        try {
            const response = await fetch('/chat/conversations');
            const data = await response.json();

            if (data.success) {
                this.renderConversations(data.conversations);
            }
        } catch (error) {
            console.error('Failed to load conversations:', error);
        }
    }

    async sendMessage() {
        const content = this.messageInput.val().trim();
        if (!content || !this.currentConversationId) return;

        try {
            this.showTypingIndicator();

            const response = await fetch('/chat/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    conversation_id: this.currentConversationId,
                    content: content
                })
            });

            const data = await response.json();

            if (data.success) {
                this.messageInput.val('');
                // Message will be appended via real-time event
            } else {
                this.showError(data.message);
            }
        } catch (error) {
            this.showError('Failed to send message');
        } finally {
            this.hideTypingIndicator();
        }
    }

    renderConversations(conversations) {
        const container = $('#conversations-list');
        container.empty();

        conversations.forEach(conversation => {
            const unreadBadge = conversation.unread_count > 0 ?
                `<span class="unread-badge">${conversation.unread_count}</span>` : '';

            const lastMessage = conversation.last_message ?
                `${conversation.last_message.sender_name}: ${conversation.last_message.content.substring(0, 30)}...` :
                'No messages yet';

            const item = $(`
                <div class="conversation-item p-3 rounded-lg mb-1 ${conversation.id === this.currentConversationId ? 'active' : ''}"
                     onclick="chatManager.openConversation(${conversation.id})">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center flex-1 min-w-0">
                            <div class="image-fit h-10 w-10 relative flex-shrink-0">
                                <img class="rounded-full" src="https://via.placeholder.com/40x40/cccccc/666666?text=${conversation.display_name.charAt(0)}" alt="User" />
                            </div>
                            <div class="ml-3 flex-1 min-w-0">
                                <div class="font-medium text-slate-900 truncate">${conversation.display_name}</div>
                                <div class="text-xs text-slate-500 truncate">${lastMessage}</div>
                            </div>
                        </div>
                        ${unreadBadge}
                    </div>
                </div>
            `);

            container.append(item);
        });
    }

    async openConversation(conversationId) {
        this.currentConversationId = conversationId;
        $('.conversation-item').removeClass('active');
        $(`.conversation-item:has([onclick*="${conversationId}"])`).addClass('active');

        try {
            const response = await fetch(`/chat/messages/${conversationId}`);
            const data = await response.json();

            if (data.success) {
                this.renderMessages(data.messages);
                $('#chat-title').text(data.conversation.display_name);
                $('#chat-container').show();
                $('#empty-state').hide();
                this.scrollToBottom();
            }
        } catch (error) {
            console.error('Failed to load messages:', error);
        }
    }

    renderMessages(messages) {
        this.messagesContainer.empty();

        messages.forEach(message => {
            this.appendMessage(message, false);
        });
    }

    appendMessage(message, animate = true) {
        const messageClass = message.is_own ? 'user' : 'ai';
        const messageHtml = `
            <div class="chat-bubble ${messageClass} ${animate ? 'fade-in' : ''}">
                <div class="message-content ${messageClass}">
                    <div class="flex items-center mb-2">
                        <span class="font-medium text-sm">${message.sender.name}</span>
                        <span class="text-xs text-gray-500 ml-auto">${message.formatted_time}</span>
                    </div>
                    <div class="text-sm">${this.formatMessageContent(message)}</div>
                </div>
            </div>
        `;

        this.messagesContainer.append(messageHtml);

        if (animate) {
            this.scrollToBottom();
        }
    }

    formatMessageContent(message) {
        switch (message.message_type) {
            case 'image':
                return `<img src="${message.file_url}" class="max-w-xs rounded" alt="Image">`;
            case 'file':
                return `<a href="${message.file_url}" target="_blank" class="underline">${message.file_name}</a>`;
            default:
                return message.content.replace(/\n/g, '<br>');
        }
    }

    showTypingIndicator() {
        this.typingIndicator.addClass('show');
    }

    hideTypingIndicator() {
        this.typingIndicator.removeClass('show');
    }

    scrollToBottom() {
        setTimeout(() => {
            this.messagesContainer.scrollTop(this.messagesContainer[0].scrollHeight);
        }, 100);
    }

    showError(message) {
        // Show error toast or alert
        console.error(message);
    }
}

// Initialize chat manager
const chatManager = new ChatManager();
```

## Real-time Implementation

### Broadcasting Events
```php
// App/Events/MessageSent.php
class MessageSent implements ShouldBroadcast
{
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('conversation.' . $this->message->conversation_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }
}
```

### Broadcasting Routes
```php
// routes/channels.php
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    return Conversation::find($conversationId)
                      ->participants()
                      ->where('user_id', $user->id)
                      ->exists();
});
```

## Security Implementation

### Message Encryption
```php
// Encrypt messages before storage
$message->content = encrypt($message->content);

// Decrypt when displaying
$message->content = decrypt($message->content);
```

### Access Control
```php
// Check if user can access conversation
if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
    abort(403, 'Access denied');
}
```

### File Upload Security
```php
$validator = Validator::make($request->all(), [
    'file' => 'file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt'
]);

// Store file securely
$path = $request->file('file')->store('chat-files', 'public');
```

## Performance Optimization

### Database Optimization
```sql
-- Optimize for chat queries
CREATE INDEX idx_messages_conversation_created ON messages (conversation_id, created_at);
CREATE INDEX idx_conversation_participants_user ON conversation_participants (user_id);
CREATE INDEX idx_conversation_participants_conversation ON conversation_participants (conversation_id);
```

### Caching Strategy
```php
// Cache user's conversations
Cache::remember("user_conversations_{$userId}", 300, function () use ($userId) {
    return Conversation::forUser($userId)->with('latestMessage')->get();
});

// Cache online users
Cache::remember('online_users', 60, function () {
    return User::where('last_activity', '>', now()->subMinutes(5))->pluck('id');
});
```

### Message Pagination
```php
// Load messages in chunks
$messages = $conversation->messages()
                        ->with('sender:id,name')
                        ->orderBy('created_at', 'desc')
                        ->paginate(50);
```

## File Upload Handling

### Client-side Upload
```javascript
function handleFileUpload(file) {
    const formData = new FormData();
    formData.append('conversation_id', currentConversationId);
    formData.append('file', file);

    fetch('/chat/messages', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // File uploaded successfully
        }
    });
}
```

### Server-side Processing
```php
public function sendMessage(Request $request)
{
    $request->validate([
        'conversation_id' => 'required|exists:conversations,id',
        'content' => 'nullable|string',
        'file' => 'nullable|file|max:10240'
    ]);

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $path = $file->store('chat-files', 'public');

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => auth()->id(),
            'content' => $file->getClientOriginalName(),
            'message_type' => $this->getFileType($file),
            'metadata' => [
                'original_name' => $file->getClientOriginalName(),
                'path' => basename($path),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]
        ]);
    } else {
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => auth()->id(),
            'content' => $request->content,
            'message_type' => 'text'
        ]);
    }

    broadcast(new MessageSent($message))->toOthers();

    return response()->json(['success' => true, 'message' => $message]);
}
```

## Error Handling

### Connection Issues
```javascript
// Handle WebSocket disconnection
window.Echo.connector.pusher.connection.bind('disconnected', () => {
    showToast('Connection lost. Messages will be sent when reconnected.', 'warning');
});

// Handle reconnection
window.Echo.connector.pusher.connection.bind('connected', () => {
    showToast('Reconnected successfully.', 'success');
});
```

### Message Delivery Failures
```php
try {
    broadcast(new MessageSent($message))->toOthers();
} catch (Exception $e) {
    Log::error('Broadcast failed', [
        'message_id' => $message->id,
        'error' => $e->getMessage()
    ]);

    // Store for later retry
    MessageRetry::create([
        'message_id' => $message->id,
        'attempts' => 0,
        'next_retry_at' => now()->addMinutes(5)
    ]);
}
```

## Mobile Responsiveness

### Responsive Design
```css
@media (max-width: 768px) {
    .chat-container {
        height: calc(100vh - 150px);
    }

    .conversation-item {
        padding: 0.75rem;
    }

    .message-content {
        max-width: 85%;
    }
}
```

### Touch Gestures
```javascript
// Swipe to go back on mobile
let touchStartX = 0;
let touchEndX = 0;

document.addEventListener('touchstart', e => {
    touchStartX = e.changedTouches[0].screenX;
});

document.addEventListener('touchend', e => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    const swipeThreshold = 50;
    if (touchEndX - touchStartX > swipeThreshold) {
        // Swipe right - go back
        history.back();
    }
}
```

## Future Enhancements

### Planned Features
- **Voice Messages**: Audio message recording and playback
- **Video Calls**: Integrated video calling functionality
- **Message Reactions**: Emoji reactions to messages
- **Message Threads**: Nested conversation threads
- **File Previews**: Preview documents before downloading
- **Message Scheduling**: Schedule messages to be sent later

### Advanced Features
- **End-to-end Encryption**: Secure message encryption
- **Self-destructing Messages**: Messages that auto-delete
- **Message Search**: Full-text search in messages
- **Chat Bots**: AI-powered chat assistants
- **Integration APIs**: Connect with external messaging platforms

## Monitoring & Analytics

### Usage Metrics
- **Message Count**: Total messages sent
- **Active Conversations**: Number of active chats
- **User Engagement**: Message frequency per user
- **File Sharing**: File upload/download statistics
- **Response Times**: Average response times

### Performance Monitoring
```php
// Track message delivery time
$message->sent_at = now();
$message->delivered_at = now();
$message->delivery_time = $message->delivered_at->diffInMilliseconds($message->sent_at);
```

## Troubleshooting

### Common Issues
1. **Messages Not Appearing**: Check broadcasting configuration
2. **File Upload Failures**: Verify file permissions and PHP limits
3. **Slow Performance**: Optimize database queries and add caching
4. **Connection Issues**: Check Pusher credentials and network

### Debug Mode
```env
APP_DEBUG=true
BROADCAST_CONNECTION=log
CHAT_DEBUG=true
```

### Logs
```php
// Log chat events
Log::info('Message sent', [
    'message_id' => $message->id,
    'conversation_id' => $message->conversation_id,
    'sender_id' => $message->sender_id,
    'content_length' => strlen($message->content)
]);
```

## Support Resources
- [Laravel Broadcasting](https://laravel.com/docs/broadcasting)
- [Pusher Documentation](https://pusher.com/docs)
- [WebSocket Security](https://tools.ietf.org/html/rfc6455)

---

**Last Updated:** November 12, 2024
**Version:** 1.0.0
