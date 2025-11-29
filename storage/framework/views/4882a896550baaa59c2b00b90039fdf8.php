<?php $__env->startSection('head'); ?>
    <?php echo $__env->yieldContent('subhead'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div
        id="smart-shell"
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            // reduce pl so gap when sidebar is open is smaller (closer to collapsed gap)
            'smart-erp enigma pt-0 pb-5 px-5 sm:px-8 md:px-0 bg-transparent md:pl-[108px] xl:pl-[268px] h-screen overflow-y-auto',
        ]); ?>"
    >
        <?php if (isset($component)) { $__componentOriginal382ffb4e125af6203213609160accaa9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal382ffb4e125af6203213609160accaa9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.mobile-menu.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mobile-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal382ffb4e125af6203213609160accaa9)): ?>
<?php $attributes = $__attributesOriginal382ffb4e125af6203213609160accaa9; ?>
<?php unset($__attributesOriginal382ffb4e125af6203213609160accaa9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal382ffb4e125af6203213609160accaa9)): ?>
<?php $component = $__componentOriginal382ffb4e125af6203213609160accaa9; ?>
<?php unset($__componentOriginal382ffb4e125af6203213609160accaa9); ?>
<?php endif; ?>

        <div
            id="smart-header"
            class="px-4 sm:px-6 md:px-8 pt-0 pb-32 md:pt-0 md:pb-48"
        >
            <?php if (isset($component)) { $__componentOriginalbd52424ca8e15890728f7295a6d830b0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd52424ca8e15890728f7295a6d830b0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.themes.enigma.top-bar.index','data' => ['layout' => 'side-menu']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('themes.enigma.top-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['layout' => 'side-menu']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd52424ca8e15890728f7295a6d830b0)): ?>
