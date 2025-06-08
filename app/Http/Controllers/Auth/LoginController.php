<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // HAPUS atau komentar ini karena kita pakai authenticated()
    // protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirect user setelah login berdasarkan role.
     */
    protected function authenticated(Request $request, $user)
    {
        // Redirect berdasarkan role_id
        if ($user->role_id == 1) { // superadmin
            return redirect()->route('dashboard');
        } elseif ($user->role_id == 2) { // admin
            return redirect()->route('dashboard');
        } elseif ($user->role_id == 3) { // manajer
            return redirect()->route('dashboard');
        }
        // Jika login sebagai customer (pengunjung), redirect ke beranda customer
        return redirect()->route('customer.beranda');
    }
}
