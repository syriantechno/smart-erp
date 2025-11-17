@php
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
@endphp

<nav aria-label="breadcrumb" class="flex">
    <ol class="flex items-center text-white">
        <li class="flex items-center">
            <a href="{{ url('/') }}" class="hover:text-primary">
                {{ setting('general.application_name', config('app.name', 'Application')) }}
            </a>
        </li>
        
        @foreach($breadcrumbs as $index => $crumb)
            @if($index < count($breadcrumbs) - 1 && $crumb['url'])
                <li class="relative ml-5 pl-0.5">
                    <span class="before:content-[''] before:w-[14px] before:h-[14px] before:bg-chevron-white before:transform before:rotate-[-90deg] before:bg-[length:100%] before:-ml-[1.125rem] before:absolute before:my-auto before:inset-y-0"></span>
                    <a href="{{ $crumb['url'] }}" class="hover:text-primary">
                        {{ $crumb['label'] }}
                    </a>
                </li>
            @else
                <li class="relative ml-5 pl-0.5 text-white">
                    <span class="before:content-[''] before:w-[14px] before:h-[14px] before:bg-chevron-white before:transform before:rotate-[-90deg] before:bg-[length:100%] before:-ml-[1.125rem] before:absolute before:my-auto before:inset-y-0"></span>
                    {{ $crumb['label'] }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>
