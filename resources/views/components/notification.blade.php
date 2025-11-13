@props(['type' => 'info', 'title' => '', 'message' => '', 'dismissible' => true])

@php
    $typeClasses = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800'
    ];

    $iconClasses = [
        'success' => 'text-green-500',
        'error' => 'text-red-500',
        'warning' => 'text-yellow-500',
        'info' => 'text-blue-500'
    ];

    $icons = [
        'success' => 'CheckCircle',
        'error' => 'XCircle',
        'warning' => 'AlertTriangle',
        'info' => 'Info'
    ];
@endphp

<div class="alert alert-{{ $type }} {{ $typeClasses[$type] ?? $typeClasses['info'] }} border-l-4 p-4 rounded-r-lg mb-4 {{ $dismissible ? 'relative' : '' }}"
     x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform -translate-y-2">

    <div class="flex items-start">
        <div class="flex-shrink-0">
            <x-base.lucide :icon="$icons[$type] ?? 'Info'" class="w-5 h-5 {{ $iconClasses[$type] ?? $iconClasses['info'] }}" />
        </div>

        <div class="ml-3 flex-1">
            @if($title)
                <h3 class="text-sm font-medium {{ $type === 'error' ? 'text-red-800' : ($type === 'success' ? 'text-green-800' : ($type === 'warning' ? 'text-yellow-800' : 'text-blue-800')) }}">
                    {{ $title }}
                </h3>
            @endif

            <div class="mt-1 text-sm {{ $type === 'error' ? 'text-red-700' : ($type === 'success' ? 'text-green-700' : ($type === 'warning' ? 'text-yellow-700' : 'text-blue-700')) }}">
                {{ $message }}
            </div>
        </div>

        @if($dismissible)
            <div class="ml-auto pl-3">
                <button type="button"
                        @click="show = false"
                        class="inline-flex rounded-md p-1.5 {{ $type === 'error' ? 'text-red-500 hover:bg-red-100' : ($type === 'success' ? 'text-green-500 hover:bg-green-100' : ($type === 'warning' ? 'text-yellow-500 hover:bg-yellow-100' : 'text-blue-500 hover:bg-blue-100')) }} focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $type === 'error' ? 'focus:ring-red-500' : ($type === 'success' ? 'focus:ring-green-500' : ($type === 'warning' ? 'focus:ring-yellow-500' : 'focus:ring-blue-500')) }}">
                    <span class="sr-only">تجاهل</span>
                    <x-base.lucide icon="X" class="w-4 h-4" />
                </button>
            </div>
        @endif
    </div>
</div>
