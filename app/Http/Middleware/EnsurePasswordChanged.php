<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    /** Rotas liberadas enquanto a senha temporária não for trocada. */
    private const ROTAS_LIBERADAS = ['perfil.index', 'perfil.password'];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->must_change_password && ! $request->routeIs(...self::ROTAS_LIBERADAS)) {
            return redirect()->route('perfil.index')
                ->with('aviso', 'Você está usando uma senha temporária. Defina uma nova senha para continuar.');
        }

        return $next($request);
    }
}
