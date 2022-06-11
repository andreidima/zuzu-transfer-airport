@extends('layouts.app')

@section('content')

@section('content')
<div class="container p-0">
<div class="row justify-content-center">
    <div class="col-lg-6 p-0 mb-4">
    <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
        <div class="p-2 d-flex justify-content-between align-items-end"
            style="border-radius: 40px 40px 0px 0px; border:2px solid #2C7996">
            <div class="flex flex-vertical-center">
                <h3 class="mt-2" style="color:#2C7996">
                    {{-- <a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a> - Adaugă o rezervare nouă --}}
                    <i class="fas fa-ticket-alt fa-lg mx-1"></i>Verificare bilet călătorie</h3>
                </h3>
            </div>
            <div>
                {{-- <a class="btn btn-secondary" href="/rezervari" role="button">Renunță</a> --}}
                {{-- <h3 class="mt-2">
                    Zuzulica Trans
                </h3> --}}
                <img src="{{ asset('images/logo_alb.jpg') }}" height="70" class="mx-3 border border-light border-2">
            </div>
        </div>

        @include ('errors')

        <div class="py-4 px-5 border border-dark" style="background-color:#EF9A3E; border-radius: 0px 0px 40px 40px">
            <div class="row" style="background-color:#EF9A3E;">

                <div class="col-lg-12 border rounded" style="background-color:#2C7996;">
                    <h5 class="text-white p-1 m-0 text-center">
                        Informații călătorie
                    </h5>
                </div>

                <div class="col-lg-12 mb-4 px-0 text-white text-center border rounded" style="background-color:#2C7996;">
                    <div class="row">
                        <div class="col-lg-5 mb-0">
                            Plecare:
                            <br>
                            @if (!empty($rezervare->cursa->oras_plecare))
                                @if ($rezervare->cursa->oras_plecare->nume == "Otopeni")
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        Otopeni Aeroport
                                    </span>
                                @else
                                <span style="font-size:1.2rem; font-weight:bold;">
                                    {{ $rezervare->cursa->oras_plecare->nume }}
                                </span>
                                @endif
                            @endif
                            <br>
                            @if (!empty($rezervare->ora))
                                <span style="font-size:1.2rem; font-weight:bold;">
                                    {{ \Carbon\Carbon::parse($rezervare->ora->ora)->format('H:i') }}
                                </span>
                            @endif
                            <br>

                            {{ \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('dddd') }},
                            {{ \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('DD MMMM YYYY') }}
                        </div>
                        <div class="col-lg-2 mb-0">
                            <i class="fas fa-long-arrow-alt-right fa-6x"></i>
                        </div>
                        <div class="col-lg-5 mb-0 text-center">
                            Sosire:
                            <br>
                            @if (!empty($rezervare->cursa->oras_sosire))
                                @if ($rezervare->cursa->oras_sosire->nume == "Otopeni")
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        Otopeni Aeroport
                                    </span>
                                @else
                                <span style="font-size:1.2rem; font-weight:bold;">
                                    {{ $rezervare->cursa->oras_sosire->nume }}
                                </span>
                                @endif
                            @endif

                            <br>
                            @if (!empty($rezervare->ora->ora && $rezervare->cursa->durata))
                                <span style="font-size:1.2rem; font-weight:bold;">
                                    {{ \Carbon\Carbon::parse($rezervare->ora->ora)
                                        ->addHours(\Carbon\Carbon::parse($rezervare->cursa->durata)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervare->cursa->durata)->minute)
                                        ->format('H:i') }}
                                </span>
                            @endif
                            <br>
                                <span style="font-size:1rem;">
                                    {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                        ->addHours(\Carbon\Carbon::parse($rezervare->ora->ora)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervare->ora->ora)->minute)
                                        ->addHours(\Carbon\Carbon::parse($rezervare->cursa->durata)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervare->cursa->durata)->minute)
                                        ->isoFormat('dddd') }}
                                </span>
                                    {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                        ->addHours(\Carbon\Carbon::parse($rezervare->ora->ora)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervare->ora->ora)->minute)
                                        ->addHours(\Carbon\Carbon::parse($rezervare->cursa->durata)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervare->cursa->durata)->minute)
                                        ->isoFormat('D MMM YYYY') }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 border rounded" style="background-color:#2C7996;">
                    <h5 class="text-white p-1 m-0 text-center">
                        Informații pasageri
                    </h5>
                </div>

                <div class="col-lg-12 mb-4 p-2 text-white border rounded" style="background-color:#2C7996;">
                    Nume: <b>{{ $rezervare->nume }}</b>
                    <br>
                    Telefon: <b>{{ $rezervare->telefon }}</b>
                    <br>
                    E-mail: <b>{{ $rezervare->email }}</b>
                </div>

                <div class="col-lg-12 border rounded" style="background-color:#2C7996;">
                    <h5 class="text-white p-1 m-0 text-center">
                        Informații Rezervare bilet
                    </h5>
                </div>

                <div class="col-lg-12 mb-4 p-2 text-white border rounded" style="background-color:#2C7996;">
                    Nr. persoane: <b>{{ $rezervare->nr_adulti + $rezervare->nr_copii }}</b>
                    <br>
                    Total plata: <b>{{ $rezervare->pret_total }}</b> lei
                    <br>
                    Stație îmbarcare:
                        @if (!empty($rezervare->statie))
                            <b>{{ $rezervare->statie->nume }}</b>
                        @endif
                    <br>
                    Detalii zbor:
                        <b>
                        {{ $rezervare->zbor_ora_decolare }}
                        -
                        {{ $rezervare->zbor_ora_aterizare }}
                        /
                        {{ $rezervare->zbor_oras_decolare}}
                        </b>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12 d-flex justify-content-center">
                    <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-2">
                        @csrf
                        @if ($rezervare->plata_online == "1")
                            <button type="submit" class="btn btn-lg btn-primary text-white border border-2 border-light mx-4" style="">Plătește rezervarea</button>
                        @else
                            <button type="submit" class="btn btn-lg btn-primary text-white border border-2 border-light mx-4" style="">Salvează rezervarea</button>
                        @endif
                    </form>

                    <a class="btn btn-lg btn-secondary border border-2 border-light" href="https://www.zuzu-transfer-airport.ro/" role="button">Anulează rezervarea</a>

                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>


@endsection
