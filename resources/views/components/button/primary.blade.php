<button {{ $attributes->merge(['class' => 'btn btn-premium d-flex align-items-center gap-2 shadow-sm']) }}>
    {{ $slot }}
</button>