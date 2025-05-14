@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh; background: url('{{ asset('images/space-bg.jpg') }}') no-repeat center center; background-size: cover;">
    <div class="card shadow-lg" style="width: 400px;">
        <div class="card-header text-center bg-primary text-white">
            <h3>Welcome to SkyWorld</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a class="text-decoration-none" href="{{ route('password.request') }}">Forgot Your Password?</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
