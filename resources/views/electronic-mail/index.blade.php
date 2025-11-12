@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Electronic Mail - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-3 2xl:col-span-2">
            <h2 class="intro-y mr-auto mt-2 text-lg font-medium">Electronic Mail</h2>
            <!-- BEGIN: Inbox Menu -->
            <div class="intro-y box mt-6 bg-primary p-5">
                <x-base.button
                    class="mt-1 w-full bg-white text-slate-600 dark:border-darkmode-300 dark:bg-darkmode-300 dark:text-slate-300"
                    type="button"
                    onclick="window.location.href='{{ route('electronic-mail.compose') }}'"
                >
                    <x-base.lucide
                        class="mr-2 h-4 w-4"
                        icon="Edit"
                    /> Compose
                </x-base.button>
                <div class="mt-6 border-t border-white/10 pt-6 text-white dark:border-darkmode-400">
                    <a
                        href="{{ route('electronic-mail.index', ['folder' => 'inbox']) }}"
                        class="flex items-center rounded-md px-3 py-2 font-medium {{ $currentFolder === 'inbox' ? 'bg-white/10 dark:bg-darkmode-700' : '' }}"
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
                        href="{{ route('electronic-mail.index', ['folder' => 'starred']) }}"
                        class="mt-2 flex items-center rounded-md px-3 py-2 {{ $currentFolder === 'starred' ? 'bg-white/10 dark:bg-darkmode-700' : '' }}"
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
                        href="{{ route('electronic-mail.index', ['folder' => 'sent']) }}"
                        class="mt-2 flex items-center rounded-md px-3 py-2 {{ $currentFolder === 'sent' ? 'bg-white/10 dark:bg-darkmode-700' : '' }}"
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
                        href="{{ route('electronic-mail.index', ['folder' => 'draft']) }}"
                        class="mt-2 flex items-center rounded-md px-3 py-2 {{ $currentFolder === 'draft' ? 'bg-white/10 dark:bg-darkmode-700' : '' }}"
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
                    <x-base.button class="mr-2 shadow-md" variant="primary" onclick="window.location.href='{{ route('electronic-mail.compose') }}'">
                        Compose
                    </x-base.button>
                    <x-base.menu>
                        <x-base.menu.button class="box px-2" as="x-base.button">
                            <span class="flex h-5 w-5 items-center justify-center">
                                <x-base.lucide class="h-4 w-4" icon="Plus" />
                            </span>
                        </x-base.menu.button>
                        <x-base.menu.items class="w-40">
                            <x-base.menu.item onclick="window.location.href='{{ route('electronic-mail.compose') }}'">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" />
                                New Message
                            </x-base.menu.item>
                            <x-base.menu.item>
                                <x-base.lucide class="mr-2 h-4 w-4" icon="Settings" />
                                Settings
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
                        <a class="ml-5 flex h-5 w-5 items-center justify-center" href="#">
                            <x-base.lucide class="h-4 w-4" icon="ChevronLeft" />
                        </a>
                        <a class="ml-5 flex h-5 w-5 items-center justify-center" href="#">
                            <x-base.lucide class="h-4 w-4" icon="ChevronRight" />
                        </a>
                        <a class="ml-5 flex h-5 w-5 items-center justify-center" href="#">
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
    <div id="view-mail-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto" id="mail-subject"></h2>
                    <button type="button" class="text-slate-400 hover:text-slate-600" data-tw-dismiss="modal">
                        <x-base.lucide icon="X" class="w-6 h-6" />
                    </button>
                </div>
                <div class="modal-body p-6">
                    <div id="mail-content">
                        <!-- Mail content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentPage = 1;
        let totalRecords = 0;

        $(document).ready(function() {
            loadMails();
            setupEventListeners();
        });

        function setupEventListeners() {
            $('#mail-search-btn').on('click', function() {
                currentPage = 1;
                loadMails();
            });

            $('#mail-search').on('keypress', function(e) {
                if (e.which === 13) {
                    currentPage = 1;
                    loadMails();
                }
            });
        }

        function loadMails() {
            const search = $('#mail-search').val();
            const folder = '{{ $currentFolder }}';

            $('#mails-container').html('<div class="text-center py-8 text-slate-500">Loading mails...</div>');

            $.ajax({
                url: '{{ route("electronic-mail.datatable") }}',
                type: 'GET',
                data: {
                    folder: folder,
                    search: search,
                    page: currentPage
                },
                success: function(response) {
                    renderMails(response.data || []);
                    updateMailCount(response.recordsTotal || 0, response.recordsFiltered || 0);
                },
                error: function(xhr) {
                    console.error('Error loading mails:', xhr);
                    $('#mails-container').html('<div class="text-center py-8 text-slate-500">Error loading mails</div>');
                }
            });
        }

        function renderMails(mails) {
            const container = $('#mails-container');
            container.empty();

            if (mails.length === 0) {
                container.html('<div class="text-center py-8 text-slate-500">No mails found</div>');
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
                container.append(row);
            });
        }

        function updateMailCount(total, filtered) {
            const start = ((currentPage - 1) * 25) + 1;
            const end = Math.min(currentPage * 25, filtered);
            $('#mail-count').text(`${start} - ${end} of ${total}`);
            totalRecords = total;
        }

        // Global functions
        window.viewMail = function(id) {
            $.get('{{ route("electronic-mail.show", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (response.success) {
                        displayMailContent(response.mail);
                        $('#view-mail-modal').modal('show');
                    }
                });
        };

        window.toggleStar = function(id) {
            $.post('{{ route("electronic-mail.toggle-star", ":id") }}'.replace(':id', id))
                .done(function(response) {
                    if (response.success) {
                        loadMails();
                        showToast('Mail star status updated', 'success');
                    }
                });
        };

        window.refreshMails = function() {
            loadMails();
            showToast('Mails refreshed', 'success');
        };

        // Bulk selection functions
        window.selectAllMails = function() {
            $('.mail-checkbox').prop('checked', true);
        };

        window.selectNoMails = function() {
            $('.mail-checkbox').prop('checked', false);
        };

        window.selectReadMails = function() {
            $('.mail-checkbox').each(function() {
                $(this).prop('checked', true);
            });
        };

        window.selectUnreadMails = function() {
            $('.mail-checkbox').each(function() {
                $(this).prop('checked', false);
            });
        };

        window.selectStarredMails = function() {
            $('.mail-checkbox').each(function() {
                $(this).prop('checked', false);
            });
        };

        window.selectUnstarredMails = function() {
            $('.mail-checkbox').each(function() {
                $(this).prop('checked', true);
            });
        };

        function displayMailContent(mail) {
            $('#mail-subject').text(mail.subject);

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

            $('#mail-content').html(content);
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
    </script>
@endpush
