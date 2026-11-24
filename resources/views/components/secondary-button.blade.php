<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-waris-surface border border-waris-border-strong rounded-xl font-semibold text-xs text-waris-text-secondary shadow-2xs hover:bg-waris-surface-hover focus:outline-none focus:ring-2 focus:ring-waris-primary focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 cursor-pointer']) }}>
    {{ $slot }}
</button>
