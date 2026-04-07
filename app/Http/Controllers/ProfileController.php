<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Exibe a tela de perfil
    public function index()
    {
        return view('perfil.index');
    }

    // Atualiza o nome de usuário
    public function updateUsername(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user(); 

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ], [
            'username.unique' => 'Este nome de usuário já está sendo utilizado por outra pessoa.',
            'username.required' => 'O nome de usuário não pode ficar em branco.',
        ]);

        $user->update([
            'username' => $request->username
        ]);

        return back()->with('success', 'Nome de usuário atualizado com sucesso!');
    }

    // Atualiza a senha
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user(); 

        $request->validate([
            'current_password' => 'required|current_password', 
            'password'         => 'required|min:6|confirmed',  
        ], [
            'current_password.current_password' => 'Sua senha atual está incorreta.',
            'password.min'                      => 'A nova senha deve ter pelo menos 6 caracteres.',
            'password.confirmed'                => 'A confirmação da nova senha não confere.',
            'required'                          => 'Este campo é obrigatório.'
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Sua senha foi alterada com segurança!');
    }
}