<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordExpired
{
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && auth()->user()->password_expires_at < now()){
            return response()->json([
                'error' => 'Senha expirada'
            ], 403);
        }
        return $next($request);
    }
}
