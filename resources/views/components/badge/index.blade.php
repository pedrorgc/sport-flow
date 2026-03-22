@props(['type' => 'success'])

@php
$classes = [
    'success' => 'bg-success-subtle text-success',
    'secondary' => 'bg-secondary-subtle text-secondary'
][$type] ?? 'bg-light';
@endphp

<span class="badge rounded-pill {{ $classes }}">
    {{ $slot }}
</span>