@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Perbarui nilai kriteria untuk alternatif yang dipilih.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('alternatif.index') }}" class="text-decoration-none"><i class="fas fa-users me-1"></i>Data Alternatif</a>
                </li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-10 col-xl-8">
                <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
                    <div class="card-header bg-gradient-info text-white border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-2 me-3"><i class="fas fa-edit text-white"></i></div>
                            <div>
                                <h5 class="mb-0 fw-bold">Formulir Edit Alternatif</h5>
                                <small class="opacity-75">Sesuaikan nilai sub-kriteria di bawah ini</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('alternatif.update', $alternatives->id) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <fieldset disabled>
                                <h6 class="mb-3 fw-bold text-primary"><i class="fas fa-user-check me-2"></i>Informasi Mahasiswa</h6>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="form-label">Nama Mahasiswa</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="name" value="{{ $alternatives->name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <hr class="my-4">

                            <h6 class="mb-3 fw-bold text-primary"><i class="fas fa-tasks me-2"></i>Nilai Kriteria</h6>

                            {{-- Existing Criteria --}}
                            @foreach ($alternatives->alternatives as $value)
                                <div class="mb-3">
                                    <input type="hidden" name="criteria_id[]" value="{{ $value->criteria->id }}">
                                    <input type="hidden" name="alternative_id[]" value="{{ $value->id }}">
                                    <label for="{{ str_replace(' ', '', $value->criteria->name) }}" class="form-label fw-semibold">{{ $value->criteria->name }}</label>
                                    <select id="{{ str_replace(' ', '', $value->criteria->name) }}" class="form-select @error('alternative_value') is-invalid @enderror" name="alternative_value[]" required>
                                        <option disabled selected value="">--Pilih Opsi--</option>
                                        @foreach ($value->criteria->criteriaSubs as $sub)
                                            <option value="{{ $sub->id }}|{{ $sub->value }}" {{ $sub->id == $value->criteria_sub_id ? 'selected' : '' }}>
                                                {{ $sub->name_sub }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted mt-1 d-block">{{ $value->criteria->keterangan }}</small>
                                    @error('alternative_value')<div class="invalid-feedback mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                </div>
                            @endforeach

                            {{-- New Criteria --}}
                            @if ($newCriterias->count())
                                <h6 class="mt-4 mb-3 fw-bold text-warning"><i class="fas fa-plus-circle me-2"></i>Kriteria Baru (Wajib Diisi)</h6>
                                <input type="hidden" name="new_student_id" value="{{ $alternatives->student_id }}">
                                @foreach ($newCriterias as $value)
                                    <div class="mb-3">
                                        <input type="hidden" name="new_criteria_id[]" value="{{ $value->id }}">
                                        <label for="{{ str_replace(' ', '', $value->name) }}" class="form-label fw-semibold">{{ $value->name }}</label>
                                        <select id="{{ str_replace(' ', '', $value->name) }}" class="form-select @error('new_alternative_value') is-invalid @enderror" name="new_alternative_value[]" required>
                                            <option disabled selected value="">--Pilih Opsi--</option>
                                            @foreach ($value->criteriaSubs as $sub)
                                                <option value="{{ $sub->id }}|{{ $sub->value }}">{{ $sub->name_sub }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted mt-1 d-block">{{ $value->keterangan }}</small>
                                        @error('new_alternative_value')<div class="invalid-feedback mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                                    </div>
                        @endforeach
                        @endif
                    </div>

                    <div class="card-footer bg-light border-0 text-end p-3">
                        <a href="{{ route('alternatif.index') }}" class="btn btn-secondary me-2"><i class="fas fa-times me-2"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('partials.style-script')
@endsection
