@props([
    'id' => null,
    'name' => null,
    'multiple' => false,
    'accept' => null,
    'disabled' => false,
    'required' => false,
    'class' => '',
])

@php
    $id = $id ?? $name;
    $inputClass = 'form-control ' . ($errors->has($name) ? 'border-danger' : '');
@endphp

<div class="form-inline items-start flex-col sm:flex-row mt-3">
    @if($label = $attributes->get('label'))
        <x-base.form-label for="{{ $id }}" class="sm:mt-2">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </x-base.form-label>
    @endif
    <div class="w-full mt-3 xl:mt-0 flex-1">
        <div class="relative">
            <input
                type="file"
                id="{{ $id }}"
                name="{{ $name }}"
                {{ $attributes->merge([
                    'class' => $inputClass . ' ' . $class,
                    'multiple' => $multiple,
                    'accept' => $accept,
                    'disabled' => $disabled,
                    'required' => $required
                ]) }}
            />
        </div>
        @error($name)
            <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
        @if($help = $attributes->get('help'))
            <div class="mt-2 text-slate-500 text-xs">{{ $help }}</div>
        @endif
    </div>
</div>
