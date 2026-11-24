<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-waris-danger border border-transparent rounded-xl font-semibold text-xs text-white hover:bg-waris-danger-hover active:bg-waris-danger-hover focus:outline-none focus:ring-2 focus:ring-waris-danger focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer']) }}>
    {{ $slot }}
</button>
