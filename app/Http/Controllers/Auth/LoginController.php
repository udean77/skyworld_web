<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Cek role user
        if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3) { // superadmin, admin, manager
            return redirect()->route('dashboard');
        }
        
        // Jika bukan admin, redirect ke beranda customer
        return redirect()->route('customer.beranda');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
