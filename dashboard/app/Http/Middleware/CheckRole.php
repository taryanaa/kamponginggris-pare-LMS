<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login
        if (!$request->user()) {
            return redirect('/');
        }

        // Cek apakah role user sesuai
        if ($request->user()->role !== $role) {
            abort(403, 'Unauthorized access. Your role: ' . $request->user()->role);
        }

        return $next($request);
    }
}