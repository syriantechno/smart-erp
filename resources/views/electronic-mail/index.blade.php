@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Electronic Mail - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')
    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-3 2xl:col-span-2">
            <h2 class="intro-y mr-auto mt-2 text-lg font-medium">Electronic Mail</h2>
            <!-- BEGIN: Inbox Menu -->
            <div class="intro-y box mt-6 bg-primary p-5">
                <x-base.button
                    class="mt-1 w-full bg-white text-slate-600 dark:border-darkmode-300 dark:bg-darkmode-300 dark:text-slate-300"
                    type="button"
                    onclick="openComposeModal(); return false;"
                >
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="Edit"
                    /> Compose
                </x-base.button>
                <div class="mt-6 border-t border-white/10 pt-6 text-white dark:border-darkmode-400">
                    <a
                        href="javascript:void(0)"
                        class="js-mail-folder-link flex items-center rounded-md px-3 py-2 font-medium {{ $currentFolder === 'inbox' ? 'bg-white/10 dark:bg-darkmode-700' : '' }}"
                        data-folder="inbox"
                        onclick="return changeMailFolder(event, 'inbox')"
                    >
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="Mail"
                        /> Inbox
                        @if($inboxCount > 0)
                            <span class="ml-auto rounded-full bg-white/20 px-2 py-1 text-xs">{{ $inboxCount }}</span>
                        @endif
                    </a>
                    <a
                        href="javascript:void(0)"
                        class="js-mail-folder-link mt-2 flex items-center rounded-md px-3 py-2 {{ $currentFolder === 'starred' ? 'bg-white/10 dark:bg-darkmode-700' : '' }}"
                        data-folder="starred"
                        onclick="return changeMailFolder(event, 'starred')"
                    >
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="Star"
                        /> Starred
                        @if($starredCount > 0)
                            <span class="ml-auto rounded-full bg-white/20 px-2 py-1 text-xs">{{ $starredCount }}</span>
                        @endif
                    </a>
                    <a
                        href="javascript:void(0)"
                        class="js-mail-folder-link mt-2 flex items-center rounded-md px-3 py-2 {{ $currentFolder === 'sent' ? 'bg-white/10 dark:bg-darkmode-700' : '' }}"
                        data-folder="sent"
                        onclick="return changeMailFolder(event, 'sent')"
                    >
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="Send"
                        /> Sent
                        @if($sentCount > 0)
                            <span class="ml-auto rounded-full bg-white/20 px-2 py-1 text-xs">{{ $sentCount }}</span>
                        @endif
                    </a>
                    <a
                        href="javascript:void(0)"
                        class="js-mail-folder-link mt-2 flex items-center rounded-md px-3 py-2 {{ $currentFolder === 'draft' ? 'bg-white/10 dark:bg-darkmode-700' : '' }}"
                        data-folder="draft"
                        onclick="return changeMailFolder(event, 'draft')"
                    >
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="FileText"
                        /> Draft
                        @if($draftCount > 0)
                            <span class="ml-auto rounded-full bg-white/20 px-2 py-1 text-xs">{{ $draftCount }}</span>
                        @endif
                    </a>
                </div>
                <div class="mt-4 border-t border-white/10 pt-4 text-white dark:border-darkmode-400">
                    <a
                        class="flex items-center truncate px-3 py-2"
                        href="#"
                    >
                        <div class="mr-3 h-2 w-2 rounded-full bg-pending"></div>
                        Work
                    </a>
                    <a
                        class="mt-2 flex items-center truncate rounded-md px-3 py-2"
                        href="#"
                    >
                        <div class="mr-3 h-2 w-2 rounded-full bg-success"></div>
                        Personal
                    </a>
                    <a
                        class="mt-2 flex items-center truncate rounded-md px-3 py-2"
                        href="#"
                    >
                        <div class="mr-3 h-2 w-2 rounded-full bg-warning"></div>
                        Important
                    </a>
                    <a
                        class="mt-2 flex items-center truncate rounded-md px-3 py-2"
                        href="#"
                    >
                        <div class="mr-3 h-2 w-2 rounded-full bg-danger"></div>
                        Urgent
                    </a>
                </div>
            </div>
            <!-- END: Inbox Menu -->
        </div>
        <div class="col-span-12 lg:col-span-9 2xl:col-span-10">
            <!-- BEGIN: Inbox Filter -->
            <div class="intro-y flex flex-col-reverse items-center sm:flex-row">
                <div class="relative mr-auto mt-3 w-full sm:mt-0 sm:w-auto">
                    <x-base.lucide
                        class="absolute inset-y-0 left-0 z-10 my-auto ml-3 h-4 w-4 text-slate-500"
                        icon="Search"
                    />
                    <x-base.form-input
                        id="mail-search"
                        class="!box w-full px-10 sm:w-64"
                        type="text"
                        placeholder="Search mail"
                    />
                    <x-base.menu class="absolute inset-y-0 right-0 mr-3 flex items-center" placement="bottom-start">
                        <x-base.menu.button class="block h-4 w-4" href="#" role="button" as="a">
                            <x-base.lucide class="h-4 w-4 cursor-pointer text-slate-500" icon="ChevronDown" />
                        </x-base.menu.button>
                        <x-base.menu.items class="!-ml-[228px] mt-2.5 w-[478px] pt-2">
                            <div class="grid grid-cols-12 gap-4 gap-y-3 p-3">
                                <div class="col-span-6">
                                    <x-base.form-label class="text-xs" for="search-from">From</x-base.form-label>
                                    <x-base.form-input class="flex-1" id="search-from" type="text" placeholder="example@gmail.com" />
                                </div>
                                <div class="col-span-6">
                                    <x-base.form-label class="text-xs" for="search-to">To</x-base.form-label>
                                    <x-base.form-input class="flex-1" id="search-to" type="text" placeholder="example@gmail.com" />
                                </div>
                                <div class="col-span-6">
                                    <x-base.form-label class="text-xs" for="search-subject">Subject</x-base.form-label>
                                    <x-base.form-input class="flex-1" id="search-subject" type="text" placeholder="Important Meeting" />
                                </div>
                                <div class="col-span-6">
                                    <x-base.form-label class="text-xs" for="search-has-words">Has the Words</x-base.form-label>
                                    <x-base.form-input class="flex-1" id="search-has-words" type="text" placeholder="Job, Work, Documentation" />
                                </div>
                                <div class="col-span-6">
                                    <x-base.form-label class="text-xs" for="search-no-words">Doesn't Have</x-base.form-label>
                                    <x-base.form-input class="flex-1" id="search-no-words" type="text" placeholder="Job, Work, Documentation" />
                                </div>
                                <div class="col-span-6">
                                    <x-base.form-label class="text-xs" for="search-size">Size</x-base.form-label>
                                    <x-base.form-select class="flex-1" id="search-size">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>35</option>
                                        <option>50</option>
                                    </x-base.form-select>
                                </div>
                                <div class="col-span-12 mt-3 flex items-center">
                                    <x-base.button class="ml-auto w-32" variant="secondary">Create Filter</x-base.button>
                                    <x-base.button id="mail-search-btn" class="ml-2 w-32" variant="primary">Search</x-base.button>
                                </div>
                            </div>
                        </x-base.menu.items>
                    </x-base.menu>
                </div>
                <div class="flex w-full sm:w-auto">
                    <x-base.button class="mr-2 shadow-md" variant="primary" onclick="openComposeModal(); return false;">
                        Compose
                    </x-base.button>
                    <x-base.menu>
                        <x-base.menu.button class="box px-2" as="x-base.button">
                            <span class="flex h-5 w-5 items-center justify-center">
                                <x-base.lucide class="h-4 w-4" icon="Plus" />
                            </span>
                        </x-base.menu.button>
                        <x-base.menu.items class="w-40">
                            <x-base.menu.item onclick="openComposeModal(); return false;">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" />
                                New Message
                            </x-base.menu.item>
                            <x-base.menu.item onclick="openMailAccountSettingsModal()">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="Settings" />
                                Personal Mail Settings
                            </x-base.menu.item>
                        </x-base.menu.items>
                    </x-base.menu>
                </div>
            </div>
            <!-- END: Inbox Filter -->
            <!-- BEGIN: Inbox Content -->
            <div class="intro-y box mt-5">
                <div class="flex flex-col-reverse border-b border-slate-200/60 p-5 text-slate-500 sm:flex-row">
                    <div class="-mx-5 mt-3 flex items-center border-t border-slate-200/60 px-5 pt-5 sm:mx-0 sm:mt-0 sm:border-0 sm:px-0 sm:pt-0">
                        <x-base.form-check.input
                            id="select-all-checkbox"
                            class="border-slate-400 checked:border-primary"
                            type="checkbox"
                        />
                        <x-base.menu class="ml-1" placement="bottom-start">
                            <x-base.menu.button class="block h-5 w-5" href="#">
                                <x-base.lucide class="h-5 w-5" icon="ChevronDown" />
                            </x-base.menu.button>
                            <x-base.menu.items class="w-32 text-slate-800 dark:text-slate-300">
                                <x-base.menu.item onclick="selectAllMails()">All</x-base.menu.item>
                                <x-base.menu.item onclick="selectNoMails()">None</x-base.menu.item>
                                <x-base.menu.item onclick="selectReadMails()">Read</x-base.menu.item>
                                <x-base.menu.item onclick="selectUnreadMails()">Unread</x-base.menu.item>
                                <x-base.menu.item onclick="selectStarredMails()">Starred</x-base.menu.item>
                                <x-base.menu.item onclick="selectUnstarredMails()">Unstarred</x-base.menu.item>
                            </x-base.menu.items>
                        </x-base.menu>
                        <a class="ml-5 flex h-5 w-5 items-center justify-center" href="#" onclick="refreshMails()">
                            <x-base.lucide class="h-4 w-4" icon="RefreshCw" />
                        </a>
                        <a class="ml-5 flex h-5 w-5 items-center justify-center" href="#">
                            <x-base.lucide class="h-4 w-4" icon="MoreHorizontal" />
                        </a>
                    </div>
                    <div class="flex items-center sm:ml-auto">
                        <div id="mail-count">Loading...</div>
                        <a class="ml-5 flex h-5 w-5 items-center justify-center" href="#" onclick="syncInbox(); return false;" title="Sync Inbox">
                            <x-base.lucide class="h-4 w-4" icon="RefreshCw" />
                        </a>
                        <a class="ml-5 flex h-5 w-5 items-center justify-center" href="#">
                            <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                        </a>
                        <a class="ml-5 flex h-5 w-5 items-center justify-center" href="#">
                            <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                        </a>
                        <a class="ml-5 flex h-5 w-5 items-center justify-center" href="#" onclick="openMailAccountSettingsModal(); return false;">
                            <x-base.lucide class="h-4 w-4" icon="Settings" />
                        </a>
                    </div>
                </div>
                <div id="mails-container" class="overflow-x-auto sm:overflow-x-visible">
                    <!-- Mails will be loaded here via AJAX -->
                    <div class="text-center py-8 text-slate-500">
                        Loading mails...
                    </div>
                </div>
                <div class="flex flex-col items-center p-5 text-center text-slate-500 sm:flex-row sm:text-left">
                    <div>Electronic Mail System - Powered by Laravel</div>
                    <div class="mt-2 sm:ml-auto sm:mt-0">
                        Last activity: {{ now()->format('M d, Y H:i') }}
                    </div>
                </div>
            </div>
            <!-- END: Inbox Content -->
        </div>
    </div>

    <!-- View Mail Modal -->
    <div
        id="view-mail-modal"
        class="fixed inset-0 z-[99997] hidden items-center justify-center bg-slate-900/60"
        aria-hidden="true"
        style="display: none;"
    >
        <div class="modal-dialog modal-xl max-w-4xl w-full mx-4">
            <div class="modal-content bg-white dark:bg-darkmode-600 rounded-lg shadow-lg max-h-[90vh] flex flex-col">
                <div class="modal-header flex items-center justify-between px-5 py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 id="mail-subject" class="font-medium text-base mr-auto truncate">
                        Mail Details
                    </h2>
                    <div class="flex items-center gap-2 mr-4">
                        <x-base.button type="button" variant="outline-secondary" size="sm" onclick="replyToCurrentMail()">
                            <x-base.lucide icon="Reply" class="w-4 h-4 mr-1" />
                            Reply
                        </x-base.button>
                        <x-base.button type="button" variant="outline-secondary" size="sm" onclick="forwardCurrentMail()">
                            <x-base.lucide icon="CornerDownRight" class="w-4 h-4 mr-1" />
                            Forward
                        </x-base.button>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600" onclick="closeViewMailModal()">
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body px-5 py-4 overflow-y-auto">
                    <div id="mail-content" class="text-sm text-slate-800 dark:text-slate-100">
                        <!-- Mail content will be injected here by displayMailContent -->
                    </div>
                </div>
                <div class="px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400 flex justify-end gap-2">
                    <x-base.button type="button" variant="outline-secondary" onclick="closeViewMailModal()">
                        Close
                    </x-base.button>
                </div>
            </div>
        </div>
    </div>

    <!-- Personal Mail Account Settings Modal -->
    <div
        id="mail-account-settings-modal"
        class="fixed inset-0 z-[99999] hidden items-center justify-center bg-slate-900/60"
        aria-hidden="true"
        style="display: none;"
    >
        <div class="modal-dialog modal-lg max-w-4xl w-full mx-4">
            <div class="modal-content bg-white dark:bg-darkmode-600 rounded-lg shadow-lg">
                <div class="modal-header flex items-center justify-between px-5 py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Personal Email Settings</h2>
                    <button type="button" class="text-slate-400 hover:text-slate-600" onclick="closeMailAccountSettingsModal()">
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body px-5 py-4 overflow-y-auto">
                    <form id="mail-account-settings-form">
                        @csrf
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="mail_label">Account Label</x-base.form-label>
                                <x-base.form-input id="mail_label" name="label" type="text" class="w-full" value="{{ $mailAccount->label ?? 'Default Mail Account' }}" />
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="from_name">From Name</x-base.form-label>
                                <x-base.form-input id="from_name" name="from_name" type="text" class="w-full" value="{{ $mailAccount->from_name ?? auth()->user()->name }}" />
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="from_email">From Email</x-base.form-label>
                                <x-base.form-input id="from_email" name="from_email" type="email" class="w-full" value="{{ $mailAccount->from_email ?? auth()->user()->email }}" />
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="smtp_host">SMTP Host</x-base.form-label>
                                <x-base.form-input id="smtp_host" name="smtp_host" type="text" class="w-full" value="{{ $mailAccount->smtp_host ?? '' }}" />
                            </div>

                            <div class="col-span-6 md:col-span-3">
                                <x-base.form-label for="smtp_port">SMTP Port</x-base.form-label>
                                <x-base.form-input id="smtp_port" name="smtp_port" type="number" class="w-full" value="{{ $mailAccount->smtp_port ?? 587 }}" />
                            </div>

                            <div class="col-span-6 md:col-span-3">
                                <x-base.form-label for="smtp_encryption">SMTP Encryption</x-base.form-label>
                                <x-base.form-select id="smtp_encryption" name="smtp_encryption" class="w-full">
                                    <option value="" {{ empty($mailAccount?->smtp_encryption) ? 'selected' : '' }}>None</option>
                                    <option value="ssl" {{ ($mailAccount->smtp_encryption ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="tls" {{ ($mailAccount->smtp_encryption ?? '') === 'tls' ? 'selected' : '' }}>TLS</option>
                                </x-base.form-select>
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="smtp_username">SMTP Username</x-base.form-label>
                                <x-base.form-input id="smtp_username" name="smtp_username" type="text" class="w-full" value="{{ $mailAccount->smtp_username ?? '' }}" />
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="smtp_password">SMTP Password</x-base.form-label>
                                <x-base.form-input id="smtp_password" name="smtp_password" type="password" class="w-full" value="{{ $mailAccount->smtp_password ?? '' }}" />
                            </div>

                            <div class="col-span-12 md:col-span-4">
                                <x-base.form-label for="incoming_protocol">Incoming Protocol</x-base.form-label>
                                <x-base.form-select id="incoming_protocol" name="incoming_protocol" class="w-full">
                                    <option value="imap" {{ ($mailAccount->incoming_protocol ?? 'imap') === 'imap' ? 'selected' : '' }}>IMAP</option>
                                    <option value="pop3" {{ ($mailAccount->incoming_protocol ?? '') === 'pop3' ? 'selected' : '' }}>POP3</option>
                                </x-base.form-select>
                            </div>

                            <div class="col-span-12 md:col-span-4">
                                <x-base.form-label for="incoming_host">Incoming Host</x-base.form-label>
                                <x-base.form-input id="incoming_host" name="incoming_host" type="text" class="w-full" value="{{ $mailAccount->incoming_host ?? '' }}" />
                            </div>

                            <div class="col-span-6 md:col-span-2">
                                <x-base.form-label for="incoming_port">Incoming Port</x-base.form-label>
                                <x-base.form-input id="incoming_port" name="incoming_port" type="number" class="w-full" value="{{ $mailAccount->incoming_port ?? '' }}" />
                            </div>

                            <div class="col-span-6 md:col-span-2">
                                <x-base.form-label for="incoming_encryption">Incoming Encryption</x-base.form-label>
                                <x-base.form-select id="incoming_encryption" name="incoming_encryption" class="w-full">
                                    <option value="" {{ empty($mailAccount?->incoming_encryption) ? 'selected' : '' }}>None</option>
                                    <option value="ssl" {{ ($mailAccount->incoming_encryption ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="tls" {{ ($mailAccount->incoming_encryption ?? '') === 'tls' ? 'selected' : '' }}>TLS</option>
                                </x-base.form-select>
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="incoming_username">Incoming Username</x-base.form-label>
                                <x-base.form-input id="incoming_username" name="incoming_username" type="text" class="w-full" value="{{ $mailAccount->incoming_username ?? '' }}" />
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="incoming_password">Incoming Password</x-base.form-label>
                                <x-base.form-input id="incoming_password" name="incoming_password" type="password" class="w-full" value="{{ $mailAccount->incoming_password ?? '' }}" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-2">
                            <x-base.button type="button" variant="outline-secondary" onclick="closeMailAccountSettingsModal()" class="w-24">
                                Cancel
                            </x-base.button>
                            <x-base.button type="button" variant="outline-secondary" class="w-36" id="test-mail-account-settings-btn">
                                Test Connection
                            </x-base.button>
                            <x-base.button type="button" variant="primary" class="w-32" id="save-mail-account-settings-btn">
                                Save Settings
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Compose Mail Modal -->
    <div
        id="compose-mail-modal"
        class="fixed inset-0 z-[99998] hidden items-center justify-center bg-slate-900/60"
        aria-hidden="true"
        style="display: none;"
    >
        <div class="modal-dialog modal-xl max-w-5xl w-full mx-4">
            <div class="modal-content bg-white dark:bg-darkmode-600 rounded-lg shadow-lg max-h-[90vh] flex flex-col">
                <div class="modal-header flex items-center justify-between px-5 py-2 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Compose New Mail</h2>
                    <button type="button" class="text-slate-400 hover:text-slate-600" onclick="closeComposeModal()">
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6">
                    <form id="compose-mail-form" enctype="multipart/form-data">
                        @csrf

                        <!-- Mail Type & Priority -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="Send" class="h-5 w-5"></x-base.lucide>
                                Mail Options
                            </h4>
                            <div class="grid grid-cols-12 gap-4 gap-y-4">
                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Mail Type <span class="text-danger">*</span></label>
                                <x-base.form-select id="compose-mail-type" name="type" class="w-full" required>
                                    <option value="outgoing">Outgoing (Send)</option>
                                    <option value="incoming">Incoming (Receive)</option>
                                </x-base.form-select>
                            </div>

                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Priority <span class="text-danger">*</span></label>
                                <x-base.form-select id="compose-mail-priority" name="priority" class="w-full" required>
                                    <option value="normal">Normal</option>
                                    <option value="low">Low</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </x-base.form-select>
                            </div>
                        </div>
                        
                        <!-- Recipients -->
                        <div id="compose-recipients-section" class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="Users" class="h-5 w-5"></x-base.lucide>
                                Recipients
                            </h4>

                            <div class="grid grid-cols-12 gap-4 gap-y-4">
                                <div class="col-span-12 md:col-span-3">
                                    <label class="form-label">Recipient Name</label>
                                    <x-base.form-input
                                        id="compose-recipient-name"
                                        name="recipient_name"
                                        type="text"
                                        placeholder="Enter recipient name"
                                        class="w-full"
                                    />
                                </div>

                                <div class="col-span-12 md:col-span-3">
                                    <label class="form-label">Recipient Email</label>
                                    <x-base.form-input
                                        id="compose-recipient-email"
                                        name="recipient_email"
                                        type="email"
                                        placeholder="Enter recipient email"
                                        class="w-full"
                                    />
                                </div>

                                <div class="col-span-12 md:col-span-3">
                                    <label class="form-label">Internal User (Optional)</label>
                                    <x-base.form-select id="compose-recipient-user-id" name="recipient_user_id" class="w-full">
                                        <option value="">Select internal user</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>

                                <div class="col-span-12 md:col-span-3">
                                    <label class="form-label">CC (Optional)</label>
                                    <x-base.form-input
                                        id="compose-cc"
                                        name="cc[]"
                                        type="email"
                                        placeholder="Add CC email"
                                        class="w-full"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Organization -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="Building" class="h-5 w-5"></x-base.lucide>
                                Organization
                            </h4>

                            <div class="grid grid-cols-12 gap-4 gap-y-4">
                                <div class="col-span-12 md:col-span-3">
                                    <label class="form-label">Company</label>
                                    <x-base.form-select id="compose-company-id" name="company_id" class="w-full">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>

                                <div class="col-span-12 md:col-span-6">
                                    <label class="form-label">Department</label>
                                    <x-base.form-select id="compose-department-id" name="department_id" class="w-full">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                            </div>
                        </div>

                        <!-- Attachments -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="Paperclip" class="h-5 w-5"></x-base.lucide>
                                Attachments
                            </h4>

                            <div class="border-2 border-dashed border-slate-300 dark:border-darkmode-400 rounded-lg p-4">
                                <div class="text-center">
                                    <x-base.lucide icon="Upload" class="w-12 h-12 text-slate-400 mx-auto mb-2" />
                                    <p class="text-slate-600 dark:text-slate-400 mb-2">Drop files here or click to browse</p>
                                    <input type="file" id="compose-attachments" name="attachments[]" multiple class="hidden" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.gif,.zip,.rar">
                                    <x-base.button
                                        variant="outline-primary"
                                        type="button"
                                        onclick="document.getElementById('compose-attachments').click()"
                                    >
                                        Choose Files
                                    </x-base.button>
                                </div>
                                <div id="compose-file-list" class="mt-4 space-y-2"></div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <x-base.lucide icon="Activity" class="h-5 w-5"></x-base.lucide>
                                Status
                            </h4>

                            <div class="flex items-center gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="draft" checked class="mr-2">
                                    <span class="text-slate-600 dark:text-slate-400">Save as Draft</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="sent" class="mr-2">
                                    <span class="text-slate-600 dark:text-slate-400">Send Now</span>
                                </label>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-2 pt-4 border-t">
                            <x-base.button
                                variant="outline-secondary"
                                type="button"
                                onclick="closeComposeModal()"
                            >
                                Cancel
                            </x-base.button>
                            <x-base.button
                                variant="primary"
                                type="submit"
                                id="compose-send-mail-btn"
                            >
                                <x-base.lucide icon="Send" class="w-4 h-4 mr-2" />
                                Send Mail
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @push('scripts')
    <script>
        let currentPage = 1;
        let totalRecords = 0;
        let currentFolder = '{{ $currentFolder }}';
        const MAIL_CSRF_TOKEN = '{{ csrf_token() }}';

        // Script is loaded at the bottom of the page, so DOM is already ready
        loadMails();
        setupEventListeners();
        setupComposeModal();

        function setupEventListeners() {
            const searchBtn = document.getElementById('mail-search-btn');
            const searchInput = document.getElementById('mail-search');

            if (searchBtn) {
                searchBtn.addEventListener('click', function() {
                    currentPage = 1;
                    loadMails();
                });
            }

            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        currentPage = 1;
                        loadMails();
                    }
                });
            }

            const mailAccountForm = document.getElementById('mail-account-settings-form');
            const testBtn = document.getElementById('test-mail-account-settings-btn');
            const saveBtn = document.getElementById('save-mail-account-settings-btn');

            if (mailAccountForm && saveBtn) {
                saveBtn.addEventListener('click', function() {
                    const submitBtn = saveBtn;
                    const originalText = submitBtn.textContent;

                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Saving...';

                    const formData = new FormData(mailAccountForm);

                    fetch('{{ route('user-mail-accounts.save') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': MAIL_CSRF_TOKEN,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message || 'Mail account settings saved successfully.', 'success');

                            const modal = document.getElementById('mail-account-settings-modal');
                            if (modal) {
                                modal.classList.add('hidden');
                                modal.style.display = 'none';
                            }
                        } else {
                            if (data.errors) {
                                const firstError = Object.values(data.errors)[0][0] || 'Validation error';
                                showToast(firstError, 'error');
                            } else {
                                showToast(data.message || 'Failed to save mail account settings.', 'error');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error saving mail account settings:', error);
                        showToast('An error occurred while saving mail account settings.', 'error');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    });
                });
            }

            if (mailAccountForm && testBtn) {
                testBtn.addEventListener('click', function() {
                    const formData = new FormData(mailAccountForm);

                    const testOriginalText = testBtn.textContent;
                    testBtn.disabled = true;
                    testBtn.textContent = 'Testing...';

                    fetch('{{ route('user-mail-accounts.test') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': MAIL_CSRF_TOKEN,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message || 'SMTP connection successful.', 'success');
                        } else {
                            if (data.errors) {
                                const firstError = Object.values(data.errors)[0][0] || 'Validation error';
                                showToast(firstError, 'error');
                            } else {
                                showToast(data.message || 'SMTP connection failed.', 'error');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error testing mail account settings:', error);
                        showToast('An error occurred while testing SMTP connection.', 'error');
                    })
                    .finally(() => {
                        testBtn.disabled = false;
                        testBtn.textContent = testOriginalText;
                    });
                });
            }
        }

        function setupComposeModal() {
            const mailType = document.getElementById('compose-mail-type');
            const recipientsSection = document.getElementById('compose-recipients-section');
            const senderSection = document.getElementById('compose-sender-section');
            const fileInput = document.getElementById('compose-attachments');
            const fileList = document.getElementById('compose-file-list');
            const form = document.getElementById('compose-mail-form');
            const submitBtn = document.getElementById('compose-send-mail-btn');
            const companySelect = document.getElementById('compose-company-id');
            const departmentSelect = document.getElementById('compose-department-id');

            if (mailType && recipientsSection && senderSection) {
                mailType.addEventListener('change', function() {
                    if (this.value === 'incoming') {
                        recipientsSection.style.display = 'none';
                        senderSection.style.display = 'block';
                    } else {
                        recipientsSection.style.display = 'block';
                        senderSection.style.display = 'none';
                    }
                });
            }

            if (fileInput && fileList) {
                fileInput.addEventListener('change', function(e) {
                    fileList.innerHTML = '';
                    Array.from(e.target.files).forEach((file, index) => {
                        const fileItem = document.createElement('div');
                        fileItem.className = 'flex items-center justify-between bg-slate-50 dark:bg-darkmode-600 p-2 rounded';
                        fileItem.innerHTML = `
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-sm">${file.name}</span>
                                <span class="text-xs text-slate-500">(${formatFileSizeCompose(file.size)})</span>
                            </div>
                            <button type="button" onclick="removeComposeFile(${index})" class="text-red-500 hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        `;
                        fileList.appendChild(fileItem);
                    });
                });
            }

            if (companySelect && departmentSelect) {
                companySelect.addEventListener('change', function() {
                    departmentSelect.selectedIndex = 0;
                });
            }

            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const originalText = submitBtn.innerHTML;

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Sending...';

                    fetch('{{ route("electronic-mail.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': MAIL_CSRF_TOKEN,
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message || 'Mail sent successfully.', 'success');
                            closeComposeModal();
                            loadMails();
                        } else {
                            if (data.errors) {
                                const firstError = Object.values(data.errors)[0][0] || 'Validation error';
                                showToast(firstError, 'error');
                            } else {
                                showToast(data.message || 'Failed to send mail', 'error');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred while sending the mail', 'error');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    });
                });
            }
        }

        // Global handler for folder changes (used by inline onclick on sidebar links)
        window.changeMailFolder = function(event, folder) {
            if (event) {
                event.preventDefault();
            }

            if (!folder || folder === currentFolder) {
                return false;
            }

            currentFolder = folder;
            currentPage = 1;

       
            // Update active state visually
            $('.js-mail-folder-link').removeClass('bg-white/10 dark:bg-darkmode-700');
            $(`.js-mail-folder-link[data-folder="${folder}"]`).addClass('bg-white/10 dark:bg-darkmode-700');

            // Update URL query string without reloading the page
            const url = new URL(window.location.href);
            url.searchParams.set('folder', currentFolder);
            window.history.replaceState({}, '', url.toString());

            // Reload mails for the selected folder
            loadMails();

            // Prevent navigation
            return false;
        };

        // Open Compose Modal
        window.openComposeModal = function() {
            const modal = document.getElementById('compose-mail-modal');
            if (!modal) {
                console.error('Compose mail modal not found');
                return;
            }

            // Reset form when opening
            const form = document.getElementById('compose-mail-form');
            const fileList = document.getElementById('compose-file-list');
            const attachments = document.getElementById('compose-attachments');

            if (form) {
                form.reset();
            }
            if (fileList) {
                fileList.innerHTML = '';
            }
            if (attachments) {
                attachments.value = '';
            }

            const recipientsSection = document.getElementById('compose-recipients-section');
            const senderSection = document.getElementById('compose-sender-section');
            if (recipientsSection && senderSection) {
                recipientsSection.style.display = 'block';
                senderSection.style.display = 'none';
            }

            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        };

        // Close Compose Modal
        window.closeComposeModal = function() {
            const modal = document.getElementById('compose-mail-modal');
            if (!modal) {
                return;
            }

            modal.classList.add('hidden');
            modal.style.display = 'none';
        };

        // Open Personal Mail Account Settings Modal
        window.openMailAccountSettingsModal = function() {
            const modal = document.getElementById('mail-account-settings-modal');
            if (!modal) {
                console.error('Mail account settings modal not found');
                return;
            }

            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        };

        // Close Personal Mail Account Settings Modal
        window.closeMailAccountSettingsModal = function() {
            const modal = document.getElementById('mail-account-settings-modal');
            if (!modal) {
                return;
            }

            modal.classList.add('hidden');
            modal.style.display = 'none';
        };

        let currentViewedMail = null;

        function loadMails() {
            const searchInput = document.getElementById('mail-search');
            const search = searchInput ? searchInput.value : '';
            const folder = currentFolder;

            const mailsContainer = document.getElementById('mails-container');
            if (mailsContainer) {
                mailsContainer.innerHTML = '<div class="text-center py-8 text-slate-500">Loading mails...</div>';
            }

            const params = new URLSearchParams({
                folder: folder || '',
                search: search || '',
                page: currentPage || 1,
            });

            fetch('{{ route("electronic-mail.datatable") }}' + '?' + params.toString(), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                renderMails(data.data || []);
                updateMailCount(data.recordsTotal || 0, data.recordsFiltered || 0);
            })
            .catch(error => {
                console.error('Error loading mails:', error);
                if (mailsContainer) {
                    mailsContainer.innerHTML = '<div class="text-center py-8 text-slate-500">Error loading mails</div>';
                }
            });
        }

        function renderMails(mails) {
            const container = document.getElementById('mails-container');
            if (!container) return;

            container.innerHTML = '';

            if (mails.length === 0) {
                container.innerHTML = '<div class="text-center py-8 text-slate-500">No mails found</div>';
                return;
            }

            mails.forEach(function(mail) {
                const isRead = mail.is_read;
                const rowClass = isRead ? 'bg-white text-slate-800 dark:text-slate-300 dark:bg-darkmode-600' : 'bg-slate-100 text-slate-600 dark:text-slate-500 dark:bg-darkmode-400/70';
                const fontClass = isRead ? '' : 'font-medium';

                const row = `
                    <div class="intro-y">
                        <div class="transition duration-200 ease-in-out transform cursor-pointer inline-block sm:block border-b border-slate-200/60 dark:border-darkmode-400 hover:scale-[1.02] hover:relative hover:z-20 hover:shadow-md hover:border-0 hover:rounded ${rowClass}">
                            <div class="flex px-5 py-3">
                                <div class="mr-5 flex w-72 flex-none items-center">
                                    <input type="checkbox" class="mail-checkbox border-slate-400 checked:border-primary flex-none" data-id="${mail.id}">
                                    <button onclick="toggleStar(${mail.id})" class="ml-4 flex h-5 w-5 flex-none items-center justify-center ${mail.is_starred ? 'text-yellow-500' : 'text-slate-400'} hover:text-yellow-600">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </button>
                                    <div class="image-fit relative ml-5 h-6 w-6 flex-none">
                                        <img class="rounded-full" src="https://via.placeholder.com/24x24/cccccc/666666?text=U" alt="User" />
                                    </div>
                                    <div class="ml-3 truncate ${fontClass}">
                                        ${mail.sender_info || 'Unknown Sender'}
                                    </div>
                                </div>
                                <div class="w-64 truncate sm:w-auto cursor-pointer" onclick="viewMail(${mail.id})">
                                    <span class="ml-3 truncate ${fontClass}">${mail.subject}</span>
                                    <span class="text-slate-500 text-sm ml-2">${mail.content ? mail.content.substring(0, 50) + '...' : ''}</span>
                                </div>
                                <div class="pl-10 ml-auto whitespace-nowrap ${fontClass}">
                                    ${mail.date}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', row);
            });
        }

        function updateMailCount(total, filtered) {
            const start = ((currentPage - 1) * 25) + 1;
            const end = Math.min(currentPage * 25, filtered);
            const mailCount = document.getElementById('mail-count');
            if (mailCount) {
                mailCount.textContent = `${start} - ${end} of ${total}`;
            }
            totalRecords = total;
        }

        // Global functions
        window.viewMail = function(id) {
            const url = '{{ route("electronic-mail.show", ":id") }}'.replace(':id', id);

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // المودال الأصلي لعرض الرسالة تم حذفه، لذلك نكتفي بعرض المحتوى في الكونسول لاحقاً إذا احتجنا
                    displayMailContent(data.mail);
                }
            })
            .catch(error => {
                console.error('Error loading mail:', error);
                showToast('Failed to load mail details.', 'error');
            });
        };

        window.toggleStar = function(id) {
            const url = '{{ route("electronic-mail.toggle-star", ":id") }}'.replace(':id', id);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': MAIL_CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadMails();
                    showToast('Mail star status updated', 'success');
                }
            })
            .catch(error => {
                console.error('Error toggling star:', error);
                showToast('Failed to update star status.', 'error');
            });
        };

        window.refreshMails = function() {
            loadMails();
            showToast('Mails refreshed', 'success');
        };

        window.syncInbox = function() {
            const url = '{{ route("electronic-mail.sync") }}';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': MAIL_CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message || 'Inbox synced successfully.', 'success');
                    loadMails();
                } else {
                    showToast(data.message || 'Failed to sync inbox.', 'error');
                }
            })
            .catch(error => {
                console.error('Error syncing inbox:', error);
                showToast('An error occurred while syncing inbox.', 'error');
            });
        };

        // Bulk selection functions
        window.selectAllMails = function() {
            document.querySelectorAll('.mail-checkbox').forEach(function(cb) {
                cb.checked = true;
            });
        };

        window.selectNoMails = function() {
            document.querySelectorAll('.mail-checkbox').forEach(function(cb) {
                cb.checked = false;
            });
        };

        window.selectReadMails = function() {
            document.querySelectorAll('.mail-checkbox').forEach(function(cb) {
                cb.checked = true;
            });
        };

        window.selectUnreadMails = function() {
            document.querySelectorAll('.mail-checkbox').forEach(function(cb) {
                cb.checked = false;
            });
        };

        window.selectStarredMails = function() {
            document.querySelectorAll('.mail-checkbox').forEach(function(cb) {
                cb.checked = false;
            });
        };

        window.selectUnstarredMails = function() {
            document.querySelectorAll('.mail-checkbox').forEach(function(cb) {
                cb.checked = true;
            });
        };

        function displayMailContent(mail) {
            currentViewedMail = mail;
            const subjectEl = document.getElementById('mail-subject');
            const contentEl = document.getElementById('mail-content');

            if (subjectEl) {
                subjectEl.textContent = mail.subject;
            }

            let content = `
                <div class="border-b pb-4 mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <strong>From:</strong>
                            <span>${mail.sender_name || 'Unknown'} ${mail.sender_email ? `(${mail.sender_email})` : ''}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-500">${mail.formatted_date}</span>
                            <button onclick="toggleStar(${mail.id})" class="${mail.is_starred ? 'text-yellow-500' : 'text-slate-400'} hover:text-yellow-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mb-2">
                        <strong>To:</strong>
                        <span>${mail.recipient_name || 'Unknown'} ${mail.recipient_email ? `(${mail.recipient_email})` : ''}</span>
                    </div>
                    ${mail.cc ? `<div class="mb-2"><strong>CC:</strong> <span>${Array.isArray(mail.cc) ? mail.cc.join(', ') : mail.cc}</span></div>` : ''}
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-full ${mail.priority_badge_class}">${mail.priority}</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full ${mail.status_badge_class}">${mail.status}</span>
                    </div>
                </div>
                <div class="prose max-w-none">
                    ${mail.content || 'No content available'}
                </div>
            `;

            if (contentEl) {
                contentEl.innerHTML = content;
            }

            openViewMailModal();
        }

        window.openViewMailModal = function() {
            const modal = document.getElementById('view-mail-modal');
            if (!modal) return;

            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        };

        window.closeViewMailModal = function() {
            const modal = document.getElementById('view-mail-modal');
            if (!modal) return;

            modal.classList.add('hidden');
            modal.style.display = 'none';
        };

        window.replyToCurrentMail = function() {
            if (!currentViewedMail) return;

            const mail = currentViewedMail;

            // Open compose modal
            openComposeModal();

            const typeSelect = document.getElementById('compose-mail-type');
            const subjectInput = document.getElementById('compose-mail-subject');
            const contentTextarea = document.getElementById('compose-mail-content');
            const recipientNameInput = document.getElementById('compose-recipient-name');
            const recipientEmailInput = document.getElementById('compose-recipient-email');

            if (typeSelect) typeSelect.value = 'outgoing';

            if (mail.type === 'incoming') {
                if (recipientNameInput) recipientNameInput.value = mail.sender_name || '';
                if (recipientEmailInput) recipientEmailInput.value = mail.sender_email || '';
            } else {
                if (recipientNameInput) recipientNameInput.value = mail.recipient_name || '';
                if (recipientEmailInput) recipientEmailInput.value = mail.recipient_email || '';
            }

            if (subjectInput) {
                const prefix = mail.subject && mail.subject.trim().toLowerCase().startsWith('re:') ? '' : 'Re: ';
                subjectInput.value = prefix + (mail.subject || '');
            }

            if (contentTextarea) {
                const original = mail.content || '';
                contentTextarea.value = '\n\n---- Original message ----\n' + original;
            }

            closeViewMailModal();
        };

        window.forwardCurrentMail = function() {
            if (!currentViewedMail) return;

            const mail = currentViewedMail;

            openComposeModal();

            const typeSelect = document.getElementById('compose-mail-type');
            const subjectInput = document.getElementById('compose-mail-subject');
            const contentTextarea = document.getElementById('compose-mail-content');
            const recipientNameInput = document.getElementById('compose-recipient-name');
            const recipientEmailInput = document.getElementById('compose-recipient-email');

            if (typeSelect) typeSelect.value = 'outgoing';

            if (recipientNameInput) recipientNameInput.value = '';
            if (recipientEmailInput) recipientEmailInput.value = '';

            if (subjectInput) {
                const prefix = mail.subject && mail.subject.trim().toLowerCase().startsWith('fwd:') ? '' : 'Fwd: ';
                subjectInput.value = prefix + (mail.subject || '');
            }

            if (contentTextarea) {
                const original = mail.content || '';
                contentTextarea.value = '\n\n---- Forwarded message ----\n' + original;
            }

            closeViewMailModal();
        };

        function removeComposeFile(index) {
            const fileInput = document.getElementById('compose-attachments');
            const dt = new DataTransfer();
            const files = Array.from(fileInput.files);

            files.splice(index, 1);

            files.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;

            fileInput.dispatchEvent(new Event('change'));
        }

        function formatFileSizeCompose(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

    </script>
@endpush
