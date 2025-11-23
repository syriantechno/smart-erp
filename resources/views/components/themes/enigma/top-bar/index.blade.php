@props(['layout' => 'side-menu'])

@php
    if (!isset($fakers) || empty($fakers)) {
        $fakers = [
            [
                'photos' => ['resources/images/profile-1.jpg'],
                'users' => [['name' => 'Alex Cooper', 'email' => 'alex.cooper@example.com']],
                'images' => ['resources/images/preview-1.jpg'],
                'products' => [['name' => 'Wireless Earbuds', 'category' => 'Audio Devices']],
            ],
            [
                'photos' => ['resources/images/profile-2.jpg'],
                'users' => [['name' => 'Sara Haddad', 'email' => 'sara.haddad@example.com']],
                'images' => ['resources/images/preview-2.jpg'],
                'products' => [['name' => 'Smart Desk Lamp', 'category' => 'Home Office']],
            ],
            [
                'photos' => ['resources/images/profile-3.jpg'],
                'users' => [['name' => 'Mohammed Al-Sayed', 'email' => 'malsayed@example.com']],
                'images' => ['resources/images/preview-5.jpg'],
                'products' => [['name' => 'Cloud Backup Suite', 'category' => 'Software']],
            ],
            [
                'photos' => ['resources/images/profile-4.jpg'],
                'users' => [['name' => 'Aisha Rahman', 'email' => 'aisha.rahman@example.com']],
                'images' => ['resources/images/preview-6.jpg'],
                'products' => [['name' => 'Projector HD Mini', 'category' => 'Electronics']],
            ],
        ];
    }

    $searchPages = [
        ['label' => 'Mail Settings', 'icon' => 'Inbox', 'icon_bg' => 'bg-success/20 text-success'],
        ['label' => 'Users & Permissions', 'icon' => 'Users', 'icon_bg' => 'bg-pending/10 text-pending'],
        ['label' => 'Transactions Report', 'icon' => 'CreditCard', 'icon_bg' => 'bg-primary/10 text-primary/80 dark:bg-primary/20'],
    ];

    $searchDepartments = [
        ['name' => 'Sales', 'location' => 'Isle of Man'],
        ['name' => 'Product Management', 'location' => 'Svalbard'],
        ['name' => 'Quality Assurance', 'location' => 'Lesotho'],
    ];

    $searchProducts = [
        ['name' => 'Ultra HD 4K Smart TV', 'category' => 'Electronics'],
        ['name' => 'Wireless Gaming Mouse', 'category' => 'Accessories'],
        ['name' => 'Smartphone Charging Dock', 'category' => 'Home & Garden'],
    ];
@endphp

