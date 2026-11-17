<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Le « vigile » : laisse passer seulement les rôles autorisés.
     * Utilisation dans les routes : ->middleware('role:admin') ou ->middleware('role:admin,doctor')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles)) {
            abort(403, 'Cette page est réservée aux comptes : ' . implode(', ', $roles) . '.');   // ❌ bloqué
        }

        return $next($request);   // ✅ on laisse passer vers la page
    }
}