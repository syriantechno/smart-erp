@props([
    'icon' => 'Edit',
    'title' => null,
    'variant' => 'primary', // primary, success, warning, danger, neutral
    'size' => 'sm',
    'type' => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:scale-105 transition focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-transparent dark:text-slate-400';
    $sizeClasses = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-base',
    ][$size] ?? 'text-sm';

    $variants = [
        'primary' => 'hover:text-blue-600 dark:hover:text-blue-400',
        'success' => 'hover:text-emerald-600 dark:hover:text-emerald-400',
        'warning' => 'hover:text-amber-600 dark:hover:text-amber-400',
        'danger' => 'hover:text-red-600 dark:hover:text-red-400',
        'neutral' => 'hover:text-slate-700 dark:hover:text-slate-200',
    ];

    $variantClasses = $variants[$variant] ?? $variants['neutral'];
@endphp

<button
    type="{{ $type }}"
    title="{{ $title ?? '' }}"
    {{ $attributes->merge(['class' => trim("{$baseClasses} {$sizeClasses} {$variantClasses}")]) }}
>
    <x-base.lucide :icon="$icon" class="h-4 w-4" />
</button>
