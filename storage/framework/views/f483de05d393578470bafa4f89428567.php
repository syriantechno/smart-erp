<?php $__env->startSection('subhead'); ?>
    <title>Internal Chat - <?php echo e(config('app.name')); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .chat-message {
            max-width: 70%;
            margin-bottom: 1rem;
        }
        .chat-message.own {
            margin-left: auto;
            margin-right: 0;
        }
        .chat-message.other {
            margin-left: 0;
            margin-right: auto;
        }
        .chat-bubble {
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            position: relative;
        }
        .chat-bubble.own {
            background-color: #3b82f6;
            color: white;
            border-bottom-right-radius: 0.25rem;
        }
        .chat-bubble.other {
            background-color: #f3f4f6;
            color: #374151;
            border-bottom-left-radius: 0.25rem;
        }
        .chat-messages {
            height: 400px;
            overflow-y: auto;
            padding: 1rem;
        }
        .conversation-item {
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
            border-radius: 1rem;
            background-color: rgba(255, 255, 255, 0.08);
            padding: 0.75rem;
        }
        .conversation-item:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(4px);
        }
        .conversation-item.active {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(15, 31, 61, 0.35);
        }
        .unread-badge {
            background-color: rgba(239, 68, 68, 0.9);
            color: white;
            border-radius: 999px;
            min-width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0 0.35rem;
        }
        #conversation-search {
            color: #fff;
        }
        #conversation-search::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('subcontent'); ?>
    <?php echo $__env->make('components.global-notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-3 2xl:col-span-2">
            
            <div class="intro-y">
                <div
                    class="rounded-2xl border border-white/10 text-white shadow-[0_20px_55px_rgba(10,24,55,0.38)]"
                    style="background: linear-gradient(135deg, var(--primary-color, #0f1f3d) 0%, var(--secondary-color, #1d3d8f) 45%, var(--accent-color, #0998d6) 100%);"
                >
                    <div class="p-6 space-y-5">
                        <div>
                            <p class="text-xs uppercase tracking-[0.35em] text-white/70">Chat Control Center</p>
                            <h3 class="mt-2 text-xl font-semibold leading-tight">Keep every thread aligned</h3>
                            <p class="mt-2 text-sm text-white/80">Launch new conversations, search histories, and respond faster.</p>
                        </div>
                        <button
                            type="button"
                            class="flex w-full items-center rounded-xl bg-white/15 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-400/30 transition hover:bg-white/20"
                            onclick="showNewChatModal()"
                        >
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Plus','class' => 'mr-3 h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Plus','class' => 'mr-3 h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                            Start New Chat
                            <span class="ml-auto rounded-full bg-white/20 px-2 py-0.5 text-[11px] tracking-wide">Create</span>
                        </button>
                        <div class="space-y-4 border-t border-white/10 pt-4">
                            <div class="relative text-white">
                                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'conversation-search','class' => 'w-full border-transparent bg-white/15 px-4 py-3 pr-10 text-sm placeholder-white/70 focus:bg-white/20 focus:ring-0','type' => 'text','placeholder' => 'Search conversations']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'conversation-search','class' => 'w-full border-transparent bg-white/15 px-4 py-3 pr-10 text-sm placeholder-white/70 focus:bg-white/20 focus:ring-0','type' => 'text','placeholder' => 'Search conversations']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['class' => 'absolute inset-y-0 right-0 z-10 my-auto mr-3 h-4 w-4 text-white/70','icon' => 'Search']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'absolute inset-y-0 right-0 z-10 my-auto mr-3 h-4 w-4 text-white/70','icon' => 'Search']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                            </div>
                            <div id="conversations-list" class="rounded-2xl border border-white/15 bg-white/10 p-2 max-h-96 overflow-y-auto">
                                <!-- Conversations will be loaded here -->
                                <div class="text-center py-8 text-white/70">
                                    Loading conversations...
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-white/10 pt-4 space-y-2 text-sm font-semibold text-white/80">
                            <div class="flex items-center gap-2 rounded-xl bg-white/5 px-3 py-2">
                                <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                                Direct Messages
                                <span class="ml-auto text-[11px] text-white/60">Focus chats</span>
                            </div>
                            <div class="flex items-center gap-2 rounded-xl bg-white/5 px-3 py-2">
                                <span class="h-2 w-2 rounded-full bg-sky-300"></span>
                                Project Rooms
                                <span class="ml-auto text-[11px] text-white/60">Collaboration</span>
                            </div>
                            <div class="flex items-center gap-2 rounded-xl bg-white/5 px-3 py-2">
                                <span class="h-2 w-2 rounded-full bg-amber-300"></span>
                                Announcements
                                <span class="ml-auto text-[11px] text-white/60">Broadcast</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-span-12 lg:col-span-9 2xl:col-span-10">
            <div id="chat-container" class="intro-y box" style="display: none;">
                <!-- Chat Header -->
                <div class="flex items-center justify-between p-5 border-b border-slate-200/60">
                    <div class="flex items-center">
                        <div class="image-fit h-10 w-10 relative">
                            <div id="chat-avatar" class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-700 font-semibold">
                                U
                            </div>
                        </div>
                        <div class="ml-3">
                            <div id="chat-title" class="font-medium text-slate-900 dark:text-white">Select a conversation</div>
                            <div id="chat-subtitle" class="text-slate-500 text-sm">Choose a conversation to start chatting</div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button
                            type="button"
                            class="btn-tonal btn-tonal--info min-h-[36px] px-3 text-sm font-semibold"
                            onclick="refreshMessages()"
                        >
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'RefreshCw','class' => 'w-4 h-4 mr-1 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'RefreshCw','class' => 'w-4 h-4 mr-1 icon-hover-rise']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                            Refresh
                        </button>
                    </div>
                </div>

                <!-- Messages Area -->
                <div id="messages-area" class="chat-messages bg-slate-50 dark:bg-darkmode-600">
                    <!-- Messages will be loaded here -->
                </div>

                <!-- Message Input -->
                <div class="p-5 border-t border-slate-200/60">
                    <div class="flex items-center gap-3">
                        <div class="flex-1 relative">
                            <?php if (isset($component)) { $__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-textarea.index','data' => ['id' => 'message-input','class' => 'border-transparent bg-slate-100 px-4 py-3 pr-12 resize-none','rows' => '1','placeholder' => 'Type your message...','onkeydown' => 'handleKeyPress(event)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'message-input','class' => 'border-transparent bg-slate-100 px-4 py-3 pr-12 resize-none','rows' => '1','placeholder' => 'Type your message...','onkeydown' => 'handleKeyPress(event)']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf)): ?>
