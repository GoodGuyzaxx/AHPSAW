@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Kelola data seluruh Mahasiswa yang terdaftar dalam sistem.</p>
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
{{--                <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}" class="text-decoration-none">Data Kelas</a></li>--}}
            </ol>
        </nav>

        <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
            <div class="card-header bg-light border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user-graduate me-2 text-primary"></i>
                        Daftar Mahasiswa
                    </h5>
                    @can('admin')
                        <a href="{{ route('student.create') }}" type="button" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Tambah Data Mahasiswa
                        </a>
                    @endcan
                </div>
            </div>

            <div class="card-body p-4">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <select class="form-select form-select-sm me-2" id="perPage" onchange="submitForm()">
                                @foreach ($perPageOptions as $option)
                                    <option value="{{ $option }}" {{ $option == $perPage ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            <label class="form-label mb-0 text-muted small">entri per halaman</label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form action="{{ route('student.index') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari" value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>NPM</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Nomor Hp</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($students as $student)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $student->npm }}</td>
                                <td>{{ $student->name }}</td>
                                <td class="text-center">{{ $student->gender }}</td>
                                <td class="text-center">{{ $student->nomor_hp }}</td>
                                <td class="text-center">{{ $student->email }}</td>
                                <td class="text-center">
                                    <a href="{{ route('student.edit', $student->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('student.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-danger py-4">
                                    <i class="fas fa-exclamation-circle me-2"></i>Data tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $students->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </main>

    <script>
        function submitForm() {
            const perPage = document.getElementById('perPage').value;
            const url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            url.searchParams.set('page', '1'); // Selalu kembali ke halaman 1 saat entri diubah
            window.location.href = url.toString();
        }
    </script>
    <style>
        .animate-fade-in { opacity: 0; transform: translateY(20px); animation: fadeInUp 0.6s ease forwards; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        .table-hover tbody tr:hover { background-color: #f8f9fa; }
    </style>
@endsection
