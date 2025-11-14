@props([
    'id',
    'title',
    'size' => 'lg',
])

<x-base.dialog :id="$id" :size="$size">
    <x-base.dialog.panel>
        <x-base.dialog.title class="flex items-center gap-4 pr-2">
            <h2 class="font-medium text-lg text-gray-900 dark:text-white flex-1">{{ $title }}</h2>
            <button
                type="button"
                class="text-slate-500 hover:text-slate-400 p-1 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors ml-auto"
                data-tw-dismiss="modal"
            >
                <x-base.lucide icon="X" class="w-5 h-5" />
            </button>
        </x-base.dialog.title>

        <x-base.dialog.description class="p-5">
            {{ $slot->toHtml() }}
        </x-base.dialog.description>

        @isset($footer)
            <x-base.dialog.footer class="border-t border-gray-200 dark:border-dark-5 pt-4 mt-4">
                {{ $footer->toHtml() }}
            </x-base.dialog.footer>
        @endisset
    </x-base.dialog.panel>
</x-base.dialog>
