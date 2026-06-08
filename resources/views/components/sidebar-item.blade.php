@props([
    'icon',
    'label',
    'href' => '#',
    'active' => false
])

<a href="{{ $href }}"
   class="text-decoration-none d-flex align-items-center gap-3 px-3 py-2 rounded-3 mb-1 item-hover
   {{ $active ? 'active-item' : 'text-secondary' }}"
   style="transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);">

    <i class="{{ $icon }}" style="font-size: 1.1rem; width: 20px; text-align: center; transition: color 0.2s;"></i>
    
    <span style="font-weight: {{ $active ? '600' : '500' }}; font-size: 0.95rem;">{{ $label }}</span>
</a>