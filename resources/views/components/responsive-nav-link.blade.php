@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-waris-primary text-start text-base font-medium text-waris-primary bg-waris-primary-soft focus:outline-none focus:text-waris-primary focus:bg-waris-primary-soft focus:border-waris-primary-hover transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-waris-muted hover:text-waris-text hover:bg-waris-surface-hover hover:border-waris-border-strong focus:outline-none focus:text-waris-text focus:bg-waris-surface-hover focus:border-waris-border-strong transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