<?php $attributes = $__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf; ?>
<?php unset($__attributesOriginal29dbcf960a4ade6d0a2b790c04ae12cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf)): ?>
<?php $component = $__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf; ?>
<?php unset($__componentOriginal29dbcf960a4ade6d0a2b790c04ae12cf); ?>
<?php endif; ?>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <input type="file" id="file-input" class="hidden" accept="image/*,.pdf,.doc,.docx,.txt" />
                                <button onclick="document.getElementById('file-input').click()" class="text-slate-500 hover:text-slate-700">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Paperclip','class' => 'w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Paperclip','class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                                </button>
                            </div>
                        </div>
                        <button
                            id="send-button"
                            type="button"
                            class="btn-tonal btn-tonal--success min-h-[42px] px-4 text-sm font-semibold group disabled:opacity-60"
                            onclick="sendMessage()"
                            disabled
                        >
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Send','class' => 'w-4 h-4 mr-2 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Send','class' => 'w-4 h-4 mr-2 icon-hover-rise']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                            Send
                        </button>
                    </div>
                    <div id="file-preview" class="mt-2 hidden">
                        <div class="flex items-center gap-2 p-2 bg-slate-100 rounded">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'File','class' => 'w-4 h-4 text-slate-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'File','class' => 'w-4 h-4 text-slate-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                            <span id="file-name" class="text-sm text-slate-700"></span>
                            <button onclick="clearFile()" class="text-red-500 hover:text-red-700">
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'X','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'X','class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="intro-y box text-center py-16">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'MessageSquare','class' => 'w-16 h-16 text-slate-300 mx-auto mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'MessageSquare','class' => 'w-16 h-16 text-slate-300 mx-auto mb-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                <h3 class="text-lg font-medium text-slate-600 dark:text-slate-400 mb-2">No conversation selected</h3>
                <p class="text-slate-500 mb-4">Choose a conversation from the sidebar to start chatting</p>
                <button
                    type="button"
                    class="btn-tonal btn-tonal--success min-h-[42px] px-4 text-sm font-semibold"
                    onclick="showNewChatModal()"
                >
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Plus','class' => 'w-4 h-4 mr-2 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Plus','class' => 'w-4 h-4 mr-2 icon-hover-rise']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                    Start New Chat
                </button>
            </div>
        </div>
    </div>

    <!-- New Chat Modal -->
    <?php if (isset($component)) { $__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.form','data' => ['id' => 'new-chat-modal','title' => 'Start New Conversation']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'new-chat-modal','title' => 'Start New Conversation']); ?>
        <form id="new-chat-form">
            <div class="mb-4">
                <label class="form-label">Conversation Type</label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="radio" name="chat_type" value="direct" checked class="mr-2">
                        <span>Direct Message</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="chat_type" value="group" class="mr-2">
                        <span>Group Chat</span>
                    </label>
                </div>
            </div>

            <div id="group-title-section" class="mb-4" style="display: none;">
                <label class="form-label">Group Title</label>
                <?php if (isset($component)) { $__componentOriginal40054831fd8fc1521987609af4b37cc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal40054831fd8fc1521987609af4b37cc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-input.index','data' => ['id' => 'group-title','name' => 'group_title','type' => 'text','placeholder' => 'Enter group name','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'group-title','name' => 'group_title','type' => 'text','placeholder' => 'Enter group name','class' => 'w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $attributes = $__attributesOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__attributesOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal40054831fd8fc1521987609af4b37cc0)): ?>
<?php $component = $__componentOriginal40054831fd8fc1521987609af4b37cc0; ?>
<?php unset($__componentOriginal40054831fd8fc1521987609af4b37cc0); ?>
<?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="form-label">Select Participants</label>
                <div id="participants-list" class="max-h-48 overflow-y-auto border border-slate-200 rounded p-2">
                    <!-- Participants will be loaded here -->
                </div>
            </div>
        </form>

        <?php $__env->slot('footer'); ?>
            <div class="flex justify-end w-full gap-2">
                <button
                    type="button"
                    class="btn-tonal btn-tonal--neutral min-h-[40px] px-4"
                    data-tw-dismiss="modal"
                >
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'X','class' => 'w-4 h-4 mr-2 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'X','class' => 'w-4 h-4 mr-2 icon-hover-rise']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                    Cancel
                </button>
                <button
                    type="button"
                    class="btn-tonal btn-tonal--success min-h-[40px] px-4"
                    onclick="startNewConversation()"
                >
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'MessageCircle','class' => 'w-4 h-4 mr-2 icon-hover-rise']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'MessageCircle','class' => 'w-4 h-4 mr-2 icon-hover-rise']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                    Start Chat
                </button>
            </div>
        <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82)): ?>
