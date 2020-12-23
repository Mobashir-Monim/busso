<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard-style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css"/>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            
            <span class="navbar-brand col-md-3 col-lg-2 mr-0 px-3">
                <i class="fas fa-list text-white pr-3 d-md-none" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation"></i>
                <a href="{{ route('home') }}">BuSSO</a>
            </span>
            
            <ul class="navbar-nav pr-5 d-block py-1">
                <li class="nav-item float-right mx-2">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-primary nav-link px-2"><i class="fas fa-power-off text-white"></i></button>
                    </form>
                </li>
                {{-- <li class="nav-item float-right mx-2">
                    <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                </li> --}}
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                @include('layouts.nav.index')
                
                <main role="main" class="col-md-9 col-lg-10 ml-sm-auto px-md-4 pt-4" id="main">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    @yield('script')
</body>
</html>