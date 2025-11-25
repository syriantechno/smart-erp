<?php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route;

    $segments = array_values(array_filter(request()->segments()));
    $breadcrumbs = [];
    $currentPath = '';

    // Map of segment names to display names
    $displayNames = [
        'hr' => 'HR',
        'manufacturing' => 'Manufacturing',
        'warehouse' => 'Warehouse',
        'project-management' => 'Project Management',
        'documents' => 'Documents',
        'settings' => 'Settings',
        'notifications' => 'Notifications',
        'orders' => 'Orders',
        'create' => 'Create',
        'edit' => 'Edit',
        'show' => 'Details',
        'index' => 'Overview',
        'datatable' => 'Table',
    ];

    foreach ($segments as $segment) {
        $currentPath .= '/' . $segment;
        $label = $displayNames[$segment] ?? Str::headline(str_replace('-', ' ', $segment));

        $breadcrumbs[] = [
            'label' => $label,
            'url' => url($currentPath),
        ];
    }

    // Fallback to route name when path segments are empty (e.g. SPA-loaded content)
    if (empty($breadcrumbs) && Route::current()) {
        $routeParts = array_filter(explode('.', Route::currentRouteName() ?? ''));
        $currentRoute = '';

        foreach ($routeParts as $part) {
            $currentRoute = $currentRoute ? $currentRoute . '.' . $part : $part;
            $label = $displayNames[$part] ?? Str::headline($part);
            $url = null;

            if (Route::has($currentRoute)) {
                try {
                    $url = route($currentRoute, request()->route()->parameters());
                } catch (Throwable $e) {
                    $url = null;
                }
            }

            $breadcrumbs[] = [
                'label' => $label,
                'url' => $url,
            ];
        }
    }
?>

<nav aria-label="breadcrumb" class="flex">
    <ol class="flex items-center text-slate-900">
        <li class="flex items-center">
            <a href="<?php echo e(url('/')); ?>" class="hover:text-primary">
                <?php echo e(setting('app_name', config('app.name', 'Smart ERP'))); ?>

            </a>
        </li>
        
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($index < count($breadcrumbs) - 1 && $crumb['url']): ?>
                <li class="relative ml-5 pl-0.5">
                    <span class="before:content-[''] before:w-[14px] before:h-[14px] before:bg-chevron-black before:transform before:rotate-[-90deg] before:bg-[length:100%] before:-ml-[1.125rem] before:absolute before:my-auto before:inset-y-0"></span>
                    <a href="<?php echo e($crumb['url']); ?>" class="hover:text-primary">
                        <?php echo e($crumb['label']); ?>

                    </a>
                </li>
            <?php else: ?>
                <li class="relative ml-5 pl-0.5 text-slate-900 font-medium">
                    <span class="before:content-[''] before:w-[14px] before:h-[14px] before:bg-chevron-black before:transform before:rotate-[-90deg] before:bg-[length:100%] before:-ml-[1.125rem] before:absolute before:my-auto before:inset-y-0"></span>
                    <?php echo e($crumb['label']); ?>

                </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav>
<?php /**PATH E:\ERP System\Source\resources\views/components/dynamic-breadcrumbs.blade.php ENDPATH**/ ?>