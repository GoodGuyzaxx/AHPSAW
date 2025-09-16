@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Kelola akun yang memiliki akses ke sistem.</p>
            </div>
        </div>

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

        <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
            <div class="card-header bg-light border-0 py-3">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <h5 class="mb-3 mb-md-0 fw-bold">
                        <i class="fas fa-user-friends me-2 text-primary"></i>
                        Daftar Pengguna
                    </h5>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-plus me-2"></i>Tambah Pengguna
                        </a>
                        <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input type="file" name="file" class="form-control" required>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-upload me-1"></i> Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        @foreach ($errors->all() as $error)<span>{{ $error }}</span>@endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    @if ($user->level == 'ADMIN')
                                        <span class="badge bg-primary">Admin</span>
                                    @else
                                        <span class="badge bg-secondary">User</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-danger py-4">
                                    <i class="fas fa-exclamation-circle me-2"></i>Data pengguna tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    @include('partials.style-script')
@endsection
