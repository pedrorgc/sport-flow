<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <-- Importação crucial para a regra de negócio

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $espacoId = $this->route('espaco'); 

        return [
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            
            'endereco' => [
                'required',
                'string',
                Rule::unique('espacos', 'endereco')->ignore($espacoId)
            ],

            'capacidade' => 'required|integer|min:1',

            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:3072',
        ];
    }

    public function messages(): array
    {
        return [
            'endereco.unique' => 'Já existe um espaço cadastrado exatamente com este endereço.',
            'capacidade.min' => 'A capacidade do espaço deve ser de no mínimo 1 pessoa.',
        ];
    }
}