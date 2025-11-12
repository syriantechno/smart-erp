<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Broadcast;

class ChatTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $company;
    protected $department;
    protected $otherUser;
    protected $conversation;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء بيانات الاختبار الأساسية
        $this->company = Company::factory()->create();
        $this->department = Department::factory()->create(['company_id' => $this->company->id]);

        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $this->otherUser = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        // إنشاء محادثة تجريبية
        $this->conversation = Conversation::factory()->create([
            'company_id' => $this->company->id,
        ]);

        // إضافة المشاركين للمحادثة
        $this->conversation->participants()->attach([
            $this->user->id => ['joined_at' => now()],
            $this->otherUser->id => ['joined_at' => now()],
        ]);

        // تسجيل الدخول
        $this->actingAs($this->user);
    }

    /**
     * اختبار صفحة الشات الرئيسية
     */
    public function test_chat_index_page_loads()
    {
        $response = $this->get(route('chat.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pageTitle', 'الشات');
        $response->assertViewIs('chat.index');
    }

    /**
     * اختبار جلب قائمة المحادثات
     */
    public function test_get_conversations_list()
    {
        // إنشاء عدة محادثات
        Conversation::factory()->count(3)->create([
            'company_id' => $this->company->id,
        ])->each(function ($conversation) {
            $conversation->participants()->attach([$this->user->id => ['joined_at' => now()]]);
        });

        $response = $this->getJson(route('chat.conversations'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'conversations' => [
                '*' => [
                    'id',
                    'title',
                    'last_message',
                    'unread_count',
                    'participants',
                    'updated_at'
                ]
            ]
        ]);

        // يجب أن تحتوي على المحادثات التي يشارك فيها المستخدم
        $this->assertGreaterThanOrEqual(4, count($response->json('conversations')));
    }

    /**
     * اختبار إنشاء محادثة جديدة
     */
    public function test_create_conversation()
    {
        $conversationData = [
            'title' => 'مناقشة مشروع ERP',
            'type' => 'group',
            'participants' => [$this->otherUser->id],
            'company_id' => $this->company->id,
        ];

        $response = $this->postJson(route('chat.start-conversation'), $conversationData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم إنشاء المحادثة بنجاح',
        ]);

        $this->assertDatabaseHas('conversations', [
            'title' => 'مناقشة مشروع ERP',
            'type' => 'group',
            'company_id' => $this->company->id,
        ]);

        // التحقق من إضافة المشاركين
        $conversation = Conversation::where('title', 'مناقشة مشروع ERP')->first();
        $this->assertTrue($conversation->participants()->where('user_id', $this->user->id)->exists());
        $this->assertTrue($conversation->participants()->where('user_id', $this->otherUser->id)->exists());
    }

    /**
     * اختبار إرسال رسالة نصية
     */
    public function test_send_text_message()
    {
        Broadcast::shouldReceive('event')->once();

        $messageData = [
            'conversation_id' => $this->conversation->id,
            'content' => 'مرحباً، كيف حالك؟',
            'type' => 'text',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->postJson(route('chat.send-message'), $messageData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم إرسال الرسالة بنجاح',
        ]);

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $this->conversation->id,
            'content' => 'مرحباً، كيف حالك؟',
            'type' => 'text',
            'sender_id' => $this->user->id,
        ]);
    }

    /**
     * اختبار إرسال رسالة مع ملف مرفق
     */
    public function test_send_message_with_file()
    {
        Storage::fake('public');
        Broadcast::shouldReceive('event')->once();

        $file = UploadedFile::fake()->image('screenshot.jpg', 800, 600);

        $messageData = [
            'conversation_id' => $this->conversation->id,
            'content' => 'إليك لقطة الشاشة',
            'type' => 'file',
            'file' => $file,
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->postJson(route('chat.send-message'), $messageData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $this->conversation->id,
            'type' => 'file',
            'sender_id' => $this->user->id,
        ]);

        // التحقق من حفظ الملف
        $message = Message::where('conversation_id', $this->conversation->id)
                         ->where('type', 'file')->first();
        Storage::disk('public')->assertExists($message->file_path);
    }

    /**
     * اختبار جلب رسائل المحادثة
     */
    public function test_get_conversation_messages()
    {
        // إنشاء رسائل في المحادثة
        Message::factory()->count(5)->create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->getJson(route('chat.messages', $this->conversation));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'messages' => [
                '*' => [
                    'id',
                    'content',
                    'type',
                    'sender',
                    'created_at',
                    'is_read'
                ]
            ]
        ]);

        $this->assertCount(5, $response->json('messages'));
    }

    /**
     * اختبار وضع علامة مقروء على الرسائل
     */
    public function test_mark_messages_as_read()
    {
        // إنشاء رسائل غير مقروءة
        $messages = Message::factory()->count(3)->create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => $this->otherUser->id,
            'company_id' => $this->company->id,
            'is_read' => false,
        ]);

        $response = $this->postJson(route('chat.mark-read', $this->conversation));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم تحديث حالة القراءة',
        ]);

        // التحقق من أن جميع الرسائل أصبحت مقروءة
        foreach ($messages as $message) {
            $this->assertDatabaseHas('messages', [
                'id' => $message->id,
                'is_read' => true,
            ]);
        }
    }

    /**
     * اختبار البحث في الرسائل
     */
    public function test_search_messages()
    {
        Message::factory()->create([
            'conversation_id' => $this->conversation->id,
            'content' => 'مناقشة متعلقة بمشروع التطوير',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        Message::factory()->create([
            'conversation_id' => $this->conversation->id,
            'content' => 'تقرير المبيعات الشهري',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $response = $this->getJson(route('chat.search', [
            'conversation_id' => $this->conversation->id,
            'query' => 'مشروع'
        ]));

        $response->assertStatus(200);
        $results = $response->json('messages');

        $this->assertCount(1, $results);
        $this->assertEquals('مناقشة متعلقة بمشروع التطوير', $results[0]['content']);
    }

    /**
     * اختبار إضافة مشارك للمحادثة
     */
    public function test_add_participant_to_conversation()
    {
        $newUser = User::factory()->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $participantData = [
            'user_id' => $newUser->id,
        ];

        $response = $this->postJson(route('chat.add-participant', $this->conversation), $participantData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم إضافة المشارك بنجاح',
        ]);

        $this->assertTrue($this->conversation->fresh()->participants()->where('user_id', $newUser->id)->exists());
    }

    /**
     * اختبار إزالة مشارك من المحادثة
     */
    public function test_remove_participant_from_conversation()
    {
        $response = $this->deleteJson(route('chat.remove-participant', [
            'conversation' => $this->conversation,
            'user' => $this->otherUser
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم إزالة المشارك بنجاح',
        ]);

        $this->assertFalse($this->conversation->fresh()->participants()->where('user_id', $this->otherUser->id)->exists());
    }

    /**
     * اختبار تحديث إعدادات المحادثة
     */
    public function test_update_conversation_settings()
    {
        $settingsData = [
            'title' => 'محادثة محدثة',
            'description' => 'وصف محدث للمحادثة',
            'is_private' => true,
        ];

        $response = $this->putJson(route('chat.update-settings', $this->conversation), $settingsData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم تحديث إعدادات المحادثة بنجاح',
        ]);

        $this->assertDatabaseHas('conversations', [
            'id' => $this->conversation->id,
            'title' => 'محادثة محدثة',
            'description' => 'وصف محدث للمحادثة',
            'is_private' => true,
        ]);
    }

    /**
     * اختبار إنشاء محادثة جماعية
     */
    public function test_create_group_conversation()
    {
        $users = User::factory()->count(5)->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        $groupData = [
            'title' => 'فريق التطوير',
            'description' => 'محادثة جماعية لفريق التطوير',
            'type' => 'group',
            'participants' => $users->pluck('id')->toArray(),
            'company_id' => $this->company->id,
        ];

        $response = $this->postJson(route('chat.create-group'), $groupData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $conversation = Conversation::where('title', 'فريق التطوير')->first();
        $this->assertNotNull($conversation);
        $this->assertEquals(6, $conversation->participants()->count()); // 5 + المستخدم الحالي
    }

    /**
     * اختبار إرسال رسائل متتالية (محاكاة دردشة)
     */
    public function test_conversation_flow()
    {
        Broadcast::shouldReceive('event')->times(3);

        // رسالة أولى
        $this->postJson(route('chat.send-message'), [
            'conversation_id' => $this->conversation->id,
            'content' => 'مرحباً بالجميع',
            'type' => 'text',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        // رسالة ثانية من مستخدم آخر
        $this->actingAs($this->otherUser);
        $this->postJson(route('chat.send-message'), [
            'conversation_id' => $this->conversation->id,
            'content' => 'مرحباً!',
            'type' => 'text',
            'sender_id' => $this->otherUser->id,
            'company_id' => $this->company->id,
        ]);

        // رسالة ثالثة من المستخدم الأول
        $this->actingAs($this->user);
        $this->postJson(route('chat.send-message'), [
            'conversation_id' => $this->conversation->id,
            'content' => 'كيف تسير الأمور؟',
            'type' => 'text',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        // التحقق من ترتيب الرسائل
        $messages = Message::where('conversation_id', $this->conversation->id)
                          ->orderBy('created_at')
                          ->get();

        $this->assertCount(3, $messages);
        $this->assertEquals('مرحباً بالجميع', $messages[0]->content);
        $this->assertEquals('مرحباً!', $messages[1]->content);
        $this->assertEquals('كيف تسير الأمور؟', $messages[2]->content);
    }

    /**
     * اختبار إرسال رسالة طويلة
     */
    public function test_send_long_message()
    {
        Broadcast::shouldReceive('event')->once();

        $longContent = str_repeat('هذا نص طويل جداً ', 100); // 2000 حرف تقريباً

        $messageData = [
            'conversation_id' => $this->conversation->id,
            'content' => $longContent,
            'type' => 'text',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->postJson(route('chat.send-message'), $messageData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $this->conversation->id,
            'content' => $longContent,
            'sender_id' => $this->user->id,
        ]);
    }

    /**
     * اختبار إرسال رسائل متعددة الملفات
     */
    public function test_send_multiple_files()
    {
        Storage::fake('public');
        Broadcast::shouldReceive('event')->once();

        $files = [
            UploadedFile::fake()->image('image1.jpg', 800, 600),
            UploadedFile::fake()->create('document.pdf', 1024),
            UploadedFile::fake()->create('spreadsheet.xlsx', 2048),
        ];

        $messageData = [
            'conversation_id' => $this->conversation->id,
            'content' => 'إليكم عدة ملفات',
            'type' => 'files',
            'files' => $files,
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->postJson(route('chat.send-message'), $messageData);

        $response->assertStatus(200);

        // التحقق من حفظ جميع الملفات
        $message = Message::where('conversation_id', $this->conversation->id)
                         ->where('type', 'files')->first();

        $this->assertNotNull($message);

        $attachments = $message->attachments;
        $this->assertCount(3, $attachments);

        foreach ($attachments as $attachment) {
            Storage::disk('public')->assertExists($attachment->file_path);
        }
    }

    /**
     * اختبار إنشاء محادثة مؤقتة (مثل الدردشة السريعة)
     */
    public function test_create_temporary_conversation()
    {
        $tempConversationData = [
            'title' => 'دردشة سريعة',
            'type' => 'temporary',
            'participants' => [$this->otherUser->id],
            'expires_at' => now()->addHours(24)->format('Y-m-d H:i:s'),
            'company_id' => $this->company->id,
        ];

        $response = $this->postJson(route('chat.create-temporary'), $tempConversationData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('conversations', [
            'title' => 'دردشة سريعة',
            'type' => 'temporary',
            'expires_at' => now()->addHours(24)->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * اختبار أرشفة المحادثة
     */
    public function test_archive_conversation()
    {
        $response = $this->postJson(route('chat.archive', $this->conversation));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم أرشفة المحادثة بنجاح',
        ]);

        $this->assertDatabaseHas('conversations', [
            'id' => $this->conversation->id,
            'is_archived' => true,
        ]);
    }

    /**
     * اختبار حذف المحادثة
     */
    public function test_delete_conversation()
    {
        $response = $this->deleteJson(route('chat.delete', $this->conversation));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم حذف المحادثة بنجاح',
        ]);

        $this->assertDatabaseMissing('conversations', ['id' => $this->conversation->id]);
        // الرسائل يجب أن تُحذف تلقائياً بسبب العلاقة
        $this->assertDatabaseMissing('messages', ['conversation_id' => $this->conversation->id]);
    }

    /**
     * اختبار إنشاء قناة عامة
     */
    public function test_create_public_channel()
    {
        $channelData = [
            'title' => 'الإعلانات العامة',
            'description' => 'قناة للإعلانات والأخبار العامة',
            'type' => 'channel',
            'is_public' => true,
            'company_id' => $this->company->id,
        ];

        $response = $this->postJson(route('chat.create-channel'), $channelData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('conversations', [
            'title' => 'الإعلانات العامة',
            'type' => 'channel',
            'is_public' => true,
        ]);
    }

    /**
     * اختبار الانضمام لقناة عامة
     */
    public function test_join_public_channel()
    {
        $channel = Conversation::factory()->create([
            'type' => 'channel',
            'is_public' => true,
            'company_id' => $this->company->id,
        ]);

        $response = $this->postJson(route('chat.join-channel', $channel));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'تم الانضمام للقناة بنجاح',
        ]);

        $this->assertTrue($channel->fresh()->participants()->where('user_id', $this->user->id)->exists());
    }

    /**
     * اختبار إرسال إشعارات للمشاركين
     */
    public function test_send_notifications_to_participants()
    {
        // إضافة عدة مشاركين للمحادثة
        $participants = User::factory()->count(3)->create([
            'company_id' => $this->company->id,
            'department_id' => $this->department->id,
        ]);

        foreach ($participants as $participant) {
            $this->conversation->participants()->attach($participant->id, ['joined_at' => now()]);
        }

        // إرسال رسالة
        $this->postJson(route('chat.send-message'), [
            'conversation_id' => $this->conversation->id,
            'content' => 'رسالة تجريبية',
            'type' => 'text',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        // التحقق من إرسال الإشعارات (محاكاة)
        // في التطبيق الحقيقي، سيتم إرسال إشعارات لجميع المشاركين عدا المرسل
        $this->assertDatabaseHas('messages', [
            'conversation_id' => $this->conversation->id,
            'content' => 'رسالة تجريبية',
        ]);
    }

    /**
     * اختبار البحث في المحادثات
     */
    public function test_search_conversations()
    {
        Conversation::factory()->create([
            'title' => 'مناقشة مشروع التطوير',
            'company_id' => $this->company->id,
        ])->participants()->attach($this->user->id, ['joined_at' => now()]);

        Conversation::factory()->create([
            'title' => 'تقرير المبيعات',
            'company_id' => $this->company->id,
        ])->participants()->attach($this->user->id, ['joined_at' => now()]);

        $response = $this->getJson(route('chat.search-conversations', ['query' => 'مشروع']));

        $response->assertStatus(200);
        $conversations = $response->json('conversations');

        $this->assertCount(1, $conversations);
        $this->assertEquals('مناقشة مشروع التطوير', $conversations[0]['title']);
    }

    /**
     * اختبار إحصائيات الشات
     */
    public function test_chat_statistics()
    {
        // إنشاء بيانات للإحصائيات
        Conversation::factory()->count(5)->create([
            'company_id' => $this->company->id,
        ])->each(function ($conversation) {
            $conversation->participants()->attach($this->user->id, ['joined_at' => now()]);
            Message::factory()->count(10)->create([
                'conversation_id' => $conversation->id,
                'sender_id' => $this->user->id,
                'company_id' => $this->company->id,
            ]);
        });

        $response = $this->getJson(route('chat.statistics'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total_conversations',
            'total_messages',
            'active_users',
            'messages_today',
            'top_conversations',
        ]);
    }

    /**
     * اختبار تصدير محادثة
     */
    public function test_export_conversation()
    {
        // إضافة رسائل للمحادثة
        Message::factory()->count(20)->create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ]);

        $exportData = [
            'conversation_id' => $this->conversation->id,
            'format' => 'txt',
            'include_attachments' => true,
        ];

        $response = $this->post(route('chat.export'), $exportData);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain');
        $response->assertHeader('Content-Disposition', 'attachment; filename*=UTF-8\'\'conversation-' . $this->conversation->id . '.txt');
    }

    /**
     * اختبار إنشاء محادثة مع بوت
     */
    public function test_create_bot_conversation()
    {
        $botConversationData = [
            'title' => 'الدردشة مع البوت',
            'type' => 'bot',
            'bot_type' => 'ai_assistant',
            'company_id' => $this->company->id,
        ];

        $response = $this->postJson(route('chat.create-bot-conversation'), $botConversationData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('conversations', [
            'title' => 'الدردشة مع البوت',
            'type' => 'bot',
            'bot_type' => 'ai_assistant',
        ]);
    }

    /**
     * اختبار إرسال رسالة للبوت
     */
    public function test_send_message_to_bot()
    {
        $botConversation = Conversation::factory()->create([
            'type' => 'bot',
            'bot_type' => 'ai_assistant',
            'company_id' => $this->company->id,
        ]);

        $botConversation->participants()->attach($this->user->id, ['joined_at' => now()]);

        $messageData = [
            'conversation_id' => $botConversation->id,
            'content' => 'ما هو الوقت الحالي؟',
            'type' => 'text',
            'sender_id' => $this->user->id,
            'company_id' => $this->company->id,
        ];

        $response = $this->postJson(route('chat.send-to-bot'), $messageData);

        $response->assertStatus(200);

        // يجب أن تكون هناك رسالة من البوت كإجابة
        $botResponse = Message::where('conversation_id', $botConversation->id)
                             ->where('sender_id', null) // البوت
                             ->where('type', 'bot_response')
                             ->first();

        $this->assertNotNull($botResponse);
    }
}
