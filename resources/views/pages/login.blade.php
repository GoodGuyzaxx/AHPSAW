@extends('layouts.login')

@section('title', 'Masuk ke Sistem')

@section('content')
    <section class="auth-wrap d-flex align-items-center py-5">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-11 col-lg-10">
                    <div class="auth-card row g-0">
                        <!-- LEFT: brand / copy -->
                        <div class="col-lg-5 auth-left d-flex flex-column justify-content-between">
                            <div>
                                <div class="brand-badge mb-4">
                                    <img src="{{ url('frontend/images/logo.png') }}" alt="logo" width="30" height="30">
                                </div>
                                <h2 class="fw-bold mb-2">Selamat Datang 👋</h2>
                                <p class="helper mb-4">
                                    Masuk untuk mengakses dashboard
                                </p>
                                <ul class="helper ps-3">
                                    <li>Lakukan Pengambilan Kepetusan Dengan Mudah  </li>
                                    <li>Metode AHP Membantu Dalam Pemilihan</li>
                                </ul>
                            </div>
                        </div>

                        <!-- RIGHT: form -->
                        <div class="col-lg-7 auth-right">
                            <h4 class="fw-bold mb-1 text-white">Masuk ke Akun</h4>
                            <p class="helper mb-4">Silakan gunakan <em>username</em> atau <em>email</em> dan kata sandi.</p>

                            {{-- Flash / Error --}}
                            @if (session('status'))
                                <div class="alert alert-success mb-3">{{ session('status') }}</div>
                            @endif
                            @if (session('loginError'))
                                <div class="alert alert-danger mb-3">{{ session('loginError') }}</div>
                            @endif

                            <form action="{{ route('login.index') }}" method="POST" novalidate>
                                @csrf

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username atau Email</label>
                                    <div class="input-wrap">
                                        {{-- icon mail/user --}}
                                        <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                            <path d="M4 6h16v12H4z" stroke="currentColor" stroke-width="1.5" opacity=".7"/>
                                            <path d="M4 7l8 6 8-6" stroke="currentColor" stroke-width="1.5" opacity=".7"/>
                                        </svg>
                                        <input id="username" type="text"
                                               class="form-control @error('username') is-invalid @enderror"
                                               name="username" value="{{ old('username') }}"
                                               required autofocus placeholder="nama@domain.com atau username">
                                    </div>
                                    @error('username')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <div class="input-wrap">
                                        {{-- icon lock --}}
                                        <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                            <rect x="5" y="11" width="14" height="9" rx="2" stroke="currentColor" stroke-width="1.5" opacity=".7"/>
                                            <path d="M8 11V8a4 4 0 118 0v3" stroke="currentColor" stroke-width="1.5" opacity=".7"/>
                                        </svg>
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required placeholder="••••••••">
                                        <button type="button" class="btn btn-sm position-absolute end-0 top-50 translate-middle-y me-2"
                                                id="togglePass" aria-label="Tampilkan password"
                                                style="background:transparent; color:#cbd5e1">
                                            <svg id="eye" width="22" height="22" viewBox="0 0 24 24" fill="none">
                                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"
                                                      stroke="currentColor" stroke-width="1.5" opacity=".9"/>
                                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5" opacity=".9"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember" class="form-check-label">Ingat saya</label>
                                    </div>
{{--                                    <a class="small-link" href="{{ route('password.request') ?? '#' }}">--}}
{{--                                        Lupa password?--}}
{{--                                    </a>--}}
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    Masuk
                                </button>
                                <div class="footer-mini">
                                    &copy; {{ now()->year }} — SI-SPK
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- /col -->
            </div>
        </div>
    </section>
    <script>
        // Toggle show/hide password
        const pass = document.getElementById('password');
        const btn = document.getElementById('togglePass');
        const eye = document.getElementById('eye');
        if(btn){
            btn.addEventListener('click', () => {
                const isPwd = pass.getAttribute('type') === 'password';
                pass.setAttribute('type', isPwd ? 'text' : 'password');
                // swap icon (eye / eye-off)
                eye.innerHTML = isPwd
                    ? `<path d="M3 3l18 18" stroke="currentColor" stroke-width="1.5"/><path d="M10.6 10.6A3 3 0 0012 15a3 3 0 001.4-.37M9.88 4.14A10.7 10.7 0 0112 4c6.5 0 10 7 10 7a17.2 17.2 0 01-3.29 4.21M6.1 6.1A17.1 17.1 0 002 11s3.5 7 10 7a10.7 10.7 0 004.15-.82" stroke="currentColor" stroke-width="1.5" fill="none"/>`
                    : `<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/>`;
            });
        }
    </script>
@endsection

