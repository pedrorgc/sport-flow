@props([
    'title'
])

<div class="card border-0 shadow-sm rounded-4 h-100">
    <div class="card-body">
        <h5 class="fw-semibold mb-4">{{ $title }}</h5>
        {{ $slot }}
    </div>
</div>