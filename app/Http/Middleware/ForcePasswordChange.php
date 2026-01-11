<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->premiere_connexion && 
            $request->path() !== '/' &&
            $user->role !== 'admin' &&
            !$request->routeIs('password.change') && 
            !$request->routeIs('password.update') && 
            !$request->routeIs('password.update_initial') && 
            !$request->routeIs('logout')) {
            
            return redirect()->route('password.change');
        }

        return $next($request);
    }
}
