@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-waris-text-secondary']) }}>
    {{ $value ?? $slot }}
</label>
