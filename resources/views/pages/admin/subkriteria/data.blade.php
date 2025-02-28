@extends('layouts.admin')

@section('content')
    {{-- {{ print_r($criteria_subs) }} --}}
    <main>
        <div class="container-fluid px-4">
            <div class="row align-items-center">
                <div class="col-sm-6 col-md-8">
                    <h1 class="mt-4">{{ $title }}</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kriteria.index') }}">Data Kriteria</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>

            {{-- datatable --}}
            <div class="card mb-4">
                <div class="card-body table-responsive">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <a href="{{ route('subkriteria.create') }}" type="button" class="btn btn-primary mb-3"><i
                                class="fas fa-plus me-1"></i>Sub Kriteria
                        </a>
                    </div>

                    {{-- validation error file required --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- file request --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="d-sm-flex align-items-center mb-3">
                            <select class="form-select me-3" id="perPage" name="perPage" onchange="submitForm()">
                                @foreach ($perPageOptions as $option)
                                    <option value="{{ $option }}" {{ $option == $perPage ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="form-label col-lg-7 col-sm-7 col-md-7" for="perPage">entries per page</label>
                        </div>

                        <form action="{{ route('subkriteria.index') }}" method="GET" class="ms-auto float-end">
                            <div class="input-group mb-3">
                                <input type="text" name="search" id="myInput" class="form-control"
                                    placeholder="Search..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>

                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>Nama Kriteria</th>
                                <th>Sub Kriteria</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $previous_criteria_id = null;
                                $rowspan = 0;
                            @endphp
                            @forelse ($criteria_subs as $criteria_sub)
                                @if ($previous_criteria_id !== $criteria_sub->criteria_id)
                                    @if ($previous_criteria_id !== null)
                                        @php
                                            $rowspan--;
                                        @endphp
                                    @endif
                                    <tr>
                                        <td scope="row" rowspan="{{ $rowspan = $criteria_subs->where('criteria_id', $criteria_sub->criteria_id)->count() }}">
                                            {{ $criteria_sub->criteria->name ?? 'Tidak Punya Kriteria' }}
                                        </td>
                                        <td>{{ $criteria_sub->name_sub }}</td>
                                        <td>{{ $criteria_sub->value }}</td>
                                        <td>
                                            <a href="{{ route('subkriteria.edit', $criteria_sub->id) }}" class="badge bg-warning"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <form action="{{ route('subkriteria.destroy', $criteria_sub->id) }}" method="POST"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="badge bg-danger border-0 btnDelete" data-object="sub kriteria"><i
                                                        class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $criteria_sub->name_sub }}</td>
                                        <td>{{ $criteria_sub->value }}</td>
                                        <td>
                                            <a href="{{ route('subkriteria.edit', $criteria_sub->id) }}" class="badge bg-warning"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <form action="{{ route('subkriteria.destroy', $criteria_sub->id) }}" method="POST"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="badge bg-danger border-0 btnDelete" data-object="sub kriteria"><i
                                                        class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                                @php
                                    $previous_criteria_id = $criteria_sub->criteria_id;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="6" class="text-danger text-center p-4">
                                        <h4>Belum ada data</h4>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $criteria_subs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </main>

    <script>
        function submitForm() {
            var perPageSelect = document.getElementById('perPage');
            var perPageValue = perPageSelect.value;

            var currentPage = {{ $criteria_subs->currentPage() }};
            var url = new URL(window.location.href);
            var params = new URLSearchParams(url.search);

            params.set('perPage', perPageValue);

            if (!params.has('page')) {
                params.set('page', currentPage);
            }

            url.search = params.toString();
            window.location.href = url.toString();
        }
    </script>
@endsection
