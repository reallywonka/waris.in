<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-waris-primary border border-transparent rounded-xl font-semibold text-xs text-white hover:bg-waris-primary-hover focus:bg-waris-primary-hover active:bg-waris-primary-active focus:outline-none focus:ring-2 focus:ring-waris-primary focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer']) }}>
    {{ $slot }}
</button>
