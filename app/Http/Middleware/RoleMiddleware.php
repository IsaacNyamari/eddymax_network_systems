<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role, $permission = null): Response
    {
        if (!$request->user()) {
            abort(403, 'Unauthorized');
        }

        if (!$request->user()->hasRole($role)) {
            abort(403, 'Access denied. You do not have the required role.');
        }

        if ($permission && !$request->user()->can($permission)) {
            abort(403, 'Access denied. You do not have the required permission.');
        }

        return $next($request);
    }
}