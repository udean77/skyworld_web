@extends('layouts.user')

@section('title', 'Register Customer')

@section('content')
<div class="container" style="max-width: 440px; margin: 60px auto;">
    <div class="card" style="
        border-radius: 24px;
        box-shadow: 0 4px 24px #00eaff33;
        padding: 36px;
        background: rgba(20,30,60,0.96);">
        
        <div style="display: flex; justify-content: center; margin-bottom: 20px;">
            <svg width="80" height="80" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="20" cy="20" r="20" fill="#00eaff"/>
                <circle cx="20" cy="20" r="12" fill="#203a43"/>
                <circle cx="28" cy="12" r="3" fill="#ffe066"/>
                <circle cx="12" cy="28" r="2" fill="#fff"/>
            </svg>
        </div>

        <div class="text-center mb-4">
            <h2 style="
                color: #ffe066;
                font-weight: 900;
                margin-bottom: 0;
                letter-spacing: 1px;
                text-shadow: 0 2px 12px #00eaff44;">
                Daftar Pengunjung
            </h2>
            <p style="color: #b2e0ff; font-size: 1rem; margin-bottom: 10px;">
                Buat akun untuk memesan tiket SkyWorld
            </p>
        </div>

        <form method="POST" action="{{ url('/customer/register') }}">
            @csrf

            @foreach ([
                'name' => 'Nama',
                'email' => 'Email',
                'no_telp' => 'No. Telepon',
                'password' => 'Password',
                'password_confirmation' => 'Konfirmasi Password'
            ] as $field => $label)
                <div style="margin-bottom: 36px;">
                    <label for="{{ $field }}" style="
                        font-size: 1rem;
                        font-weight: 700;
                        color: #ffe066;
                        display: block;
                        margin-bottom: 6px;">
                        {{ $label }}
                    </label>
                    <input
                        id="{{ $field }}"
                        type="{{ in_array($field, ['password', 'password_confirmation']) ? 'password' : ($field === 'email' ? 'email' : 'text') }}"
                        name="{{ $field }}"
                        value="{{ old($field) }}"
                        required {{ $field === 'name' ? 'autofocus' : '' }}
                        class="form-control"
                        style="
                            padding: 36px 24px;
                            border-radius: 14px;
                            padding: 12px;
                            background: #22304a;
                            color: #fff;
                            border: 1.5px solid #00eaff;
                            font-size: 1.05rem;">
                </div>
            @endforeach

            <button type="submit" style="
                width: 100%;
                margin-top: 10px;
                background: linear-gradient(90deg, #ffe066 0%, #00eaff 100%);
                color: #222;
                font-weight: 900;
                border-radius: 18px;
                font-size: 1.8rem;
                padding: 10px;
                box-shadow: 0 2px 8px #00eaff44;">
                Daftar
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ url('/customer/login') }}" style="
                color: #00eaff;
                font-weight: 700;
                text-decoration: none;
                letter-spacing: 1.5px;">
                Sudah punya akun? <span style="color: #ffe066;">Login</span>
            </a>
        </div>
    </div>
</div>
@endsection
