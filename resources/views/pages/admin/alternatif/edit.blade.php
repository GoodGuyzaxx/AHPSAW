@extends('layouts.admin')

@section('content')

    <div class="container-fluid px-4 border-bottom">
        <h1 class="mt-4 h2">{{ $title }}</h1>
    </div>
    <form class="col-lg-8 container-fluid px-4 mt-3" method="POST" action="{{ route('alternatif.update', $alternatives->id) }}">
        @method('PUT')
        @csrf

        <fieldset disabled>
            <div class="row">
                <div class="mb-3 col-lg-6">
                    <label for="name" class="form-label">Nama yang dipilih</label>
                    <input type="text" class="form-control" id="name" value="{{ old('name', $alternatives->name) }}" readonly required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-lg-6">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" class="form-control" id="kelas" value="{{ old('kelas', $alternatives->kelas->kelas_name) }}" readonly required>
                    @error('kelas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </fieldset>

        {{-- Existing criteria --}}
        @foreach ($alternatives->alternatives as $value)
            <div class="mb-3">
                <input type="hidden" name="criteria_id[]" value="{{ $value->criteria->id }}">
                <input type="hidden" name="alternative_id[]" value="{{ $value->id }}">

                <label for="{{ str_replace(' ', '', $value->criteria->name) }}" class="form-label">
                    <b> {{ $value->criteria->name }} </b>
                </label>
                <select id="{{ str_replace(' ', '', $value->criteria->name) }}"
                    class="form-select @error('alternative_value') 'is-invalid' : '' @enderror" name="alternative_value[]"
                    required>
                    <option disabled selected value="">--Pilih--</option>
                    @foreach ($value->criteria->criteriaSubs as $sub)
                        <option value="{{ $sub->id }}|{{ $sub->value }}" {{ $sub->id == $value->criteria_sub_id ? 'selected' : '' }}>
                            {{ $sub->name_sub }}
                        </option>
                    @endforeach
                </select>

                @error('alternative_value')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endforeach

        {{-- New criteria --}}
        @if ($newCriterias->count())
            <input type="hidden" name="new_student_id" value="{{ $alternatives->student_id }}">
            <input type="hidden" name="new_kelas_id" value="{{ $alternatives->kelas_id }}">
            @foreach ($newCriterias as $value)
                <div class="mb-3">
                    <input type="hidden" name="new_criteria_id[]" value="{{ $value->id }}">
                    <label for="{{ str_replace(' ', '', $value->name) }}" class="form-label">
                        Nilai <b> {{ $value->name }} </b>
                    </label>
                    <select id="{{ str_replace(' ', '', $value->name) }}"
                        class="form-select @error('new_alternative_value') 'is-invalid' : '' @enderror"
                        name="new_alternative_value[]" required>
                        <option disabled selected value="">--Pilih Nilai--</option>
                        @foreach ($value->criteriaSubs as $sub)
                            <option value="{{ $sub->id }}|{{ $sub->value }}">
                                {{ $sub->name_sub }} - {{ $sub->value }}
                            </option>
                        @endforeach
                    </select>

                    @error('new_alternative_value')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endforeach
        @endif

        <button type="submit" class="btn btn-primary mb-3">Simpan Perubahan</button>
        <a href="/dashboard/alternatif" class="btn btn-danger mb-3">Cancel</a>
    </form>
@endsection
