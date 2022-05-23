<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/app.css">
    <script src="js/app.js"></script>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <script>
        //swal2 for success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Hai votato!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            })
        @endif

        //swal2 for error
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Errore!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            })
        @endif
    </script>
</body>
</html>
