@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-waris-primary-muted']) }}>
        {{ $status }}
    </div>
@endif
