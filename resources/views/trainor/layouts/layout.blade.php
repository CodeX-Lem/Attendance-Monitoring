<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance Tracker - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('icon.ico') }}" type="image/x-icon">
</head>

<body class="bg-body-secondary">
    <!-- SIDEBAR -->
    <div class="d-flex flex-column flex-shrink-0 overflow-y-auto sidebar">
        @include('trainor.partials._sidebar')
    </div>

    <!-- SIDEBAR CONTENT -->
    <div class="header px-3 d-flex align-items-center justify-content-end justify-content-sm-between">
        @include('trainor.partials._header')
    </div>

    <div class="p-3 pb-0 bg-white content">
        @yield('content')
    </div>

    <div class="d-flex align-items-center justify-content-center footer">
        @include('trainor.partials._footer')
    </div>
    <!-- SIDEBAR CONTENT -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    @include('sweetalert::alert')

    <script>
    function makeActive(row) {
        // Remove the active class from all rows
        var tableRows = Array.from(document.querySelectorAll('.row-item'));
        for (var i = 0; i < tableRows.length; i++) {
            tableRows[i].classList.remove('active');
        }

        // Add the active class to the clicked row
        row.classList.add('active');
    }
    </script>
</body>

</html>