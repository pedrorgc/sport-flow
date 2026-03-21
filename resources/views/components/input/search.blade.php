<input 
    type="text" 
    {{ $attributes->merge(['class' => 'form-control']) }}
    placeholder="{{ $placeholder ?? 'Buscar...' }}"
>