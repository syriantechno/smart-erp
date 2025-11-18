<x-base.form-check.input
    {{ $attributes->class(
            merge([
                // Default
                'w-[38px] h-[24px] p-px rounded-full relative appearance-none border border-slate-300 bg-slate-200 focus:outline-none focus:ring-4 focus:ring-primary/20 dark:bg-darkmode-700 dark:border-darkmode-500',
                'before:w-[20px] before:h-[20px] before:bg-white before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600',
    
                // On checked
                'checked:bg-primary checked:border-primary',
                'before:checked:ml-[14px] before:checked:bg-white',
    
                $attributes->whereStartsWith('class')->first(),
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
>
    {{ $slot }}
</x-base.form-check.input>
