<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Uso: ->middleware('papel:admin,gestor'). O administrador sempre passa.
     */
    public function handle(Request $request, Closure $next, string ...$papeis): Response
    {
        $user = $request->user();

        abort_unless($user && ($user->isAdmin() || $user->temPapel(...$papeis)), 403);

        return $next($request);
    }
}
