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

    <!-- Font Awesome links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>
<body>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark py-0" style="background-color:#408080; font-size:1rem">
            <div class="container">
                @guest
                @else
                {{-- <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Zuzu') }}
                </a> --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @endguest

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto mr-4">
                        @guest
                        @else
                            <li class="nav-item active mr-4 btn-group">
                                <a class="nav-link pr-0 mr-1" href="/rezervari">
                                    <i class="fas fa-address-card mr-1"></i>Rezervări
                                </a>
                                @if ((auth()->user()->id == 355) || (auth()->user()->id == 356))
                                    {{-- <button class="btn dropdown-toggle dropdown-toggle-split p-0 text-white mr-auto" data-toggle="dropdown"></button> --}}
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item nav-link text-dark" href="{{ route('rezervari-istoric.index') }}">
                                            Rezervări istoric
                                        </a>
                                    </div>
                                @endif
                            </li>
                            {{-- <li class="nav-item active ml-auto mr-4 dropdown"> --}}
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
                                        @if ((auth()->user()->id == 355) || (auth()->user()->id == 356))
                                            <a class="dropdown-item" href="/rezervari/delete/mass-select">Ștergere rezervări</a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/sms-trimise">Sms trimise</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/statistica">Statistică</a>
                                    </div>
                                </li>
                            @endif
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
                            <li class="nav-item active mr-4 btn-group">
                                <a class="nav-link pr-0 mr-1" href="/instructiuni-rezervari">
                                    <i class="fas fa-chalkboard-teacher mr-1"></i>Instrucțiuni Rezervări
                                </a>
                                @if (auth()->user()->isDispecer())
                                    {{-- <button class="btn dropdown-toggle dropdown-toggle-split p-0 text-white" data-toggle="dropdown"></button> --}}
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item nav-link text-dark" href="{{ route('notificari.index') }}">
                                            <i class="fas fa-calendar-check mr-1"></i>Notificări
                                        </a>
                                    </div>
                                @endif
                            </li>
                            @if (auth()->user()->isDispecer())
                                <li class="nav-item active mr-4">
                                    <a class="nav-link" href="/clienti-neseriosi">
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

                                    @if (Auth::user()->id == 355)

                                        <form action='{{ url('users/loginas') }}' method='post'>
                                            @csrf

                                            <select class="form-control" name='user_id' onchange='this.form.submit()'>
                                                <option value="">Cont Agentie</option>
                                                @foreach (\App\User::select('id', 'user_firma_id', 'username')->with('firma:id,nume')->orderBy('username', 'asc')->get() as $row)
                                                    <option value='{{{ $row->id }}}'>{{ $row->username }} - {{ $row->firma->nume }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @endif

                                    @if (Session::get('hasClonedUser') == 355)
                                        <a class="dropdown-item" href="{{ route('loginas') }}"
                                            onclick="event.preventDefault(); document.getElementById('cloneuser-form').submit();"><span>Revenire la cont Dispecer</span></a>
                                        <form id="cloneuser-form" action="{{ url('users/loginas') }}" method="post">
                                            @csrf
                                        </form>

                                        <div class="dropdown-divider"></div>
                                    @endif


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

        <main class="container my-2 py-2" style="min-height:450px;">
            @include('notificari.afisare-notificari')
            @yield('content')
        </main>

        <footer class="container mb-2 pb-2">
            <div class="row mb-0">
                <div class="col-lg-4 my-1 py-1">
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
                <div class="col-lg-4 my-1 py-1">
                    <ul class="my-0" style="list-style-image: url({{ asset('images/arrow.gif') }});"><h5>Meniu</h5>
                        <li>
                            <a href="https://www.zuzu-transfer-aeroport.ro/" target="_blank"><b>Acasa</b></a>
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
                <div class="col-lg-4 my-1 py-1">
                    <h5>Contact</h5>
                    <b>Telefon Dispecerat:</b> +40 766 862 890
                    <br>
                    <span style="margin-left:154px;">+40 767 335 558</span>
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
