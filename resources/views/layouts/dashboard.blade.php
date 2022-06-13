<html>

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/app.css">

</head>

<body>
    <div class="modal fade" id="Modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable  modal-xl">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <nav class="navba navbar-expand-lg justify-content-right">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="ml-auto mr-5 navbar-nav">
                <a class="nav-item nav-link">{{ Auth::user()->name }}</a>
                <a class="nav-item nav-link" href="{{ route('homepage') }}">Vota!</a>
                @if (auth()->user()->role == 0)
                    <a class="nav-item nav-link" href="{{ route('admin') }}">Amministratore</a>
                @endif @if (auth()->user()->role == 1 || auth()->user()->role == 0)
                    <a class="nav-item nav-link" href="{{ route('segretario') }}">Segretario</a>
                @endif @if (auth()->user()->role == 2 || auth()->user()->role == 0)
                    <a class="nav-item nav-link" href="{{ route('scrutatore') }}">Scrutatori</a>
                @endif
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link" value="logout">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    {{-- START TABS --}}
    @yield("Tabs")
    {{-- END TABS --}}
</body>
<footer>
    @yield('scripts')
    <script src="js/app.js"></script>
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
</footer>

</html>
