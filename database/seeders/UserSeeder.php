<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\Papel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::forceCreate([
            'role' => Papel::Admin,
            'name' => 'Pedro',
            'username' => 'prgc',
            'password' => 'pedro10'
        ]);

        User::forceCreate([
            'role' => Papel::Admin,
            'name' => 'Rai',
            'username' => 'raipb',
            'password' => 'raipb10'
        ]);

        User::forceCreate([
            'role' => Papel::Admin,
            'name' => 'Luiz',
            'username' => 'luiz',
            'password' => 'felipe20'
        ]);
    }
}