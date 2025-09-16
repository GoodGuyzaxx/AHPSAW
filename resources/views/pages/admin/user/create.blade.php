@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Tambahkan pengguna baru ke dalam sistem.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <i class="fas fa-user-friends me-1"></i>Data Pengguna
                    </a>
                </li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
                    <div class="card-header bg-gradient-info text-white border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-user-plus text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Formulir Tambah Pengguna</h5>
                                <small class="opacity-75">Isi semua kolom yang diperlukan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold"><i class="fas fa-user me-2 text-primary"></i>Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" autofocus required placeholder="Contoh: John Doe">
                                <small class="text-muted mt-1 d-block">Nama lengkap pengguna.</small>
                                @error('name')<div class="invalid-feedback mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold"><i class="fas fa-at me-2 text-info"></i>Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required placeholder="Contoh: johndoe">
                                <small class="text-muted mt-1 d-block">Username unik untuk login, tanpa spasi.</small>
                                @error('username')<div class="invalid-feedback mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold"><i class="fas fa-envelope me-2 text-success"></i>Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: user@example.com">
                                <small class="text-muted mt-1 d-block">Email aktif pengguna.</small>
                                @error('email')<div class="invalid-feedback mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold"><i class="fas fa-lock me-2 text-danger"></i>Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimal 8 karakter">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                </div>
                                <small class="text-muted mt-1 d-block">Buat password yang kuat.</small>
                                @error('password')<div class="invalid-feedback mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="level" class="form-label fw-semibold"><i class="fas fa-shield-alt me-2 text-warning"></i>Level Pengguna</label>
                                <select class="form-select @error('level') is-invalid @enderror" id="level" name="level" required>
                                    <option value="" disabled selected>Pilih level...</option>
                                    <option value="ADMIN" {{ old('level') === 'ADMIN' ? 'selected' : '' }}>Admin</option>
                                    <option value="USER" {{ old('level') === 'USER' ? 'selected' : '' }}>User</option>
                                </select>
                                <small class="text-muted mt-1 d-block">Tentukan hak akses pengguna.</small>
                                @error('level')<div class="invalid-feedback mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>
                    </div>

                    <div class="card-footer bg-light border-0 text-end p-3">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary me-2"><i class="fas fa-times me-2"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.style-script')
@endsection
