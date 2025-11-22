@props([
    'pending' => 0,
    'inProgress' => 0,
    'approved' => 0,
    'rejected' => 0,
    'completed' => 0,
])

<div class="w-full h-full">
    <x-base.chart
        class="material-requests-line-chart"
        data-pending="{{ $pending }}"
        data-in-progress="{{ $inProgress }}"
        data-approved="{{ $approved }}"
        data-rejected="{{ $rejected }}"
        data-completed="{{ $completed }}"
    >
    </x-base.chart>
</div>

@pushOnce('scripts')
    @vite('resources/js/components/material-requests-line-chart.js')
@endPushOnce
