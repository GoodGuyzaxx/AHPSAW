<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="SPK Pemilihan Siswa Berprestasi" />
    <meta name="author" content="Malas Coding" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('frontend/images/logo.png') }}" />
    <title>SPK | {{ $title }}</title>

    {{-- style --}}
    @include('includes.admin.style')

</head>

<body class="bg-light">

{{-- Modern navbar --}}
@include('includes.admin.navbar')

{{-- Main content container --}}
<div class="main-wrapper">
    {{-- content --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- footer --}}
    @include('includes.admin.footer')
</div>

@include('includes.admin.script')

</body>

</html>
