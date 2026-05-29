<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EspacoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            
            'tipo' => 'required|string|max:255',

            'endereco' => 'required|string',

            'capacidade' => 'nullable|interger',

            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:3072',
        ];
    }
}
