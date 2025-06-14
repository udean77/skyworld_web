<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Cek role_id untuk admin (1, 2, atau 3)
                if ($user && ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3)) {
                    return redirect()->route('dashboard');
                }
                
                // Jika bukan admin, redirect ke beranda customer
                return redirect()->route('customer.beranda');
            }
        }

        return $next($request);
    }
}