<?php $attributes = $__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82; ?>
<?php unset($__attributesOriginal8ffb2951ef6cc6f4f3162130bd0a3e82); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82)): ?>
<?php $component = $__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82; ?>
<?php unset($__componentOriginal8ffb2951ef6cc6f4f3162130bd0a3e82); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['type' => 'button','id' => 'open-new-chat-modal-btn','class' => 'hidden','dataTwToggle' => 'modal','dataTwTarget' => '#new-chat-modal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','id' => 'open-new-chat-modal-btn','class' => 'hidden','data-tw-toggle' => 'modal','data-tw-target' => '#new-chat-modal']); ?>
        Open New Chat Modal
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $attributes = $__attributesOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__attributesOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $component = $__componentOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__componentOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        let currentConversationId = null;
        let selectedFile = null;

        // Ensure jQuery alias `$` is available even if jQuery is in noConflict mode
        const $ = window.jQuery || window.$;
        const CSRF_TOKEN = '<?php echo e(csrf_token()); ?>';

        if ($ && CSRF_TOKEN) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        }

        if ($) {
            $(document).ready(function() {
                loadConversations();
                setupEventListeners();
                setupRealTimeUpdates();
            });
        } else {
            console.error('jQuery is not available on the chat page.');
        }

        function setupEventListeners() {
            // Message input
            $('#message-input').on('input', function() {
                const hasContent = $(this).val().trim() || selectedFile;
                $('#send-button').prop('disabled', !hasContent);
            });

            // File input
            $('#file-input').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    selectedFile = file;
                    $('#file-name').text(file.name);
                    $('#file-preview').removeClass('hidden');
                    $('#message-input').trigger('input');
                }
            });

            // Conversation search
            $('#conversation-search').on('input', function() {
                filterConversations($(this).val());
            });
        }

        function setupRealTimeUpdates() {
            // Skip realtime wiring if Echo is not configured
            if (typeof window.Echo === 'undefined' || !window.Echo) {
                console.warn('Laravel Echo is not available on the chat page. Realtime updates are disabled.');
                return;
            }

            // Listen for new messages
            window.Echo.private('user.' + <?php echo e(auth()->id()); ?>)
                .listen('.message.sent', (e) => {
                    if (e.message.conversation_id === currentConversationId) {
                        appendMessage(e.message);
                        scrollToBottom();
                    }
                    // Refresh conversations list
                    loadConversations();
                });
        }

        function loadConversations() {
            $.get('<?php echo e(route("chat.conversations")); ?>')
                .done(function(response) {
                    if (response.success) {
                        renderConversations(response.conversations);
                    }
                });
        }

        function renderConversations(conversations) {
            const container = $('#conversations-list');
            container.empty();

            if (conversations.length === 0) {
                container.html('<div class="text-center py-8 text-slate-500">No conversations yet</div>');
                return;
            }

            conversations.forEach(function(conversation) {
                const isActive = conversation.id === currentConversationId;
                const unreadBadge = conversation.unread_count > 0 ?
                    `<span class="unread-badge">${conversation.unread_count}</span>` : '';

                const lastMessage = conversation.last_message ?
                    `<div class="text-xs text-slate-500 truncate">${conversation.last_message.sender_name}: ${conversation.last_message.content}</div>` :
                    '<div class="text-xs text-slate-500">No messages yet</div>';

                const item = `
                    <div class="conversation-item p-3 ${isActive ? 'active' : ''}" onclick="openConversation(${conversation.id})">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="image-fit h-10 w-10 relative flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-700 font-semibold">
                                        ${conversation.display_name.charAt(0)}
                                    </div>
                                </div>
                                <div class="ml-3 flex-1 min-w-0">
                                    <div class="font-medium text-slate-900 dark:text-white truncate">${conversation.display_name}</div>
                                    ${lastMessage}
                                </div>
                            </div>
                            ${unreadBadge}
                        </div>
                    </div>
                `;
                container.append(item);
            });
        }

        function openConversation(conversationId) {
            currentConversationId = conversationId;

            // Update UI
            $('#empty-state').hide();
            $('#chat-container').show();
            $('.conversation-item').removeClass('active');
            $(`.conversation-item:has([onclick="openConversation(${conversationId})"])`).addClass('active');

            // Load messages
            loadMessages(conversationId);
        }

        function loadMessages(conversationId) {
            $.get('<?php echo e(route("chat.messages", ":id")); ?>'.replace(':id', conversationId))
                .done(function(response) {
                    if (response.success) {
                        $('#chat-title').text(response.conversation.display_name);
                        $('#chat-subtitle').text(`${response.conversation.type} conversation`);
                        renderMessages(response.messages);
                        scrollToBottom();
                    }
                });
        }

        function renderMessages(messages) {
            const container = $('#messages-area');
            container.empty();

            if (messages.length === 0) {
                container.html('<div class="text-center py-8 text-slate-500">No messages yet. Start the conversation!</div>');
                return;
            }

            let lastDate = null;
            messages.forEach(function(message) {
                // Add date separator if needed
                if (message.formatted_date !== lastDate) {
                    container.append(`
                        <div class="flex justify-center my-4">
                            <span class="px-3 py-1 bg-slate-200 text-slate-600 text-xs rounded-full">${message.formatted_date}</span>
                        </div>
                    `);
                    lastDate = message.formatted_date;
                }

                const messageClass = message.is_own ? 'own' : 'other';
                const bubbleClass = message.is_own ? 'own' : 'other';

                let messageContent = message.content;

                // Handle file messages
                if (message.message_type === 'image') {
                    messageContent = `<img src="${message.file_url}" class="max-w-xs rounded" alt="Image">`;
                } else if (message.message_type === 'file') {
                    messageContent = `
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <a href="${message.file_url}" target="_blank" class="underline">${message.file_name}</a>
                        </div>
                    `;
                }

                const messageHtml = `
                    <div class="chat-message ${messageClass}">
                        <div class="chat-bubble ${bubbleClass}">
                            ${messageContent}
                            <div class="text-xs mt-1 opacity-70">${message.formatted_time}</div>
                        </div>
                    </div>
                `;

                container.append(messageHtml);
            });
        }

        function sendMessage() {
            if (!currentConversationId) return;

            const content = $('#message-input').val().trim();
            if (!content && !selectedFile) return;

            const formData = new FormData();
            formData.append('conversation_id', currentConversationId);
            if (content) {
                formData.append('content', content);
            }
            if (selectedFile) {
                formData.append('file', selectedFile);
            }

            $.ajax({
                url: '<?php echo e(route("chat.send-message")); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        $('#message-input').val('');
                        clearFile();
                        // Refresh messages immediately in case realtime isn't configured
                        if (currentConversationId) {
                            loadMessages(currentConversationId);
                        }
                    }
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'Failed to send message';
                    showToast(error, 'error');
                }
            });
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        function clearFile() {
            selectedFile = null;
            $('#file-input').val('');
            $('#file-preview').addClass('hidden');
            $('#message-input').trigger('input');
        }

        function showNewChatModal() {
            loadUsersForChat();
            const trigger = document.getElementById('open-new-chat-modal-btn');
            if (trigger) {
                trigger.click();
                return;
            }
            const modalEl = document.getElementById('new-chat-modal');
            if (modalEl && window.tailwind?.Modal) {
                window.tailwind.Modal.getOrCreateInstance(modalEl).show();
            }
        }

        function loadUsersForChat() {
            // Load users list (excluding current user)
            const usersList = $('#participants-list');
            usersList.html('<div class="text-center py-4 text-slate-500">Loading users...</div>');

            // For demo purposes, we'll use a simple list
            const users = <?php echo json_encode($users, 15, 512) ?>;
            usersList.empty();

            users.forEach(function(user) {
                const userItem = `
                    <label class="flex items-center p-2 hover:bg-slate-100 rounded cursor-pointer">
                        <input type="checkbox" class="participant-checkbox mr-3" value="${user.id}">
                        <div class="image-fit h-8 w-8 relative mr-3">
                            <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-700 text-xs font-semibold">
                                ${user.name.charAt(0)}
                            </div>
                        </div>
                        <div>
                            <div class="font-medium">${user.name}</div>
                            <div class="text-sm text-slate-500">${user.email}</div>
                        </div>
                    </label>
                `;
                usersList.append(userItem);
            });
        }

        function startNewConversation() {
            const chatType = $('input[name="chat_type"]:checked').val();
            const selectedParticipants = $('.participant-checkbox:checked');

            if (chatType === 'direct' && selectedParticipants.length !== 1) {
                showToast('Please select exactly one participant for direct messages', 'warning');
                return;
            }

            if (chatType === 'group' && selectedParticipants.length < 2) {
                showToast('Please select at least 2 participants for group chat', 'warning');
                return;
            }

            const participantIds = selectedParticipants.map(function() {
                return $(this).val();
            }).get();

            const data = {
                type: chatType,
                participant_id: participantIds[0], // For direct messages
                participant_ids: participantIds, // For group messages
                title: $('#group-title').val(),
            };

            $.post('<?php echo e(route("chat.start-conversation")); ?>', data)
                .done(function(response) {
                    if (response.success) {
                        const modalEl = document.getElementById('new-chat-modal');
                        if (modalEl) {
                            modalEl.dispatchEvent(new CustomEvent('close-modal'));
                        }
                        loadConversations();
                        if (response.conversation_id) {
                            openConversation(response.conversation_id);
                        }
                        showToast('Conversation started successfully', 'success');
                    } else {
                        showToast(response.message, 'error');
                    }
                })
                .fail(function() {
                    showToast('Failed to start conversation', 'error');
                });
        }

        function refreshMessages() {
            if (currentConversationId) {
                loadMessages(currentConversationId);
            }
        }

        function filterConversations(searchTerm) {
            const term = searchTerm.toLowerCase();
            $('.conversation-item').each(function() {
                const name = $(this).find('.font-medium').text().toLowerCase();
                $(this).toggle(name.includes(term));
            });
        }

        function scrollToBottom() {
            const container = document.getElementById('messages-area');
            container.scrollTop = container.scrollHeight;
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-lg text-white ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Make functions globally available
        window.showNewChatModal = showNewChatModal;
        window.openConversation = openConversation;
        window.sendMessage = sendMessage;
        window.clearFile = clearFile;
        window.startNewConversation = startNewConversation;
        window.refreshMessages = refreshMessages;
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\ERP System\Source\resources\views/chat/index.blade.php ENDPATH**/ ?>