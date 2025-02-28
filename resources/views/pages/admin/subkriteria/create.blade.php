@extends('layouts.admin')

{{-- @dd($criterias) --}}

@section('content')
    <div class="container-fluid px-4 border-bottom">
        <h1 class="mt-4 h2">{{ $title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{ $title }}</li>
            <li class="breadcrumb-item"><a href="{{ route('subkriteria.index') }}">Data Sub Kriteria</a></li>
        </ol>
    </div>

    <form class="col-lg-8 contianer-fluid px-4 mt-3" method="POST" action="{{ route('subkriteria.index') }}"
        enctype="multipart/form-data">
        @csrf

        {{-- kriteria --}}
        <div class="mb-3">
            <label for="criteria_id" class="form-label">Kriteria</label>
            <select class="form-select @error('criteria_id') is-invalid @enderror" id="criteria_id" name="criteria_id" required>
                <option value="" disabled selected>Pilih kriteria</option>
                @foreach ($criterias as $criteria)
                    @if (old('criteria_id') == $criteria->id)
                        <option value="{{ $criteria->id }}" selected>{{ $criteria->name }}</option>
                    @else
                        <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                    @endif
                @endforeach
            </select>

            @error('criteria_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Nama Sub Kriteria --}}
        <div class="mb-3">
            <label for="name_sub" class="form-label">Sub Kriteria</label>
            <input type="text" id="name_sub" name="name_sub"
                class="form-control @error('name_sub') is-invalid @enderror" id="name_sub" value="{{ old('name_sub') }}" autofocus
                required placeholder="Nama Sub Kriteria">

            @error('name_sub')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- nilai --}}
        <div class="mb-3">
            <label for="value" class="form-label">Nilai</label>
            <input type="number" class="form-control @error('value') is-invalid @enderror" id="value" name="value"
                value="{{ old('value') }}" autofocus required placeholder="Masukan Nilai">

            @error('value')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mb-3">Simpan</button>
        <a href="{{ route('subkriteria.index') }}" class="btn btn-danger mb-3">Cancel</a>
    </form>
@endsection
