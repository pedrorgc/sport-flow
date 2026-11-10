<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use App\Enums\Papel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Papel::class,
            'ativo' => 'boolean',
        ];
    }

    public function temPapel(string ...$papeis): bool
    {
        return in_array($this->role?->value, $papeis, true);
    }

    public function isAdmin(): bool
    {
        return $this->role === Papel::Admin;
    }

    public function isGestor(): bool
    {
        return $this->role === Papel::Gestor;
    }

    public function isMonitor(): bool
    {
        return $this->role === Papel::Monitor;
    }

    /** Administrador e gestor podem alterar dados do sistema; monitor só consulta. */
    public function podeGerenciar(): bool
    {
        return $this->isAdmin() || $this->isGestor();
    }
}