<!-- BEGIN: Top Bar -->
<div @class([
    'h-[90px] md:h-[100px] z-[10] border-b border-white/[0.08] w-full px-5 sm:px-8 md:px-10 md:border-b-0 relative md:pt-6',
])>
    <div class="flex items-center">

        {{-- Sidebar collapse toggle (for side-menu layout) --}}
        @if ($layout === 'side-menu')
            <button
                id="smart-sidebar-toggle"
                type="button"
                class="mr-3 flex h-8 w-8 items-center justify-center rounded-full border border-slate-300 bg-white/80 text-slate-700 hover:text-slate-900 hover:bg-white shadow-sm"
                title="Toggle sidebar"
            >
                <x-base.lucide
                    icon="PanelLeft"
                    class="h-4 w-4"
                />
            </button>
        @endif

        <!-- BEGIN: Breadcrumb -->
        <div 
            @class([
                'h-[45px] md:border-l border-slate-300/80 dark:border-white/[0.08] mr-auto -intro-x flex items-center text-slate-900',
                'md:pl-6' => $layout != 'top-menu',
                'md:pl-10' => $layout == 'top-menu',
            ])
        >
            <x-dynamic-breadcrumbs />
        </div>
        <!-- END: Breadcrumb -->
        <!-- BEGIN: Search -->
        <div class="intro-x relative flex-1 flex justify-center mr-3 sm:mr-6">
            <div class="search relative hidden sm:block w-full max-w-sm">
                <button
                    type="button"
                    data-search-trigger
                    class="bg-white/80 dark:bg-darkmode-900/30 border-transparent dark:border-transparent border w-full flex items-center py-2 px-3.5 rounded-[0.75rem] text-slate-900 cursor-pointer hover:bg-white transition-colors duration-300 hover:duration-100 shadow-[0_10px_24px_rgba(15,15,20,0.10)] backdrop-blur-xl"
                >
                    <x-base.lucide icon="Search" class="stroke-[1] w-[18px] h-[18px]" />
                    <span class="ml-2.5 mr-auto">Quick search...</span>
                    <span class="text-xs tracking-wide">⌘K</span>
                </button>
            </div>
            <a
                class="relative text-white/70 sm:hidden"
                href=""
                data-search-trigger
            >
                <x-base.lucide
                    class="h-5 w-5 dark:text-slate-500"
                    icon="Search"
                />
            </a>
        </div>
        <!-- END: Search -->
        <div class="intro-x flex items-center gap-2 sm:gap-3">
            {{-- Settings pill (first visually) --}}
            <a
                href="{{ route('settings.index') }}"
                title="Settings"
                class="inline-flex items-center gap-2 h-11 px-5 rounded-full border border-white/60 bg-white text-slate-900 font-medium shadow-[0_14px_30px_rgba(15,15,20,0.12)] transition hover:-translate-y-0.5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-200"
            >
                <x-base.lucide icon="Settings" class="h-5 w-5" />
                <span>Setting</span>
            </a>

            {{-- Quick apps button --}}
            <button
                type="button"
                title="Quick apps"
                class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/60 bg-white text-slate-800 shadow-[0_14px_30px_rgba(15,15,20,0.12)] transition hover:-translate-y-0.5 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-200"
                data-quick-apps-toggle
            >
                <x-base.lucide icon="Grid" class="h-5 w-5" />
                <span class="sr-only">Quick apps</span>
            </button>

            {{-- Notifications bell --}}
            <x-notifications.dropdown :unread-count="App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count()" />

            {{-- User menu button --}}
            <x-base.menu>
                <x-base.menu.button
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/60 bg-white text-slate-800 shadow-[0_14px_30px_rgba(15,15,20,0.12)] transition hover:-translate-y-0.5 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-200"
                >
                    <x-base.lucide icon="User" class="h-5 w-5" />
                </x-base.menu.button>
                <x-base.menu.items
                    class="relative mt-px w-56 bg-theme-1/80 text-white before:absolute before:inset-0 before:z-[-1] before:block before:rounded-md before:bg-black"
                >
                    <x-base.menu.header class="font-normal">
                        <div class="font-medium">{{ auth()->user()->name }}</div>
                        <div class="mt-0.5 text-xs text-white/70 dark:text-slate-500">
                            {{ auth()->user()->email }}
                        </div>
                    </x-base.menu.header>
                    <x-base.menu.divider class="bg-white/[0.08]" />
                    <x-base.menu.item class="hover:bg-white/5">
                        <a href="{{ route('settings.index') }}" class="flex items-center">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="Settings"
                            /> Settings
                        </a>
                    </x-base.menu.item>
                    <x-base.menu.item class="hover:bg-white/5">
                        <a href="{{ route('settings.index') }}" class="flex items-center">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="User"
                            /> Profile
                        </a>
                    </x-base.menu.item>
                    <x-base.menu.item class="hover:bg-white/5">
                        <a href="{{ route('settings.index') }}" class="flex items-center">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="Lock"
                            /> Change Password
                        </a>
                    </x-base.menu.item>
                    <x-base.menu.divider class="bg-white/[0.08]" />
                    <x-base.menu.item class="hover:bg-white/5">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center">
                            <x-base.lucide
                                class="mr-2 h-4 w-4"
                                icon="ToggleRight"
                            /> Logout
                        </a>
                    </x-base.menu.item>
                </x-base.menu.items>
            </x-base.menu>

            <!-- Hidden Forms -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <form id="profile-form" action="{{ route('settings.index') }}" method="GET" style="display: none;"></form>
            <form id="password-form" action="{{ route('settings.index') }}" method="GET" style="display: none;"></form>
        </div>
        <!-- END: Top-right actions -->
    </div>
</div>
<!-- END: Top Bar -->


@pushOnce('scripts')
    @vite('resources/js/components/themes/enigma/top-bar.js')
@endPushOnce
