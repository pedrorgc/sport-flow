<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Pedro',
            'username' => 'prgc',
            'password' => 'pedro10'
        ]);

        User::create([
            'name' => 'Rai',
            'username' => 'raipb',
            'password' => 'raipb10'
        ]);

        User::create([
            'name' => 'Luiz',
            'username' => 'luiz',
            'password' => 'luiz10'
        ]);
    }
}