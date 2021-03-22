@extends('layouts.app')

@section('content')

        @include ('errors')

        <div class="card-body p-0">
            <div class="form-row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <table class="table m-0" style="border:5px solid #efe3b1; border-bottom:0px">
                        <tr style="text-align:center; font-weight:bold;">
                            <td colspan="" style="border-width:0px; padding:0rem;">
                                <h4 style="background-color:#e7d790; color:black; margin:0px 0px 2px 0px; padding:2px 0px;">
                                Informații Călător
                                </h4>
                            </td>
                        </tr>
                        @if (in_array($rezervari->telefon, $telefoane_clienti_neseriosi))
                            <tr style="border-bottom:0px;">
                                <td class="text-danger">
                                    Persoana <b>{{ $rezervari->nume }}</b> este în lista de neserioși
                                </td>
                            </tr>
                        @endif
                        <tr style="border-bottom:0px;">
                            <td>
                                Călător: <b>{{ $rezervari->nume }}</b>
                            <br>
                                Telefon: <b>{{ $rezervari->telefon }}</b>
                            <br>
                                E-mail: <b>{{ $rezervari->email }}</b>
                            </td>
                        </tr>
                    </table>

                    <div class="p-0 text-center" style="border:5px solid #efe3b1; border-bottom:0px; border-top:0px;">
                            <h4 style="background-color:#e7d790; color:black; margin:0px 0px 2px 0px; padding:2px 0px">
                            Informații Rezervare bilet
                            </h4>
                    </div>

                    <div class="d-flex" style="border:5px solid #efe3b1; border-bottom:0px; border-top:0px;">
                        <div class="flex-fill">
                            Imbarcare:
                            <br>
                            @if (!empty($rezervari->cursa->oras_plecare))
                                @if ($rezervari->cursa->oras_plecare->nume == "Otopeni")
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        Otopeni Aeroport
                                    </span>
                                @else
                                <span style="font-size:1.2rem; font-weight:bold;">
                                    {{ $rezervari->cursa->oras_plecare->nume }}
                                </span>
                                @endif
                            @endif
                        </div>
                        <div class="flex-fill">
                            Plecare:
                            <br>
                            @if (!empty($rezervari->ora))
                                <span style="font-size:1.2rem; font-weight:bold;">
                                    {{ \Carbon\Carbon::parse($rezervari->ora->ora)->format('H:i') }}
                                </span>
                            @endif
                            <br>

                                <span style="font-size:1rem;">
                                    {{ \Carbon\Carbon::parse($rezervari->data_cursa)->isoFormat('dddd') }}
                                </span>
                                <br>
                                <b>
                                    {{ \Carbon\Carbon::parse($rezervari->data_cursa)->isoFormat('D MMM YYYY') }}
                                </b>
                        </div>
                        <div class="flex-fill">
                            <br>
                            <img src="{{ asset('images/sageata.gif') }}" width="50px">
                        </div>
                        <div class="flex-fill">
                            Debarcare:
                            <br>
                            @if (!empty($rezervari->cursa->oras_sosire))
                                @if ($rezervari->cursa->oras_sosire->nume == "Otopeni")
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        Otopeni Aeroport
                                    </span>
                                @else
                                <span style="font-size:1.2rem; font-weight:bold;">
                                    {{ $rezervari->cursa->oras_sosire->nume }}
                                </span>
                                @endif
                            @endif
                        </div>
                        <div class="flex-fill">
                            Sosire:
                            <br>
                            @if (!empty($rezervari->ora->ora && $rezervari->cursa->durata))
                                <span style="font-size:1.2rem; font-weight:bold;">
                                    {{ \Carbon\Carbon::parse($rezervari->ora->ora)
                                        ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                        ->format('H:i') }}
                                </span>
                            @endif
                            <br>

                                <span style="font-size:1rem;">
                                    {{ \Carbon\Carbon::parse($rezervari->data_cursa)
                                        ->addHours(\Carbon\Carbon::parse($rezervari->ora->ora)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervari->ora->ora)->minute)
                                        ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                        ->isoFormat('dddd') }}
                                </span>
                                <br>
                                    <b>
                                    {{ \Carbon\Carbon::parse($rezervari->data_cursa)
                                        ->addHours(\Carbon\Carbon::parse($rezervari->ora->ora)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervari->ora->ora)->minute)
                                        ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                        ->isoFormat('D MMM YYYY') }}
                                    </b>
                            <br>
                        </div>
                    </div>

                    {{-- <table class="table m-0" style="border:5px solid #efe3b1; border-bottom:0px; border-top:0px;">
                        <tr style="text-align:center; font-weight:bold;">
                            <td colspan="5" style="padding:0rem;">
                                <h4 style="background-color:#e7d790; color:black; margin:0px 0px 2px 0px; padding:2px 0px">
                                Informații Rezervare bilet
                                </h4>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td style="">
                                Imbarcare:
                                <br>
                                @if (!empty($rezervari->cursa->oras_plecare))
                                    @if ($rezervari->cursa->oras_plecare->nume == "Otopeni")
                                        <span style="font-size:1.2rem; font-weight:bold;">
                                            Otopeni Aeroport
                                        </span>
                                    @else
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ $rezervari->cursa->oras_plecare->nume }}
                                    </span>
                                    @endif
                                @endif
                            </td>
                            <td style="">
                                Plecare:
                                <br>
                                @if (!empty($rezervari->ora))
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ \Carbon\Carbon::parse($rezervari->ora->ora)->format('H:i') }}
                                    </span>
                                @endif
                                <br>

                                    <span style="font-size:1rem;">
                                        {{ \Carbon\Carbon::parse($rezervari->data_cursa)->isoFormat('dddd') }}
                                    </span>
                                    <br>
                                    {{ \Carbon\Carbon::parse($rezervari->data_cursa)->isoFormat('D MMM YYYY') }}
                            </td>
                            <td>
                                <br>
                                <img src="{{ asset('images/sageata.gif') }}" width="50px">
                            </td>
                            <td style="">
                                Debarcare:
                                <br>
                                @if (!empty($rezervari->cursa->oras_sosire))
                                    @if ($rezervari->cursa->oras_sosire->nume == "Otopeni")
                                        <span style="font-size:1.2rem; font-weight:bold;">
                                            Otopeni Aeroport
                                        </span>
                                    @else
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ $rezervari->cursa->oras_sosire->nume }}
                                    </span>
                                    @endif
                                @endif
                            </td>
                            <td style="">
                                Sosire:
                                <br>
                                @if (!empty($rezervari->ora->ora && $rezervari->cursa->durata))
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ \Carbon\Carbon::parse($rezervari->ora->ora)
                                            ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                            ->format('H:i') }}
                                    </span>
                                @endif
                                <br>

                                    <span style="font-size:1rem;">
                                        {{ \Carbon\Carbon::parse($rezervari->data_cursa)
                                            ->addHours(\Carbon\Carbon::parse($rezervari->ora->ora)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervari->ora->ora)->minute)
                                            ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                            ->isoFormat('dddd') }}
                                    </span>
                                    <br>
                                        {{ \Carbon\Carbon::parse($rezervari->data_cursa)
                                            ->addHours(\Carbon\Carbon::parse($rezervari->ora->ora)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervari->ora->ora)->minute)
                                            ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                            ->isoFormat('D MMM YYYY') }}
                                <br>
                            </td>
                        </tr>
                    </table> --}}

                    <table class="table m-0 mb-2" style="border:5px solid #efe3b1;">
                        <tr>
                            <td>
                                Nr. persoane: <b>{{ $rezervari->nr_adulti +  $rezervari->nr_copii }}</b>
                            </td>
                            <td>
                                Total plata acum:
                                    <b>
                                    @if (($rezervari->comision_agentie == 0) && ($rezervari->tip_plata_id == 2))
                                        {{ $rezervari->pret_total }}
                                    @else
                                        {{ $rezervari->comision_agentie - 0}}
                                    @endif
                                    </b>
                                    lei
                                <br>
                                Total plata la imbarcare:
                                    <b>
                                    @if (($rezervari->comision_agentie == 0) && ($rezervari->tip_plata_id == 2))
                                        0
                                    @else
                                        {{ $rezervari->pret_total - $rezervari->comision_agentie }}
                                    @endif
                                    </b>
                                    lei
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border:0px;">
                                Stație îmbarcare:
                                    @if (!empty($rezervari->statie))
                                        {{ $rezervari->statie->nume }}
                                    @else
                                        {{ $rezervari->statie_imbarcare }}
                                    @endif
                                <br>
                                Detalii zbor:
                                    <b>
                                    {{ $rezervari->zbor_ora_decolare }}
                                    -
                                    {{ $rezervari->zbor_ora_aterizare }}
                                    /
                                    {{ $rezervari->zbor_oras_decolare}}
                                    </b>
                            </td>
                        </tr>
                        {{-- <tr>
                            <td class="text-center">
                                <small>
                                    <p class="m-0">
                                        Prin finalizarea rezervării sunteți de acord cu <a href="https://www.zuzu-transfer-aeroport.ro/termeni-si-conditii/" target="_blank">termenii și condițiile</a> acestui site, precum și cu prelucrarea datelor cu caracter personal.
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
                            </td>
                        </tr> --}}
                    </table>

                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <a class="btn btn-sm btn-primary mr-2" href="/rezervari/adauga" role="button">Adaugă o nouă Rezervare</a>

                    @if (auth()->user()->isDispecer())
                        <a class="btn btn-sm btn-primary mr-4" href="{{ $rezervari->path() }}/modifica" role="button">Modifică Rezervarea</a>
                    @endif

                        <a href="{{ $rezervari->path() }}/export/rezervare-pdf"
                            title="Descarcă bilet"
                            >
                            <img src="{{ asset('images/download-flat.png') }}" height="50px">
                        </a>

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
