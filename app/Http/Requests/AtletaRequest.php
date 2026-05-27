<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AtletaRequest extends FormRequest
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
            'data_nascimento' => 'required|date',
            'cpf_rg' => 'nullable|string|max:20|unique:atletas,cpf_rg,' . $this->route('atleta'),
            'categoria' => 'required|string',
            'modalidade_id' => 'required|exists:modalidades,id',
            'contato' => 'nullable|string|max:255',
        ];
    }
}
