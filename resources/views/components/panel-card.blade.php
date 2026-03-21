@props([
    'title' => null
])

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        {{ $slot }}
    </div>
</div>