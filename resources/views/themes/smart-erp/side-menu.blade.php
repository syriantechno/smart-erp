@extends('../themes/base')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    <div
        id="smart-shell"
        @class([
            // reduce pl so gap when sidebar is open is smaller (closer to collapsed gap)
            'smart-erp enigma pt-0 pb-5 px-5 sm:px-8 md:px-0 bg-transparent md:pl-[108px] xl:pl-[268px] h-screen overflow-y-auto',
        ])
    >
        <x-mobile-menu />

        <div
            id="smart-header"
            class="px-4 sm:px-6 md:px-8 pt-0 pb-32 md:pt-0 md:pb-48"
        >
            <x-themes.enigma.top-bar layout="side-menu" />
        </div>

        <div class="flex mt-0">
            <!-- BEGIN: Side Menu -->
            <nav id="smart-sidebar" class="side-nav z-[80] mt-0 hidden w-[100px] xl:w-[260px] overflow-x-hidden px-5 pb-16 pt-12 md:fixed md:top-2 md:left-2 md:h-screen md:block bg-transparent rounded-[8px] shadow-lg dark:bg-transparent">
                {{-- Brand / logo --}}
                @php
                    $brandName = $appBrandName ?? $appCompany->name ?? config('app.name', 'ERP System');
                    $brandLogoUrl = $appBrandLogoUrl ?? $appCompanyLogoUrl ?? null;
                @endphp
                <div class="mb-6 flex items-center justify-center">
                    <div class="flex flex-col items-center gap-2 text-center">
                        @if ($brandLogoUrl)
                            <div class="relative h-16 w-16 overflow-hidden rounded-2xl border border-slate-200 shadow-sm dark:border-darkmode-400">
                                <img
                                    src="{{ $brandLogoUrl }}"
                                    alt="{{ $brandName }} logo"
                                    class="h-full w-full object-cover"
                                >
                            </div>
                        @else
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-primary/10">
                                <span class="text-lg font-bold text-primary">
                                    {{ \Illuminate\Support\Str::of($brandName)->substr(0, 2)->upper() }}
                                </span>
                            </div>
                        @endif
                        <div class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                            {{ $brandName }}
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
            <div id="smart-main-content" class="flex-1 w-full flex justify-center md:justify-start -mt-48 md:-mt-48 pr-2 pl-1 relative z-[70]">
                <div @class([
                    'w-full rounded-[8px] px-2 md:px-2 min-h-[calc(100vh-9rem)] bg-transparent pb-10 mt-6 md:mt-4 relative z-10',
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
            var shell = document.getElementById('smart-shell');

            if (!sidebar || !toggleBtn || !shell) return;

            // Restore saved sidebar state from localStorage
            var savedState = localStorage.getItem('sidebar-collapsed');
            if (savedState === 'true') {
                // Apply collapsed state on page load
                sidebar.classList.add('side-nav--simple');
                sidebar.classList.remove('w-[100px]', 'xl:w-[260px]');
                sidebar.classList.add('w-[72px]', 'xl:w-[88px]');

                // Reduce shell left padding so main content expands
                shell.classList.remove('md:pl-[108px]', 'xl:pl-[268px]');
                shell.classList.add('md:pl-[72px]', 'xl:pl-[88px]');
            }

            toggleBtn.addEventListener('click', function () {
                var isSimple = sidebar.classList.toggle('side-nav--simple');
                
                // Save state to localStorage
                localStorage.setItem('sidebar-collapsed', isSimple);

                if (isSimple) {
                    // Sidebar becomes narrower and shell padding shrinks: content visually expands
                    sidebar.classList.remove('w-[100px]', 'xl:w-[260px]');
                    sidebar.classList.add('w-[72px]', 'xl:w-[88px]');

                    shell.classList.remove('md:pl-[108px]', 'xl:pl-[268px]');
                    shell.classList.add('md:pl-[72px]', 'xl:pl-[88px]');
                } else {
                    // Sidebar returns to full width and shell padding matches it
                    sidebar.classList.remove('w-[72px]', 'xl:w-[88px]');
                    sidebar.classList.add('w-[100px]', 'xl:w-[260px]');

                    shell.classList.remove('md:pl-[72px]', 'xl:pl-[88px]');
                    shell.classList.add('md:pl-[108px]', 'xl:pl-[268px]');
                }

                // Re-run tooltip logic (enigma.js listens to resize to enable/disable)
                window.dispatchEvent(new Event('resize'));
            });
        });
    </script>

    <script>
        // Simple SPA-like navigation for sidebar links (no full page reload)
        document.addEventListener('DOMContentLoaded', function () {
            var mainContent = document.getElementById('smart-main-content');
            var sidebar = document.getElementById('smart-sidebar');

            if (!mainContent || !sidebar) return;

            // Only use SPA-like navigation for dashboard routes
            function isDashboardUrl(url) {
                try {
                    var u = typeof url === 'string' ? new URL(url, window.location.origin) : url;
                    var path = u.pathname || '';
                    return (
                        path === '/' ||
                        path.indexOf('/dashboard-overview-1') === 0 ||
                        path.indexOf('/dashboard-overview-2') === 0 ||
                        path.indexOf('/dashboard-overview-3') === 0 ||
                        path.indexOf('/dashboard-overview-4') === 0
                    );
                } catch (e) {
                    return false;
                }
            }

            function loadPage(url, pushState = true) {
                if (!url) return;

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html,application/xhtml+xml,application/xml',
                    },
                    credentials: 'same-origin',
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(function (html) {
                        var parser = new DOMParser();
                        var doc = parser.parseFromString(html, 'text/html');
                        var newMain = doc.getElementById('smart-main-content');

                        // If structure is not as expected, fallback to full navigation
                        if (!newMain) {
                            window.location.href = url;
                            return;
                        }

                        // Replace only the inner content wrapper (card) to preserve margins
                        var currentInner = mainContent.firstElementChild;
                        var newInner = newMain.firstElementChild;

                        if (currentInner && newInner) {
                            currentInner.innerHTML = newInner.innerHTML;
                        } else {
                            // Fallback: replace entire mainContent
                            mainContent.innerHTML = newMain.innerHTML;
                        }

                        // Update document title
                        if (doc.title) {
                            document.title = doc.title;
                        }

                        // Push history state
                        if (pushState) {
                            window.history.pushState({ url: url }, '', url);
                        }

                        // Re-run any layout-specific JS that depends on resize
                        window.dispatchEvent(new Event('resize'));
                    })
                    .catch(function () {
                        // On error, fallback to normal navigation
                        window.location.href = url;
                    });
            }

            // Intercept clicks on sidebar links
            sidebar.addEventListener('click', function (event) {
                var link = event.target.closest('a[href]');
                if (!link) return;

                var href = link.getAttribute('href');

                // Ignore javascript: links or anchors or explicit opt-out
                if (!href || href === '#' || href.startsWith('javascript:') || link.hasAttribute('data-no-spa')) {
                    return;
                }

                // Only handle same-origin links
                var url = new URL(href, window.location.origin);
                if (url.origin !== window.location.origin) {
                    return;
                }

                // Restrict SPA-like navigation to dashboard routes only
                if (!isDashboardUrl(url)) {
                    return;
                }

                event.preventDefault();
                loadPage(url.toString(), true);
            });

            // Handle browser back/forward
            window.addEventListener('popstate', function (event) {
                if (event.state && event.state.url) {
                    loadPage(event.state.url, false);
                }
            });
        });
    </script>
@endPushOnce
