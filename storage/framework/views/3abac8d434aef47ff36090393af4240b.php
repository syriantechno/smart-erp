<?php $__env->startSection('head'); ?>
    <?php echo $__env->yieldContent('subhead'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'smart-erp enigma pt-0 pb-5 px-5 sm:px-8 md:px-0 bg-slate-100 dark:bg-darkmode-800',
    ]); ?>">
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

        
        <div class="relative z-0 top-bar-pattern">
            <div
                id="smart-header"
                class="px-4 sm:px-6 md:px-8 pt-0 pb-32 md:pt-0 md:pb-48 md:ml-[100px] xl:ml-[260px]"
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
        </div>

        <div class="flex mt-0">
            <!-- BEGIN: Side Menu -->
            <nav id="smart-sidebar" class="side-nav z-[80] mt-0 hidden w-[100px] xl:w-[260px] overflow-y-auto overflow-x-hidden px-5 pb-16 pt-12 md:fixed md:top-2 md:left-2 md:h-screen md:block bg-white/95 rounded-[8px] shadow-lg dark:bg-darkmode-700/80">
                
                <div class="mb-6 flex items-center justify-center">
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Layers','class' => 'h-9 w-9 text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Layers','class' => 'h-9 w-9 text-primary']); ?>
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
                        <div class="text-sm font-semibold text-slate-800 dark:text-slate-100 text-center">
                            Smart ERP
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
                                    <div class="side-menu__title">
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
                                                    <div class="side-menu__title">
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
                                                                    <div class="side-menu__title">
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
            <div id="smart-main-content" class="flex-1 w-full flex justify-center md:justify-start -mt-24 md:-mt-28 pr-6 pl-6 md:ml-[100px] xl:ml-[260px] relative z-[70]">
                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'w-full rounded-[8px] px-4 md:px-8 min-h-[calc(100vh-9rem)] bg-white/95 shadow-sm md:pt-8 pb-10 mt-6 md:mt-4 relative z-10 dark:bg-darkmode-700/95',
                    "before:content-[''] before:w-full before:h-px before:block",
                ]); ?>">
                    <?php echo $__env->yieldContent('subcontent'); ?>
                </div>
            </div>
            <!-- END: Content -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php if (! $__env->hasRenderedOnce('66458f0e-bb67-4bee-9b11-56d218c23b95')): $__env->markAsRenderedOnce('66458f0e-bb67-4bee-9b11-56d218c23b95');
$__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/vendors/tippy.css'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/themes/enigma/side-nav.css'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/themes/enigma/top-nav.css'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('9805fa72-3c33-4674-9676-e4b824665690')): $__env->markAsRenderedOnce('9805fa72-3c33-4674-9676-e4b824665690');
$__env->startPush('vendors'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/vendors/tippy.js'); ?>
<?php $__env->stopPush(); endif; ?>

<?php if (! $__env->hasRenderedOnce('69264bf4-fc18-4b80-a1d9-c2192c5d70af')): $__env->markAsRenderedOnce('69264bf4-fc18-4b80-a1d9-c2192c5d70af');
$__env->startPush('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/themes/enigma.js'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar = document.getElementById('smart-sidebar');
            var toggleBtn = document.getElementById('smart-sidebar-toggle');
            var mainContent = document.getElementById('smart-main-content');
            var header = document.getElementById('smart-header');

            if (!sidebar || !toggleBtn || !mainContent || !header) return;

            // Restore saved sidebar state from localStorage
            var savedState = localStorage.getItem('sidebar-collapsed');
            if (savedState === 'true') {
                // Apply collapsed state on page load
                sidebar.classList.add('side-nav--simple');
                sidebar.classList.remove('w-[100px]', 'xl:w-[260px]');
                sidebar.classList.add('w-[72px]', 'xl:w-[88px]');
                
                mainContent.classList.remove('md:ml-[100px]', 'xl:ml-[260px]');
                mainContent.classList.add('md:ml-[72px]', 'xl:ml-[88px]');
                
                header.classList.remove('md:ml-[100px]', 'xl:ml-[260px]');
                header.classList.add('md:ml-[72px]', 'xl:ml-[88px]');
            }

            toggleBtn.addEventListener('click', function () {
                var isSimple = sidebar.classList.toggle('side-nav--simple');
                
                // Save state to localStorage
                localStorage.setItem('sidebar-collapsed', isSimple);

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

<?php echo $__env->make('../themes/base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\ERP System\Source\resources\views////themes/smart-erp/side-menu.blade.php ENDPATH**/ ?>