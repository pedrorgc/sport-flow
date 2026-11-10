<?php

namespace App\Enums;

enum Papel: string
{
    case Admin = 'admin';
    case Gestor = 'gestor';
    case Monitor = 'monitor';

    public function rotulo(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Gestor => 'Gestor',
            self::Monitor => 'Monitor',
        };
    }
}
