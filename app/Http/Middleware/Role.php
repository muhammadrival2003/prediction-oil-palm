<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user()->role == 'user' && $role != 'user') {
            return redirect('/beranda');
        } else if ($request->user()->role == 'manager' && $role != 'manager') {
            return redirect('/manager/laporan');
        }
        return $next($request);
    }
}