<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && auth()->user()->visibility == 3){
            return response()->json([
                'message' => 'Você não tem permissão para acessar esse recurso.'
            ], 403);
        }
        return $next($request);
    }
}
