@props([
    'icon',
    'label',
    'href' => '#',
    'active' => false
])

<a href="{{ $href }}"
   class="text-decoration-none d-flex align-items-center gap-3 px-3 py-3 rounded-4 mb-2
   {{ $active ? 'bg-primary text-white shadow-sm' : 'text-dark' }}"
   style="transition: 0.2s;">

    <i class="{{ $icon }}" style="font-size: 1.2rem; width: 20px;"></i>
    <span class="fw-semibold">{{ $label }}</span>
</a>