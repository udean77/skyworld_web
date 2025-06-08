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
        // Pastikan user punya role_id 1 (manager), 2 (superadmin), atau 3 (admin)
        $user = auth()->user();
        if ($user && in_array($user->role_id, [1, 2, 3])) {
            return $next($request);
        }

        // Redirect jika user bukan admin/superadmin/manager
        return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
