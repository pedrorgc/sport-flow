@props([
    'title' => null
])

<div class="card-premium h-100"> <h5 class="fw-bold mb-3" style="color: #0f172a;">{{ $title }}</h5>
    {{ $slot }}
</div>