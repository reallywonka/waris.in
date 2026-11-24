@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-waris-border focus:border-waris-primary focus:ring-waris-primary rounded-xl shadow-2xs text-waris-text bg-waris-surface']) }}>
