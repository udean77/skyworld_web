<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOnlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login, redirect ke login customer
        if (!Auth::check()) {
            return redirect()->route('customer.login');
        }
        // Jika user login sebagai admin/user, redirect ke dashboard
        $user = Auth::user();
        if (isset($user->role_id) && in_array($user->role_id, [1,2,3])) {
            return redirect()->route('dashboard');
        }
        // Jika bukan admin/user, izinkan akses (diasumsikan customer)
        return $next($request);
    }
}
