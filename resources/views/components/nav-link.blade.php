@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-waris-primary text-sm font-medium leading-5 text-waris-text focus:outline-none focus:border-waris-primary-hover transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-waris-subtle hover:text-waris-text-secondary hover:border-waris-border-strong focus:outline-none focus:text-waris-text-secondary focus:border-waris-border-strong transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
