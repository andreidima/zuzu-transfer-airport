@extends('layouts.app')

@section('content')
<div class="container p-0">
<div class="row justify-content-center">
    <div class="col-lg-6 p-0 mb-4">
    <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
        <div class="p-2 d-flex justify-content-between align-items-end"
            style="border-radius: 40px 40px 0px 0px; border:2px solid #2C7996">
            <div class="flex flex-vertical-center">
                <h3 class="mt-2" style="color:#2C7996">
                    <i class="fas fa-ticket-alt fa-lg mx-1"></i>Rezervare finalizată</h3>
                </h3>
            </div>
            <div>
                <img src="{{ asset('images/logo_alb.jpg') }}" height="70" class="mx-3 border border-light border-2">
            </div>
        </div>

        @include ('errors')

        <div class="py-4 px-5 border border-dark" style="background-color:#EF9A3E; border-radius: 0px 0px 40px 40px">
            <div class="row" style="background-color:#EF9A3E;">

                <div class="col-lg-12 border rounded" style="background-color:#2C7996;">
                    <h5 class="text-white p-1 m-0 text-center">
                        Rezervarea a fost înregistrată cu codul RO{{ $rezervare->id }}
                    </h5>
                    @isset($plata_online)
                        <br>
                        @if ($plata_online->error_code == 0 )
                            Plata rezervării s-a efectuat cu succes!
                        @else
                            Plata rezervării nu s-a efectuat cu succes!
                            <br>
                            Aveți posibilitatea să faceți plata la șofer.
                        @endif
                        <br>
                        {{-- <br>
                        Starea plății pentru această rezervare este: {{ $plata_online->error_message }}
                        <br> --}}
                    @endisset
                </div>

                <div class="col-lg-12 py-4 rounded border bg-white text-center">
                    <a href="/bilet-rezervat"
                        class="btn btn-success text-white"
                        role="button"
                        target="_blank"
                        title="Descarcă bilet"
                        >
                        <h5 class="p-0 m-0">Descărcați și tipăriți biletul de rezervare</h5>
                    </a>
                </div>

                <div class="col-lg-12 p-4 rounded border bg-white">
                    Pentru orice detalii legate de această rezervare, ne puteți contacta la:
                    <ul>
                        <li>
                            Telefon: 0768 112 244 / 0768 112 255 / 0768 112 288
                        </li>
                        <li>
                            Email: <a href="mailto:rezervari@zuzu-transfer-airport.ro">rezervari@zuzu-transfer-airport.ro</a>
                        </li>
                    </ul>

                    <div class="text-center">
                        <a href="https://www.zuzu-transfer-airport.ro/"
                            class="btn btn-primary text-white"
                            role="button"
                            >
                            INAPOI LA PAGINA PRINCIPALĂ
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