<?php $attributes = $__attributesOriginalbd52424ca8e15890728f7295a6d830b0; ?>
<?php unset($__attributesOriginalbd52424ca8e15890728f7295a6d830b0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd52424ca8e15890728f7295a6d830b0)): ?>
<?php $component = $__componentOriginalbd52424ca8e15890728f7295a6d830b0; ?>
<?php unset($__componentOriginalbd52424ca8e15890728f7295a6d830b0); ?>
<?php endif; ?>
        </div>

        <div class="flex mt-0">
            <!-- BEGIN: Side Menu -->
            <nav id="smart-sidebar" class="side-nav z-[80] mt-0 hidden w-[100px] xl:w-[260px] overflow-x-auto overflow-y-auto px-5 pb-16 pt-12 md:fixed md:top-2 md:left-2 md:h-screen md:block bg-transparent rounded-[8px] shadow-lg dark:bg-transparent">
                
                <?php
                    $brandName = $appBrandName ?? $appCompany->name ?? config('app.name', 'ERP System');
                    $brandLogoUrl = $appBrandLogoUrl ?? $appCompanyLogoUrl ?? null;
                ?>
                <div class="mb-6 flex items-center justify-center">
                    <div class="flex flex-col items-center gap-2 text-center">
                        <?php if($brandLogoUrl): ?>
                            <div class="relative h-16 w-16 overflow-hidden rounded-2xl border border-slate-200 shadow-sm dark:border-darkmode-400">
                                <img
                                    src="<?php echo e($brandLogoUrl); ?>"
                                    alt="<?php echo e($brandName); ?> logo"
                                    class="h-full w-full object-cover"
                                >
                            </div>
                        <?php else: ?>
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-primary/10">
                                <span class="text-lg font-bold text-primary">
                                    <?php echo e(\Illuminate\Support\Str::of($brandName)->substr(0, 2)->upper()); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                        <div class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                            <?php echo e($brandName); ?>

                        </div>
                    </div>
                </div>
                <ul>
                    <?php $__currentLoopData = $mainMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuKey => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($menu == 'divider'): ?>
                            <li class="side-nav__divider my-6"></li>
                        <?php else: ?>
                            <li>
                                <a
                                    href="<?php echo e(isset($menu['route_name']) ? route($menu['route_name'], isset($menu['params']) ? $menu['params'] : []) : 'javascript:;'); ?>"
                                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        $firstLevelActiveIndex == $menuKey
                                            ? 'side-menu side-menu--active'
                                            : 'side-menu',
                                    ]); ?>"
                                >
                                    <div class="side-menu__icon">
                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => ''.e($menu['icon']).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => ''.e($menu['icon']).'']); ?>
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
                                    <div class="side-menu__title" title="<?php echo e($menu['title']); ?>">
                                        <?php echo e($menu['title']); ?>

                                        <?php if(isset($menu['sub_menu'])): ?>
                                            <div
                                                class="side-menu__sub-icon <?php echo e($firstLevelActiveIndex == $menuKey ? 'transform rotate-180' : ''); ?>">
                                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'ChevronDown']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'ChevronDown']); ?>
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
                                        <?php endif; ?>
                                    </div>
                                </a>
                                <?php if(isset($menu['sub_menu'])): ?>
                                    <ul class="<?php echo e($firstLevelActiveIndex == $menuKey ? 'side-menu__sub-open' : ''); ?>">
                                        <?php $__currentLoopData = $menu['sub_menu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenuKey => $subMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <a
                                                    href="<?php echo e(isset($subMenu['route_name']) ? route($subMenu['route_name'], isset($subMenu['params']) ? $subMenu['params'] : []) : 'javascript:;'); ?>"
                                                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                        $secondLevelActiveIndex == $subMenuKey
                                                            ? 'side-menu side-menu--active'
                                                            : 'side-menu',
                                                    ]); ?>"
                                                >
                                                    <div class="side-menu__icon">
                                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => ''.e($subMenu['icon']).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => ''.e($subMenu['icon']).'']); ?>
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
                                                    <div class="side-menu__title" title="<?php echo e($subMenu['title']); ?>">
                                                        <?php echo e($subMenu['title']); ?>

                                                        <?php if(isset($subMenu['sub_menu'])): ?>
                                                            <div
                                                                class="side-menu__sub-icon <?php echo e($secondLevelActiveIndex == $subMenuKey ? 'transform rotate-180' : ''); ?>">
                                                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'ChevronDown']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'ChevronDown']); ?>
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
                                                        <?php endif; ?>
                                                    </div>
                                                </a>
                                                <?php if(isset($subMenu['sub_menu'])): ?>
                                                    <ul
                                                        class="<?php echo e($secondLevelActiveIndex == $subMenuKey ? 'side-menu__sub-open' : ''); ?>">
                                                        <?php $__currentLoopData = $subMenu['sub_menu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lastSubMenuKey => $lastSubMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li>
                                                                <a
                                                                    href="<?php echo e(isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], isset($lastSubMenu['params']) ? $lastSubMenu['params'] : []) : 'javascript:;'); ?>"
                                                                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                                        $thirdLevelActiveIndex == $lastSubMenuKey
                                                                            ? 'side-menu side-menu--active'
                                                                            : 'side-menu',
                                                                    ]); ?>"
                                                                >
                                                                    <div class="side-menu__icon">
                                                                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => ''.e($lastSubMenu['icon']).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => ''.e($lastSubMenu['icon']).'']); ?>
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
                                                                    <div class="side-menu__title" title="<?php echo e($lastSubMenu['title']); ?>">
                                                                        <?php echo e($lastSubMenu['title']); ?>

                                                                    </div>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </nav>
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div id="smart-main-content" class="flex-1 w-full flex justify-center md:justify-start -mt-48 md:-mt-48 pr-2 pl-1 relative z-[70]">
                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'w-full rounded-[8px] px-2 md:px-2 min-h-[calc(100vh-9rem)] bg-transparent pb-10 mt-6 md:mt-4 relative z-10',
                    "before:content-[''] before:w-full before:h-px before:block",
                ]); ?>">
                    <?php echo $__env->yieldContent('subcontent'); ?>
                </div>
            </div>
            <!-- END: Content -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php if (! $__env->hasRenderedOnce('c0ed82f8-3e15-40b3-8bce-21a336a40557')): $__env->markAsRenderedOnce('c0ed82f8-3e15-40b3-8bce-21a336a40557');
$__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/vendors/tippy.css'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/themes/enigma/side-nav.css'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/themes/enigma/top-nav.css'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('a2ca35a0-1845-47b4-a1a1-aa272521de25')): $__env->markAsRenderedOnce('a2ca35a0-1845-47b4-a1a1-aa272521de25');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/tippy.js'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('3072569b-cca1-411a-bf03-b11514bfa583')): $__env->markAsRenderedOnce('3072569b-cca1-411a-bf03-b11514bfa583');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/themes/enigma.js'); ?>

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
<?php $__env->stopPush(); endif; ?>

<?php echo $__env->make('../themes/base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views////themes/smart-erp/side-menu.blade.php ENDPATH**/ ?>