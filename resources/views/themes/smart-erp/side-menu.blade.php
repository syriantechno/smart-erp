@extends('../themes/base')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    <div @class([
        'smart-erp enigma pt-0 pb-5 px-5 sm:px-8 md:px-0 bg-slate-100 dark:bg-darkmode-800',
    ])>
        <x-mobile-menu />

        {{-- Blue patterned header that *is* the top bar --}}
        <div class="relative z-0 top-bar-pattern">
            <div
                id="smart-header"
                class="px-4 sm:px-6 md:px-8 pt-0 pb-32 md:pt-0 md:pb-48 md:ml-[100px] xl:ml-[260px]"
            >
                <x-themes.enigma.top-bar layout="side-menu" />
            </div>
        </div>

        <div class="flex mt-0">
            <!-- BEGIN: Side Menu -->
            <nav id="smart-sidebar" class="side-nav z-[80] mt-0 hidden w-[100px] xl:w-[260px] overflow-y-auto overflow-x-hidden px-5 pb-16 pt-12 md:fixed md:top-2 md:left-2 md:h-screen md:block bg-white/95 rounded-[26px] shadow-lg dark:bg-darkmode-700/80">
                {{-- Brand / logo --}}
                <div class="mb-6 flex items-center justify-center">
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
                            <x-base.lucide
                                icon="Layers"
                                class="h-9 w-9 text-primary"
                            />
                        </div>
                        <div class="text-sm font-semibold text-slate-800 dark:text-slate-100 text-center">
                            Smart ERP
                        </div>
                    </div>
                </div>
                <ul>
                    @foreach ($mainMenu as $menuKey => $menu)
                        @if ($menu == 'divider')
                            <li class="side-nav__divider my-6"></li>
                        @else
                            <li>
                                <a
                                    href="{{ isset($menu['route_name']) ? route($menu['route_name'], isset($menu['params']) ? $menu['params'] : []) : 'javascript:;' }}"
                                    @class([
                                        $firstLevelActiveIndex == $menuKey
                                            ? 'side-menu side-menu--active'
                                            : 'side-menu',
                                    ])
                                >
                                    <div class="side-menu__icon">
                                        <x-base.lucide icon="{{ $menu['icon'] }}" />
                                    </div>
                                    <div class="side-menu__title">
                                        {{ $menu['title'] }}
                                        @if (isset($menu['sub_menu']))
                                            <div
                                                class="side-menu__sub-icon {{ $firstLevelActiveIndex == $menuKey ? 'transform rotate-180' : '' }}">
                                                <x-base.lucide icon="ChevronDown" />
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                @if (isset($menu['sub_menu']))
                                    <ul class="{{ $firstLevelActiveIndex == $menuKey ? 'side-menu__sub-open' : '' }}">
                                        @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                                            <li>
                                                <a
                                                    href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], isset($subMenu['params']) ? $subMenu['params'] : []) : 'javascript:;' }}"
                                                    @class([
                                                        $secondLevelActiveIndex == $subMenuKey
                                                            ? 'side-menu side-menu--active'
                                                            : 'side-menu',
                                                    ])
                                                >
                                                    <div class="side-menu__icon">
                                                        <x-base.lucide icon="{{ $subMenu['icon'] }}" />
                                                    </div>
                                                    <div class="side-menu__title">
                                                        {{ $subMenu['title'] }}
                                                        @if (isset($subMenu['sub_menu']))
                                                            <div
                                                                class="side-menu__sub-icon {{ $secondLevelActiveIndex == $subMenuKey ? 'transform rotate-180' : '' }}">
                                                                <x-base.lucide icon="ChevronDown" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </a>
                                                @if (isset($subMenu['sub_menu']))
                                                    <ul
                                                        class="{{ $secondLevelActiveIndex == $subMenuKey ? 'side-menu__sub-open' : '' }}">
                                                        @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                            <li>
                                                                <a
                                                                    href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], isset($lastSubMenu['params']) ? $lastSubMenu['params'] : []) : 'javascript:;' }}"
                                                                    @class([
                                                                        $thirdLevelActiveIndex == $lastSubMenuKey
                                                                            ? 'side-menu side-menu--active'
                                                                            : 'side-menu',
                                                                    ])
                                                                >
                                                                    <div class="side-menu__icon">
                                                                        <x-base.lucide icon="{{ $lastSubMenu['icon'] }}" />
                                                                    </div>
                                                                    <div class="side-menu__title">
                                                                        {{ $lastSubMenu['title'] }}
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div id="smart-main-content" class="flex-1 w-full flex justify-center md:justify-start -mt-20 md:-mt-24 pr-6 pl-6 md:ml-[100px] xl:ml-[260px] relative z-[70]">
                <div @class([
                    'w-full rounded-[26px] px-4 md:px-8 min-h-[calc(100vh-9rem)] bg-white/95 shadow-sm md:pt-8 pb-10 mt-6 md:mt-4 relative z-10 dark:bg-darkmode-700/95',
                    "before:content-[''] before:w-full before:h-px before:block",
                ])>
                    @yield('subcontent')
                </div>
            </div>
            <!-- END: Content -->
        </div>
    </div>
@endsection

@pushOnce('styles')
    @vite('resources/css/vendors/tippy.css')
    @vite('resources/css/themes/enigma/side-nav.css')
    @vite('resources/css/themes/enigma/top-nav.css')
@endPushOnce

@pushOnce('vendors')
    @vite('resources/js/vendors/tippy.js')
@endPushOnce

@pushOnce('scripts')
    @vite('resources/js/themes/enigma.js')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar = document.getElementById('smart-sidebar');
            var toggleBtn = document.getElementById('smart-sidebar-toggle');
            var mainContent = document.getElementById('smart-main-content');
            var header = document.getElementById('smart-header');

            if (!sidebar || !toggleBtn || !mainContent || !header) return;

            toggleBtn.addEventListener('click', function () {
                var isSimple = sidebar.classList.toggle('side-nav--simple');

                if (isSimple) {
                    // Sidebar becomes narrower
                    sidebar.classList.remove('w-[100px]', 'xl:w-[260px]');
                    sidebar.classList.add('w-[72px]', 'xl:w-[88px]');

                    // Content shifts closer
                    mainContent.classList.remove('md:ml-[100px]', 'xl:ml-[260px]');
                    mainContent.classList.add('md:ml-[72px]', 'xl:ml-[88px]');

                    // Header (breadcrumb) shifts with content so sidebar doesn't cover it
                    header.classList.remove('md:ml-[100px]', 'xl:ml-[260px]');
                    header.classList.add('md:ml-[72px]', 'xl:ml-[88px]');
                } else {
                    // Sidebar returns to full width
                    sidebar.classList.remove('w-[72px]', 'xl:w-[88px]');
                    sidebar.classList.add('w-[100px]', 'xl:w-[260px]');

                    // Content margin matches full sidebar
                    mainContent.classList.remove('md:ml-[72px]', 'xl:ml-[88px]');
                    mainContent.classList.add('md:ml-[100px]', 'xl:ml-[260px]');

                    // Header returns to full offset
                    header.classList.remove('md:ml-[72px]', 'xl:ml-[88px]');
                    header.classList.add('md:ml-[100px]', 'xl:ml-[260px]');
                }

                // Re-run tooltip logic (enigma.js listens to resize to enable/disable)
                window.dispatchEvent(new Event('resize'));
            });
        });
    </script>
@endPushOnce
