<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Cria o usuário de teste Administrativo
        User::create([
            'name' => 'Administrador',
            'username' => 'ADM', // As iniciais que vão no login
            'password' => Hash::make('ADM12345678'), // O Laravel já salva a senha criptografada!
        ]);
    }
}