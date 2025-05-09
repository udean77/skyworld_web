<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan ada role 'admin' di user
        if (auth()->user() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Redirect jika user bukan admin
        return redirect('/home');
    }
}
