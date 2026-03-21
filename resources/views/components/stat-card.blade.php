@props([
    'title',
    'value',
    'subtitle',
    'icon',
    'color' => 'primary'
])

<div class="card border-0 shadow-sm rounded-4 h-100">
    <div class="card-body d-flex justify-content-between align-items-start p-4">
        <div>
            <div class="text-uppercase text-muted small mb-2">{{ $title }}</div>
            <h2 class="mb-1">{{ $value }}</h2>
            <div class="text-muted">{{ $subtitle }}</div>
        </div>

        <div class="bg-{{ $color }} text-white rounded-4 d-flex align-items-center justify-content-center"
             style="width: 54px; height: 54px; min-width: 54px;">
            <i class="{{ $icon }}" style="font-size: 1.2rem; line-height: 1;"></i>
        </div>
    </div>
</div>