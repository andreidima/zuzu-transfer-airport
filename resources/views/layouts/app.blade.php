<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/andrei.css') }}" rel="stylesheet">

    <!-- Font Awesome links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>
<body style="background-color:#d9eff7">
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#2C7996; font-size:1rem">
            <div class="container">
                @guest
                @else
                {{-- <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Zuzu') }}
                </a> --}}
                {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @endguest

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto mr-4">
                        @guest
                        @else
                            <li class="nav-item mx-2">
                                <a class="nav-link active" href="/rezervari">
                                    <i class="fas fa-address-card mx-1"></i>Rezervări
                                </a>
                                {{-- @if ((auth()->user()->id == 1) || (auth()->user()->id == 1))
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item nav-link text-dark" href="{{ route('rezervari-istoric.index') }}">
                                            Rezervări istoric
                                        </a>
                                    </div>
                                @endif --}}
                            </li>
                            {{-- <li class="nav-item active ml-auto mr-4 dropdown"> --}}
                            @if (auth()->user()->isDispecer())
                                <li class="nav-item dropdown mx-2">
                                    <a class="nav-link active dropdown-toggle" href="#" id="raport" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-book mx-1"></i>Raport
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="raport">
                                        <li><a class="dropdown-item" href="/trasee">Raport Tur</a></li>
                                        <li><a class="dropdown-item" href="/trasee/retur">Raport Retur</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="/rezervari-raport-zi">Raport / zi</a></li>
                                        @if ((auth()->user()->id == 1) || (auth()->user()->id == 1))
                                            <li><a class="dropdown-item" href="/rezervari/delete/mass-select">Ștergere rezervări</a></li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="/sms-trimise">Sms trimise</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="/statistica">Statistică</a></li>
                                    </ul>
                                </li>
                            @endif
                            @if (auth()->user()->isDispecer())
                                <li class="nav-item mx-2">
                                    <a class="nav-link active" href="/agentii">
                                        <i class="fas fa-handshake mx-1"></i>Agenții
                                    </a>
                                </li>
                            @else
                                <li class="nav-item mx-2">
                                    <a class="nav-link active" href="/agentii/rezervari">
                                        <i class="fas fa-book mx-1"></i>Raport
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item mx-2">
                                <a class="nav-link active" href="/instructiuni-rezervari">
                                    <i class="fas fa-chalkboard-teacher mx-1"></i>Instrucțiuni Rezervări
                                </a>
                            </li>
                            @if (auth()->user()->isDispecer())
                                <li class="nav-item dropdown mx-2">
                                    <a class="nav-link active dropdown-toggle" href="#" id="utile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-book mx-1"></i>Utile
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="utile">
                                        <li><a class="dropdown-item" href="{{ route('notificari.index') }}">Notificări</a></li>
                                        <li><a class="dropdown-item" href="/clienti-neseriosi">Clienți neserioși</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('masini.index') }}"><i class="fas fa-bus mx-1"></i>Mașini</a></li>
                                        <li><a class="dropdown-item" href="{{ route('soferi.index') }}"><i class="fas fa-users mx-1"></i>Șoferi</a></li>
                                    </ul>
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
                            <li class="nav-item dropdown mx-2">
                                <a class="nav-link active dropdown-toggle" href="#" id="utile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->firma->nume }}
                                </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                        </li>
                                    </ul>


                                    {{-- <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a> --}}

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

        <main class="container my-2 py-2" style="min-height:450px;">
            @include('notificari.afisare-notificari')
            @yield('content')
        </main>

        <footer class="container mb-2 pb-2 shadow" style="background-color:#faf7e7">
            <div class="row mb-0">
                <div class="col-lg-4 my-1 py-1">
                    <ul class="my-0" style=""><h5>Informații</h5>
                        <li>
                            <a href="https://www.zuzulicatrans.ro/contact/" target="_blank">Contact</a>
                        </li>
                        <li>
                            <a href="http://www.anpc.gov.ro/" target="_blank">ANPC - Protecția consumatorului</a>
                        </li>
                        <li>
                            Copyright © <a href="http://validsoftware.ro/" target="_blank"><b>validsoftware.ro</b></a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 my-1 py-1">
                    <ul class="my-0" style="list-style-image: url({{ asset('images/arrow.gif') }});"><h5>Meniu</h5>
                        <li>
                            <a href="https://www.zuzulicatrans.ro/" target="_blank"><b>Acasă</b></a>
                        </li>
                        <li>
                            <a href="/termeni-si-conditii" target="_blank">Termeni și condiții</a>
                        </li>
                        <li>
                            <a href="/termeni-si-conditii#politica-de-confidentialitate" target="_blank">Politica de confidențialitate</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 my-1 py-1">
                    <h5>Contact</h5>
                    <b>Telefon Dispecerat:</b> +40 0768 112 244
                    <br>
                    <span style="margin-left:154px;">+40 0768 112 255</span>
                    <br>
                    <span style="margin-left:154px;">+40 0768 112 288</span>
                    <br>
                    <b>E-mail:</b> rezervari@zuzulicatrans.ro
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
