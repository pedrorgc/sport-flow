<button {{ $attributes->merge(['class' => 'btn btn-primary d-flex align-items-center gap-2']) }}>
    {{ $slot }}
</button>