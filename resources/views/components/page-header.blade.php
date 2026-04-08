<div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
    <div>
        <h2 class="titulo-marca mb-1" style="font-size: 2.2rem;">{{ $title }}</h2>
        @isset($subtitle)
            <div class="text-secondary small mt-1">{{ $subtitle }}</div>
        @endisset
    </div>

    <div>
        {{ $slot }}
    </div>
</div>