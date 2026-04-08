<input 
    type="text" 
    {{ $attributes->merge(['class' => 'form-control bg-light']) }}
    placeholder="{{ $placeholder ?? 'Buscar...' }}"
>