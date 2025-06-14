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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect('login');
        }

        // Cek apakah user memiliki role admin (role_id 1, 2, atau 3)
        if ($request->user()->role_id == 1 || $request->user()->role_id == 2 || $request->user()->role_id == 3) {
            return $next($request);
        }

        // Jika bukan admin, redirect ke beranda customer
        return redirect()->route('customer.beranda');
    }
}
