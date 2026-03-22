<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="fw-bold mb-1">{{ $title }}</h5>
        @isset($subtitle)
            <small class="text-muted">{{ $subtitle }}</small>
        @endisset
    </div>

    <div>
        {{ $slot }}
    </div>
</div>