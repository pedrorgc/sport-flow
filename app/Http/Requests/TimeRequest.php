<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // 1. Se o formulário enviado for o de Atualizar Elenco
        if ($this->has('sync_atletas')) {
            return [
                'sync_atletas' => 'required',
                'atletas' => 'nullable|array',
                'atletas.*' => 'exists:atletas,id', // Garante que não enviem IDs de atletas que não existem
            ];
        }

        // 2. Se for o formulário normal de Cadastro/Edição de Dados do Time
        return [
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string',
            'modalidade_id' => 'required|exists:modalidades,id',
            'brasao' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ];
    }
}