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
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        if (!auth()->check()) {
            abort(403, 'Anda harus login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Anda tidak punya akses');
        }
        return $next($request);
    }
}
