@props(['as' => 'div'])
@aware(['size' => 'md'])

<{{ $as }}
    data-tw-merge
    {{ $attributes->class([
            'absolute top-0 right-0 h-full flex flex-col bg-white shadow-md transition-transform duration-300 translate-x-full group-[.show]:translate-x-0 dark:bg-darkmode-600 z-[100]',
            $size == 'md' ? 'w-[460px] max-w-[90vw]' : null,
            $size == 'sm' ? 'w-[300px] max-w-[90vw]' : null,
            $size == 'lg' ? 'w-[600px] max-w-[90vw]' : null,
            $size == 'xl' ? 'w-[900px] max-w-[90vw]' : null,
        ])->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
>{{ $slot }}</{{ $as }}>
