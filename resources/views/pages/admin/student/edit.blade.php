@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Perbarui data untuk mahasiswa: <strong>{{ $student->name }}</strong></p>
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
                    <a href="{{ route('student.index') }}" class="text-decoration-none">
                        <i class="fas fa-user-graduate me-1"></i>Data Mahasiswa
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
                                <i class="fas fa-user-edit text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Formulir Edit Mahasiswa</h5>
                                <small class="opacity-75">Ubah data sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="npm" class="form-label fw-semibold"><i class="fas fa-id-card me-2 text-primary"></i>NPM</label>
                                <input type="number" class="form-control @error('npm') is-invalid @enderror" id="npm" name="npm" value="{{ old('npm', $student->npm) }}" autofocus required>
                                @error('npm')<div class="invalid-feedback mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold"><i class="fas fa-user me-2 text-info"></i>Nama Mahasiswa</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $student->name) }}" required>
                                @error('name')<div class="invalid-feedback mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-venus-mars me-2 text-success"></i>Jenis Kelamin</label>
                                <div class="d-flex pt-2">
                                    <div class="form-check form-check-inline me-4">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_laki" value="Laki-laki" {{ old('gender', $student->gender) == 'Laki-laki' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="gender_laki">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_perempuan" value="Perempuan" {{ old('gender', $student->gender) == 'Perempuan' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="gender_perempuan">Perempuan</label>
                                    </div>
                                </div>
                                @error('gender')<div class="invalid-feedback d-block mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="nomor_hp" class="form-label fw-semibold"><i class="fas fa-phone me-2 text-danger"></i>Nomor Handphone</label>
                                <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $student->nomor_hp) }}" required>
                                @error('nomor_hp')<div class="invalid-feedback mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold"><i class="fas fa-envelope me-2 text-warning"></i>Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $student->email) }}" required>
                                @error('email')<div class="invalid-feedback mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                            </div>
                    </div>

                    <div class="card-footer bg-light border-0 text-end p-3">
                        <a href="{{ route('student.index') }}" class="btn btn-secondary me-2"><i class="fas fa-times me-2"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.style-script')
@endsection
