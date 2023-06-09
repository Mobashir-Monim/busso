<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard-style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="icon" href="/img/EAuth.svg" type="image/gif" sizes="16x16" id="light-scheme-icon">
    <link rel="icon" href="/img/EAuth-white.svg" type="image/gif" sizes="16x16" id="dark-scheme-icon">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            
            <span class="navbar-brand col-md-3 col-lg-2 mr-0 px-3">
                {{-- <i class="fas fa-list text-white pr-3 d-md-none float-left align-middle" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation"></i> --}}
                <img src="/img/EAuth-white.svg" alt="EAuth" width="30" height="30" class="d-md-none align-middle" onclick="$('#sidebarMenu').collapse('toggle')" type="button">
                <a class="text-white d-md-none d-inline-block text-center ml-3" href="{{ route('home') }}">
                    BuSSO
                </a>
                <a class="text-white d-none d-md-block ml-2" href="{{ route('home') }}">
                    <img src="/img/EAuth-white.svg" alt="EAuth" width="30" height="30" class="d-inline-block align-middle">
                    <span class="d-inline-block ml-3">BuSSO</span>
                </a>
            </span>
            
            <ul class="navbar-nav pr-5 py-1 d-none d-md-block">
                <li class="nav-item float-right mx-2">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-primary nav-link px-2"><i class="fas fa-power-off text-white"></i></button>
                    </form>
                </li>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                @include('layouts.nav.index')
                <main role="main" class="col-md-9 col-lg-10 ml-sm-auto px-md-4 pt-4" id="main">
                    <div class="container">
                        @include('flash::message')
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>

    @yield('scripts')
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    
        const hideSideNav = () => {
            if (document.getElementById('sidebarMenu').classList.contains('show')) {
                // document.getElementById('sidebarMenu').classList.remove('show');
                $('#sidebarMenu').collapse();
            } else {
                
            }
        }
    </script>
</body>
</html>