<?php

namespace Database\Factories;

use App\Enums\Papel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => Papel::Monitor,
            'ativo' => true,
        ];
    }

    public function admin(): static
    {
        return $this->state(['role' => Papel::Admin]);
    }

    public function gestor(): static
    {
        return $this->state(['role' => Papel::Gestor]);
    }

    public function monitor(): static
    {
        return $this->state(['role' => Papel::Monitor]);
    }

    public function bloqueado(): static
    {
        return $this->state(['ativo' => false]);
    }
}
