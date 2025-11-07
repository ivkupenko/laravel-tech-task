<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $role = $request->route()->defaults['role'] ?? null;

        if (!auth()->check()) {
            abort(403, 'Unauthorized.');
        }

        $user = auth()->user();

        if ($role && ! $user->hasRole($role)) {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
