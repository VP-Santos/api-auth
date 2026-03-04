<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    @yield('style')
</head>

<body>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('script')

</body>

</html>