@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Kelola informasi akun dan keamanan Anda</p>
            </div>
            <div class="d-flex align-items-center">
                <i class="fas fa-user-circle fa-2x text-primary me-2"></i>
                <div>
                    <small class="text-muted d-block">Login sebagai</small>
                    <span class="fw-semibold text-primary">{{ auth()->user()->level }}</span>
                </div>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <!-- Profile Content -->
        <div class="row g-4">
            <!-- Profile Information Card -->
            <div class="col-lg-8">
                <div class="card h-100 border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
                    <div class="card-header bg-gradient-primary text-white border-0 rounded-top">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-user-edit text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Informasi Profil</h5>
                                <small class="opacity-75">Perbarui informasi akun Anda</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('profile.update', $userData->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <!-- Avatar Section -->
                            <div class="text-center mb-4 pb-3 border-bottom">
                                <div class="position-relative d-inline-block">
                                    <div class="avatar-lg bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center shadow">
                                        <i class="fas fa-user fa-3x text-white"></i>
                                    </div>
                                    <div class="position-absolute bottom-0 end-0">
                                        <div class="bg-success rounded-circle p-2 shadow-sm">
                                            <i class="fas fa-check fa-sm text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mt-3 mb-1 fw-bold">{{ $userData->name }}</h5>
                                <p class="text-muted mb-0">{{ $userData->email }}</p>
                            </div>

                            <div class="row g-3">
                                <!-- Full Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                                    </label>
                                    <input type="text"
                                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ $userData->name }}"
                                           autofocus
                                           required
                                           placeholder="Masukan nama lengkap">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Username -->
                                <div class="col-md-6">
                                    <label for="username" class="form-label fw-semibold">
                                        <i class="fas fa-at me-2 text-success"></i>Username
                                    </label>
                                    <input type="text"
                                           class="form-control form-control-lg @error('username') is-invalid @enderror"
                                           id="username"
                                           name="username"
                                           value="{{ $userData->username }}"
                                           required
                                           placeholder="Masukan username">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-12">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-2 text-info"></i>Alamat Email
                                    </label>
                                    <input type="email"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ $userData->email }}"
                                           required
                                           placeholder="example@example.com">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 pt-3 border-top">
                                <button type="reset" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm animate-fade-in" style="animation-delay: 0.2s">
                    <div class="card-header bg-gradient-warning text-white border-0 rounded-top">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Keamanan</h5>
                                <small class="opacity-75">Ubah password Anda</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profile.update', $userData->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <!-- Security Info -->
                            <div class="alert alert-info border-0 bg-info bg-opacity-10 mb-4">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-info-circle text-info me-2 mt-1"></i>
                                    <div>
                                        <strong class="d-block">Tips Keamanan:</strong>
                                        <small>Gunakan kombinasi huruf besar, kecil, angka, dan simbol untuk password yang kuat.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Old Password -->
                            <div class="mb-3">
                                <label for="oldPassword" class="form-label fw-semibold">
                                    <i class="fas fa-key me-2 text-secondary"></i>Password Lama
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control @error('oldPassword') is-invalid @enderror"
                                           id="oldPassword"
                                           name="oldPassword"
                                           required
                                           placeholder="Masukan password lama">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('oldPassword')">
                                        <i class="fas fa-eye" id="oldPassword-icon"></i>
                                    </button>
                                </div>
                                @error('oldPassword')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="fas fa-lock me-2 text-primary"></i>Password Baru
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           required
                                           placeholder="Masukan password baru">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-icon"></i>
                                    </button>
                                </div>
                                @error('password')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="fas fa-lock me-2 text-success"></i>Konfirmasi Password
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           required
                                           placeholder="Ulangi password baru">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                    </button>
                                </div>
                                @error('password')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning btn-lg text-white fw-semibold">
                                    <i class="fas fa-shield-alt me-2"></i>Perbarui Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Info -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.3s">
                    <div class="card-body p-4">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="icon-shape bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-calendar text-primary"></i>
                                    </div>
                                    <div class="text-start">
                                        <h6 class="mb-0 fw-semibold">Bergabung</h6>
                                        <small class="text-muted">{{ $userData->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="icon-shape bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-clock text-success"></i>
                                    </div>
                                    <div class="text-start">
                                        <h6 class="mb-0 fw-semibold">Login Terakhir</h6>
                                        <small class="text-muted">{{ now()->format('d M Y, H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="icon-shape bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-user-tag text-info"></i>
                                    </div>
                                    <div class="text-start">
                                        <h6 class="mb-0 fw-semibold">Role</h6>
                                        <small class="text-muted">{{ ucfirst($userData->level) }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="icon-shape bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-shield-check text-warning"></i>
                                    </div>
                                    <div class="text-start">
                                        <h6 class="mb-0 fw-semibold">Status</h6>
                                        <small class="text-success">
                                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Aktif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Custom Script for Password Toggle -->
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Add password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.createElement('div');

            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            // Remove existing strength meter
            const existingMeter = this.parentNode.parentNode.querySelector('.password-strength');
            if (existingMeter) {
                existingMeter.remove();
            }

            if (password.length > 0) {
                strengthMeter.className = 'password-strength mt-2';
                let strengthText = '';
                let strengthClass = '';

                switch (strength) {
                    case 0:
                    case 1:
                        strengthText = 'Sangat Lemah';
                        strengthClass = 'text-danger';
                        break;
                    case 2:
                        strengthText = 'Lemah';
                        strengthClass = 'text-warning';
                        break;
                    case 3:
                        strengthText = 'Sedang';
                        strengthClass = 'text-info';
                        break;
                    case 4:
                        strengthText = 'Kuat';
                        strengthClass = 'text-success';
                        break;
                    case 5:
                        strengthText = 'Sangat Kuat';
                        strengthClass = 'text-success';
                        break;
                }

                strengthMeter.innerHTML = `
                    <small class="${strengthClass}">
                        <i class="fas fa-shield-alt me-1"></i>
                        Kekuatan Password: <strong>${strengthText}</strong>
                    </small>
                `;

                this.parentNode.parentNode.appendChild(strengthMeter);
            }
        });
    </script>

    <style>
        .avatar-lg {
            width: 80px;
            height: 80px;
        }

        .icon-shape {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%) !important;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-warning.text-white:hover {
            color: white !important;
        }

        .password-strength {
            transition: all 0.3s ease;
        }
    </style>
@endsection
