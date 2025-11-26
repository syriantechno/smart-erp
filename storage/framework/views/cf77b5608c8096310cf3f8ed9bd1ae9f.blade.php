<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['dataTwToggle','ariaExpanded','class'])
<x-base.button :data-tw-toggle="$dataTwToggle" :aria-expanded="$ariaExpanded" :class="$class" >

{{ $slot ?? "" }}
</x-base.button>