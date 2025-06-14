<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect('login');
        }

        $userRole = $request->user()->role->nama_role;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Redirect based on role
        switch ($userRole) {
            case 'admin':
                return redirect()->route('dashboard');
            case 'customer':
                return redirect()->route('beranda');
            default:
                return redirect('login');
        }
    }
} 