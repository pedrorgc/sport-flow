<?php

namespace App\Http\Requests;

use App\Enums\Papel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    protected function prepareForValidation(): void
    {
        // O login converte o usuário para maiúsculas; grava no mesmo formato.
        $this->merge([
            'username' => Str::upper(trim((string) $this->input('username'))),
            'name' => trim((string) $this->input('name')),
        ]);
    }

    public function rules(): array
    {
        $usuario = $this->route('usuario');

        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 'string', 'min:3', 'max:50', 'regex:/^[A-Z0-9._-]+$/',
                Rule::unique('users', 'username')->ignore($usuario?->id),
            ],
            'role' => ['required', Rule::enum(Papel::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Informe o nome da pessoa.',
            'username.required' => 'Informe o nome de usuário.',
            'username.min' => 'O nome de usuário deve ter pelo menos 3 caracteres.',
            'username.regex' => 'O nome de usuário aceita apenas letras, números, ponto, hífen e sublinhado, sem espaços.',
            'username.unique' => 'Este nome de usuário já está em uso.',
            'role.required' => 'Selecione o papel do usuário.',
            'role.enum' => 'Papel inválido.',
        ];
    }
}
