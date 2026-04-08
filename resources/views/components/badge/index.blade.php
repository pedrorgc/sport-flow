@props(['type' => 'success'])

<span class="badge rounded-pill bg-{{ $type }} bg-opacity-10 text-{{ $type }} px-3 py-2 fw-medium border border-{{ $type }} border-opacity-25">
    {{ $slot }}
</span>