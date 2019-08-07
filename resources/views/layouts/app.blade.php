<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <meta name="viewport" content="initial-scale=0.1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Zuzu') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Font Awesome links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark py-0" style="background-color:#408080; font-size:1rem">
            <div class="container">
                {{-- @guest
                @else
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Zuzu') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @endguest --}}

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto nav-fill mr-4">
                        @guest
                        @else
                            <li class="nav-item active mr-4">
                                <a class="nav-link" href="/rezervari">
                                    <i class="fas fa-address-card mr-1"></i>Rezervări
                                </a>
                            </li>
                            {{-- <li class="nav-link active ml-4">
                                <a class="text-primary" href="/curse">
                                    <i class="fas fa-car-side mr-1"></i>Curse
                                </a>
                            </li> --}}
                            @if (auth()->user()->isDispecer())
                                <li class="nav-item active mr-4 dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-book mr-1"></i>Raport
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/trasee">Raport Tur</a>
                                    <a class="dropdown-item" href="/trasee/retur">Raport Retur</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/rezervari-raport-zi">Raport / zi</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Statistică</a>
                                    </div>
                                </li>
                            @endif
                            {{-- <li class="nav-item active ml-4">
                                <a class="nav-link" href="/trasee">
                                    <i class="fas fa-route mr-1"></i>Trasee
                                </a>
                            </li> --}}
                            @if (auth()->user()->isDispecer())
                                <li class="nav-item active mr-4">
                                    <a class="nav-link" href="/agentii">
                                        <i class="fas fa-handshake mr-1"></i>Agenții
                                    </a>
                                </li>
                            @else
                                <li class="nav-item active mr-4">
                                    <a class="nav-link" href="/agentii/rezervari">
                                        <i class="fas fa-book mr-1"></i>Raport
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item active mr-4">
                                <a class="nav-link disabled" href="#">
                                    <i class="fas fa-chalkboard-teacher mr-1"></i>Instrucțiuni Rezervări
                                </a>
                            </li>
                            @if (auth()->user()->isDispecer())
                                <li class="nav-item active mr-4">
                                    <a class="nav-link disabled" href="#">
                                        <i class="fas fa-user-slash mr-1"></i>Clienți neserioși
                                    </a>
                                </li>
                            @endif
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item active dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firma->nume }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container my-4 py-4 bg-white" style="min-height:450px">
            @yield('content')
        </main>
        
        <footer class="container my-4 py-4 bg-white">
            <div class="row mb-0">
                <div class="col-4">
                    <ul class="my-0" style="list-style-image: url({{ asset('images/arrow.gif') }});"><h5>Informații</h5>
                        <li>
                            <a href="http://www.zuzu-transfer-aeroport.ro/contact/" target="_blank">Contact</a>
                        </li>
                        <li>
                            <a href="http://www.anpc.gov.ro/" target="_blank">ANPC - Protectia consumatorului</a>
                        </li>
                        <li>
                            Copyright © <a href="http://validsoftware.ro/" target="_blank"><b>validsoftware.ro</b></a>
                        </li>
                    </ul>
                </div>
                <div class="col-4">
                    <ul class="my-0" style="list-style-image: url({{ asset('images/arrow.gif') }});"><h5>Meniu</h5>
                        <li>
                            <a href="http://www.rezervari.zuzu-transfer-aeroport.ro/index.php/biletele_mele/redirect_agentie" target="_blank"><b>Acasa</b></a>
                        </li>
                        <li>
                            <a href="http://www.zuzu-transfer-aeroport.ro/rent-a-car/" target="_blank">Inchirieri autocare</a>
                        </li>
                        <li>
                            <a href="http://www.zuzu-transfer-aeroport.ro/termeni-si-conditii-2/" target="_blank">Termeni si conditii</a>
                        </li>
                        <li>
                            <a href="http://www.zuzu-transfer-aeroport.ro/politica-de-confidentialitate-a-datelor-cu-caracter-personal/" target="_blank">Politica de confidentialitate</a>
                        </li>
                        <li>
                            <a href="http://www.zuzu-transfer-aeroport.ro/cum-se-face-o-rezervare/" target="_blank">Cum se face o rezervare?</a>
                        </li>
                    </ul>                    
                </div>
                <div class="col-4">
                    <h5>Contact</h5>
                    <b>Telefon Dispecerat:</b> +40 748 836 345
                    <br>
                    <span style="margin-left:163px;">+40 766 862 890</span> 
                    <br>
                    <span style="margin-left:163px;">+40 767 335 558</span>
                    <br>
                    <b>E-mail:</b> carabus25@yahoo.com
                    <br>
                    <a href="https://www.facebook.com/ZuZu-Transfer-Aeroport-763182890435066/" target="_blank">
                        <img src="{{ asset('images/logo-facebook.png') }}" width="">
                    </a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
