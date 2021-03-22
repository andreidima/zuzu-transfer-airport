@extends('layouts.app')

@section('content')

        @include ('errors')

        <div class="card-body p-0">
            <div class="form-row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <table class="table" style="border:5px solid #efe3b1;">
                        <tr style="text-align:center; font-weight:bold;">
                            <td colspan="" style="border-width:0px; padding:0rem;">
                                <h4 style="background-color:#e7d790; color:black; margin:0px 0px 2px 0px; padding:2px 0px;">
                                Informații Client
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Călător: <b>{{ $clienti_neseriosi->nume }}</b>
                            <br>
                                Telefon: <b>{{ $clienti_neseriosi->telefon }}</b>
                            <br>
                                Observații: <b>{{ $clienti_neseriosi->observatii }}</b>
                            </td>
                        </tr>
                    </table>

            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <a class="btn btn-sm btn-primary mr-2" href="/clienti-neseriosi/adauga" role="button">Adaugă un nou Client Neserios</a>
                    <a class="btn btn-sm btn-primary mr-4" href="{{ $clienti_neseriosi->path() }}/modifica" role="button">Modifică Client Neserios</a>

                </div>
            </div>

        </div>

@endsection





{{-- @extends('layouts.app')

@section('content')
    <div class="">

        <div class="">
            <div class="row justify-content-center">
                <div class="col-lg-7 bg-light border" style="word-break: break-word;">

                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ $rezervari->nume }}
                    <br>
                    {{ $rezervari->telefon }}
                    <hr class="">
                    <div class="row justify-content-between mb-3">
                        <div class="col-lg-6">
                            Imbarcare
                            <h5 class="d-inline">
                                <span class="badge badge-danger">
                                    @if(!empty($rezervari->cursa))
                                        {{ $rezervari->cursa->oras_plecare->nume }}
                                    @endif
                                </span>
                            </h5>
                            <br>
                            Debarcare
                            <h5 class="d-inline">
                                <span class="badge badge-danger">
                                    @if(!empty($rezervari->cursa))
                                        {{ $rezervari->cursa->oras_sosire->nume }}
                                    @endif
                                </span>
                            </h5>
                        </div>
                        <div class="col-lg-6 text-center">
                            Data:
                            <h5 class="d-inline">
                                <span class="badge badge-primary">
                                    @if(!empty($rezervari->ora_id))
                                        {{ \Carbon\Carbon::parse($rezervari->data_cursa)->format('d.m.Y') }}
                                    @endif
                                </span>
                            </h5>
                            <br>
                            Plecare
                            <h5 class="d-inline">
                                <span class="badge badge-primary">
                                    @if(!empty($rezervari->data_cursa))
                                        Ora: {{ \Carbon\Carbon::parse($rezervari->ora->ora)->format('H:i') }}
                                    @endif
                                </span>
                            </h5>
                        </div>
                    </div>

                    <div class="row justify-content-between">
                        <div class="col-lg-12">
                            Stație îmbarcare:
                            @if(!empty($rezervari->statie))
                                {{ $rezervari->statie->nume }}
                            @endif
                            {{ $rezervari->statie_imbarcare }}

                            <br>

                            Detalii zbor:
                            {{ $rezervari->zbor_ora_decolare }}
                            -
                            {{ $rezervari->zbor_ora_aterizare }}
                            /
                            {{ $rezervari->zbor_oras_decolare}}
                        </div>
                        <div class="col-lg-12">
                            <hr>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <h5 class="mb-0">
                            <small>Nr. persoane:</small>
                                <span class="badge badge-primary">
                                    {{ $rezervari->nr_adulti + $rezervari->nr_copii }}
                                </span>
                            </h5>
                        </div>

                        <div class="col-lg-6 text-right">
                            <h5 class="mb-0 mr-0">
                                <small>Total plata acum:</small>
                                <span class="badge badge-success">
                                    @if (($rezervari->comision_agentie == 0) && ($rezervari->tip_plata_id == 2))
                                        {{ $rezervari->pret_total }}
                                    @else
                                        {{ $rezervari->comision_agentie - 0}}
                                    @endif
                                    lei
                                </span>
                                <br>
                            </h5>
                            <h5 class="mb-0 mr-2">
                                <small>Total plata la imbarcare:</small>
                                <span class="badge badge-success">
                                    @if (($rezervari->comision_agentie == 0) && ($rezervari->tip_plata_id == 2))
                                        0
                                    @else
                                        {{ $rezervari->pret_total - $rezervari->comision_agentie }}
                                    @endif
                                    lei
                                </span>
                            </h5>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-10 text-center">
                            <hr>
                            <a class="btn btn-sm btn-primary mr-2" href="/rezervari/adauga" role="button">Adaugă o nouă Rezervare</a>


                                <a class="btn btn-sm btn-primary mr-4" href="{{ $rezervari->path() }}/modifica" role="button">Modifică Rezervarea</a>


                                <a href="{{ $rezervari->path() }}/export/rezervare-pdf"
                                    title="Descarcă bilet"
                                    >
                                    <img src="{{ asset('images/download-flat.png') }}" height="50px">
                                </a>

                            <hr>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <small>
                                <p class="m-0">
                                    Prin finalizarea rezervării sunteți de acord cu termenii și condițiile acestui site, precum și cu prelucrarea datelor cu caracter personal.
                                </p>
                                <span class="text-danger">
                                    Neanunțarea telefonică cu minim 12 ore înainte de îmbarcare poate duce la pierderea biletelor rezervate!
                                </span>
                                <br>
                                <p class="m-0">
                                    În funcție de numărul de pasageri circulă microbuz / autocar. Rezervarea este valabilă numai cu confirmarea agenției transportatoare.
                                    Detalii la +40 766 862 890, +40 767 335 558
                                </p>
                            </small>
                        </div>
                    </div>

                </div>

                </div>
            </div>
        </div>
    </div>

@endsection --}}
