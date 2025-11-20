@props([
    'id',
    'title',
    'size' => 'lg',
])

@pushOnce('styles')
    <style>
        .modal-themed-header {
            --modal-header-color: var(--color-primary, var(--primary-color, #2563eb));
            --modal-header-rgb: var(--color-primary-rgb, var(--primary-rgb, 37 99 235));
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            background: linear-gradient(135deg,
                    rgb(var(--modal-header-rgb) / 0.68),
                    rgb(var(--modal-header-rgb) / 0.38));
            padding: 1rem 1.5rem;
            border-top-left-radius: 0.30rem;
            border-top-right-radius: 0.30rem;
            color: #f8fafc;
            box-shadow: 0 15px 35px rgba(var(--modal-header-rgb), 0.25);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        @supports (background: color-mix(in srgb, red 50%, transparent)) {
            .modal-themed-header {
                background: linear-gradient(135deg,
                        color-mix(in srgb, var(--modal-header-color) 75%, transparent),
                        color-mix(in srgb, var(--modal-header-color) 45%, transparent));
                box-shadow: 0 15px 35px color-mix(in srgb, var(--modal-header-color) 35%, transparent);
            }
        }

        .modal-themed-header__title {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: none;
            color: #f8fafc;
        }

        .modal-themed-header__subtitle {
            font-size: 0.7rem;
            font-weight: 600;
            opacity: 0.85;
        }

        .modal-themed-header__close {
            margin-left: auto;
            border: 1px solid rgba(248, 250, 252, 0.35);
            background-color: rgba(255, 255, 255, 0.08);
            color: #fff;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 150ms ease, background-color 150ms ease;
        }

        .modal-themed-header__close:hover {
            background-color: rgba(255, 255, 255, 0.18);
            transform: translateY(-1px);
        }
    </style>
@endPushOnce

<x-base.dialog :id="$id" :size="$size">
    <x-base.dialog.panel>
        <x-base.dialog.title class="modal-themed-header">
            <div class="flex flex-col gap-1">
                <h2 class="modal-themed-header__title">{{ $title }}</h2>
            </div>
            <button
                type="button"
                class="modal-themed-header__close"
                data-tw-dismiss="modal"
                title="Close"
            >
                <x-base.lucide icon="x" class="w-5 h-5" />
            </button>
        </x-base.dialog.title>

        <x-base.dialog.description class="p-5 max-h-[80vh] overflow-y-auto">
            {!! $slot->toHtml() !!}
        </x-base.dialog.description>

        @isset($footer)
            <x-base.dialog.footer class="border-t border-gray-200 dark:border-dark-5 pt-4 mt-4">
                {!! $footer->toHtml() !!}
            </x-base.dialog.footer>
        @endisset
    </x-base.dialog.panel>
</x-base.dialog>
