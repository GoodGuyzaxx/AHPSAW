@extends('layouts.admin')

{{-- @dd($criterias) --}}

@section('content')
    <div class="container-fluid px-4 border-bottom">
        <h1 class="mt-4 h2">{{ $title }}</h1>
    </div>

    <form class="col-lg-8 contianer-fluid px-4 mt-3" method="POST" action="{{ route('subkriteria.update', $criteria_sub->id) }}"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf

        {{-- kriteria --}}
        <div class="mb-3">
            <label for="criteria_id" class="form-label">Kriteria</label>
            <select class="form-select" name="criteria_id">
                <option value="" disabled selected>Pilih kriteria</option>
                @foreach ($criterias as $criteria)
                    @if (old('criteria_id', $criteria_sub->criteria_id) == $criteria->id)
                        <option value="{{ $criteria->id }}" selected>{{ $criteria->name }}</option>
                    @else
                        <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                    @endif
                @endforeach
            </select>

            @error('kelas_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- sub kriteria --}}
        <div class="mb-3">
            <label for="name_sub" class="form-label">Sub Kriteria</label>
            <input type="text" id="name_sub" name="name_sub"
                class="form-control @error('name_sub') is-invalid @enderror" id="name_sub"
                value="{{ old('name_sub', $criteria_sub->name_sub) }}" autofocus required>

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
                value="{{ old('value', $criteria_sub->value) }}" autofocus required>

            @error('value')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mb-3">Simpan Perubahan</button>
        <a href="{{ route('subkriteria.index') }}" class="btn btn-danger mb-3">Batal</a>
    </form>
@endsection
