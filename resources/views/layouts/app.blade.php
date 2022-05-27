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
    <nav class="navba navbar-expand-lg justify-content-right">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="ml-auto mr-5 navbar-nav">
                @guest
                    <a class="nav-item nav-link" href="{{ route('login') }}">Login</a>
                @endguest
                @auth
                <a class="nav-item nav-link">{{ Auth::user()->name }}</a>
                    @if (auth()->user()->role == 0)
                        <a class="nav-item nav-link" href="{{ route('register') }}">Registra</a>
                        <a class="nav-item nav-link" href="{{ route('accoglienza') }}">Accoglienza</a>
                        <a class="nav-item nav-link" href="{{ route('scrutatore') }}">Scrutatori</a>
                    @elseif (auth()->user()->role == 1)
                        <a class="nav-item nav-link" href="{{ route('scrutatore') }}">Scrutatori</a>
                    @elseif (auth()->user()->role == 2)
                        <a class="nav-item nav-link" href="{{ route('accoglienza') }}">Accoglienza</a>
                    @endif
                        <form method="post" action="{{ route("logout") }}">
                            @csrf
                            <button type="submit" class="btn btn-link" value="logout">Logout</button>
                        </form>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')

    <script>
        //swal2 for success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: "{!! session('success') !!}",
                text: "{!! session('text') !!}",
                confirmButtonText: 'OK'
            })
        @endif

        //swal2 for error
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: "{!! session('error') !!}",
                text: "{!! session('text') !!}",
                confirmButtonText: 'OK'
            })
        @endif
    </script>
</body>

</html>
