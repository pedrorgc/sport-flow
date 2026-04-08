@props([
    'title',
    'value',
    'subtitle',
    'icon',
    'color' => 'primary'
])

<div class="card-premium h-100 d-flex justify-content-between align-items-start p-4">
    <div>
        <div class="text-uppercase text-secondary fw-semibold small mb-2" style="letter-spacing: 0.5px;">{{ $title }}</div>
        <h2 class="mb-1 fw-bold text-dark">{{ $value }}</h2>
        <div class="text-secondary small">{{ $subtitle }}</div>
    </div>

    <div class="bg-{{ $color }} bg-opacity-10 text-{{ $color }} rounded-4 d-flex align-items-center justify-content-center border border-{{ $color }} border-opacity-25"
         style="width: 54px; height: 54px; min-width: 54px;">
        <i class="{{ $icon }}" style="font-size: 1.5rem; line-height: 1;"></i>
    </div>
</div>