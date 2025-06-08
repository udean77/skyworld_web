@extends('layouts.user')
@section('title', 'Login')
@section('content')
<div class="container" style="max-width:400px; margin:60px auto;">
    <div class="card" style="border-radius:24px; box-shadow:0 4px 24px #00eaff33; padding:36px; background:rgba(20,30,60,0.96);">
        <div class="text-center mb-4">
            <svg width="80" height="80" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom:10px;">
                <circle cx="20" cy="20" r="20" fill="#00eaff"/>
                <circle cx="20" cy="20" r="12" fill="#203a43"/>
                <circle cx="28" cy="12" r="3" fill="#ffe066"/>
                <circle cx="12" cy="28" r="2" fill="#fff"/>
            </svg>
            <h2 style="color:#ffe066; font-weight:900; margin-bottom:0; letter-spacing:1px; text-shadow:0 2px 12px #00eaff44;">Login Pengunjung</h2>
            <div style="color:#b2e0ff; font-size:1rem; margin-bottom:10px;">Masuk untuk memesan tiket SkyWorld</div>
        </div>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ url('/customer/login') }}">
            @csrf
            <div style="margin-bottom:22px;">
                <label for="email" class="form-label" style="font-weight:700; color:#ffe066; display:block;">Email</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus style="border-radius:14px; padding:12px; background:#22304a; color:#fff; border:1.5px solid #00eaff; font-size:1.1rem;">
            </div>
            <div style="margin-bottom:22px;">
                <label for="password" class="form-label" style="font-weight:700; color:#ffe066; display:block;">Password</label>
                <input id="password" type="password" class="form-control" name="password" required style="border-radius:14px; padding:12px; background:#22304a; color:#fff; border:1.5px solid #00eaff; font-size:1.1rem;">
            </div>
            <button type="submit" class="btn-buy" style="width:100%; margin-top:10px; background:linear-gradient(90deg,#ffe066 0%,#00eaff 100%); color:#222; font-weight:900; border-radius:18px; font-size:1.1rem; box-shadow:0 2px 8px #00eaff44;">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ url('/customer/register') }}" style="color:#00eaff; font-weight:700; text-decoration:none; letter-spacing:0.5px;">Belum punya akun? <span style="color:#ffe066;">Daftar</span></a>
        </div>
    </div>
</div>
@endsection
