<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();
        if (!$user || ($user->role->nombre_rol !== $role && $user->role->nombre_rol !== 'admin')) {
            return response()->json([
                'response_code' => 403,
                'success' => false,
                'message' => 'Unauthorized - Insufficient permissions'
            ], 403);
        }

        return $next($request);
    }
}
