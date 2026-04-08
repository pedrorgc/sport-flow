@props([
    'title' => null
])

<div class="card-premium h-100"> 
    @if($title)
        <h5 class="titulo-marca mb-3">{{ $title }}</h5>
    @endif
    {{ $slot }}
</div>