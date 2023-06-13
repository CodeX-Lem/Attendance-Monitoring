<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance Tracker - @yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-body-secondary">
    <!-- SIDEBAR -->
    <div class="d-flex flex-column flex-shrink-0 overflow-y-auto sidebar">
        @include('trainor.partials._sidebar')
    </div>

    <!-- SIDEBAR CONTENT -->
    <div class="content d-flex flex-column">
        @include('trainor.partials._header')
        @yield('content')
        @include('trainor.partials._footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    @include('sweetalert::alert')
</body>

</html>