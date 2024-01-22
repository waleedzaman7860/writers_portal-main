<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>Home</title>
    {{-- <link rel="stylesheet" href="style.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css', 'resources/css/admin.css'])


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .swal2-icon.swal2-error {
            border-color: #d33;
            color: #d33;
        }
    </style>

</head>

<body>

    @if (url()->current() == route('dashboard'))
        <x-dashboardheader />
        @yield('content')
        <x-footer />
    @else
        <x-header />
        @yield('content')
        <x-footer />
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(".alert").show().delay(10000).queue(function(n) {
            $(this).hide();
            n();
        });
    </script>


</body>

</html>
