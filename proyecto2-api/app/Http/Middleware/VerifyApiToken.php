<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-API-Key') 
               ?? $request->header('Authorization');

        // Si viene como "Bearer mitoken", extraemos solo el token
        if ($token && str_starts_with($token, 'Bearer ')) {
            $token = substr($token, 7);
        }

        if (!$token || $token !== config('app.api_secret_key')) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado. Token inválido o ausente.'
            ], 401);
        }

        return $next($request);
    }
}