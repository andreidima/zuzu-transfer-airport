@extends('layouts.app')

@section('content')
<div class="container p-0">
<div class="row justify-content-center">
    <div class="card col-lg-6 p-0 mb-4 " id="orase-ore-plecare">
        <div class="d-flex justify-content-between card-header text-white border border-dark" style="background-color:#2C7996;">
            <div class="flex flex-vertical-center">
                <h3 class="mt-2">
                    {{-- <a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a> - Adaugă o rezervare nouă --}}
                    Rezervare cursă
                </h3>
            </div>
            <div>
                {{-- <a class="btn btn-secondary" href="/rezervari" role="button">Renunță</a> --}}
                <h3 class="mt-2">
                    Zuzu Transfer Airport
                </h3>
            </div>
        </div>

        @include ('errors')

        <div class="card-body px-4 py-3 m-0 pb-4 border border-dark" style="background-color:#EF9A3E;">
            <div class="row mb-3 bg-white">

                <div class="col-lg-12 px-0" style="border:15px #2C7996 solid; ">
                    <h4 class="text-white text-center py-1" style="background-color:#2C7996;">Informații Călător</h4>
                    <div class="p-2">
                        Călător: <b>{{ $rezervare->nume }}</b>
                        <br>
                        Telefon: <b>{{ $rezervare->telefon }}</b>
                        <br>
                        E-mail: <b>{{ $rezervare->email }}</b>
                    </div>

                    <h4 class="text-white text-center py-1" style="background-color:#2C7996;">Informații Rezervare bilet</h4>

                    <div class="row p-2">
                        <div class="col mb-3">
                            Imbarcare:
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
                        </div>
                        <div class="col mb-3">
                            Plecare:
                            <br>
                            @if (!empty($rezervare->ora))
                                <span style="font-size:1.2rem; font-weight:bold;">
                                    {{ \Carbon\Carbon::parse($rezervare->ora->ora)->format('H:i') }}
                                </span>
                            @endif
                            <br>

                                <span style="font-size:1rem;">
                                    {{ \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('dddd') }}
                                </span>
                                <br>
                                <b>
                                    {{ \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('D MMM YYYY') }}
                                </b>
                        </div>
                        <div class="col mb-3">
                            <br>
                            <img src="{{ asset('images/sageata.gif') }}" width="50px">
                        </div>
                        <div class="col mb-3">
                            Debarcare:
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
                        </div>
                        <div class="col mb-3">
                            Sosire:
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
                                <br>
                                    <b>
                                    {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                        ->addHours(\Carbon\Carbon::parse($rezervare->ora->ora)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervare->ora->ora)->minute)
                                        ->addHours(\Carbon\Carbon::parse($rezervare->cursa->durata)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervare->cursa->durata)->minute)
                                        ->isoFormat('D MMM YYYY') }}
                                    </b>
                            <br>
                        </div>
                    </div>

                    <div class="p-2">
                        <hr class="" style="border:5px solid #2C7996;">

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
            </div>
            <div class="form-row">
                <div class="col-sm-12 d-flex justify-content-center">
                    <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-2">
                        @csrf
                        @if ($rezervare->plata_online == "1")
                            <button type="submit" class="btn btn-primary text-white border border-2 border-light mx-4" style="">Plătește rezervarea</button>
                        @else
                            <button type="submit" class="btn btn-primary text-white border border-2 border-light mx-4" style="">Salvează rezervarea</button>
                        @endif
                    </form>

                    <a class="btn btn-secondary border border-2 border-light" href="https://www.zuzu-transfer-airoport.ro/" role="button">Anulează rezervarea</a>

                </div>
            </div>
        </div>
    </div>

@endsection
