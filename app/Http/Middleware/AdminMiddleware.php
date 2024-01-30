<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        //si el usuario está logeado 'auth()->check()' y
        //si el rol de ese usuario es admin redirigir a X
        if (auth()->check() && auth()->user()->role == 'admin')
            return $next($request);
    
        return redirect('/forbidden');    
    }
}
