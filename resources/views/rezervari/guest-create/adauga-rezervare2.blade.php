@extends('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header mb-4">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2">
                    Rezervare cursă
                </h4>
            </div>
            <div>
                <h4 class="mt-2">                    
                    Zuzu Transfer Aeroport
                </h4>

            </div>
        </div>    

        <div class="card-body">
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
                        <tr style="border-bottom:0px;">
                            <td>
                                Călător: <b>{{ $rezervare->nume }}</b>
                            <br>
                                Telefon: <b>{{ $rezervare->telefon }}</b>
                            <br>
                                E-mail: <b>{{ $rezervare->email }}</b>
                            </td>
                        </tr>                       
                    </table>

                    <table class="table m-0" style="border:5px solid #efe3b1; border-bottom:0px; border-top:0px;">    
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
                                @if (!empty($rezervare->cursa->oras_plecare))
                                    @if ($rezervare->cursa->oras_plecare->nume == "Otopeni")
                                        <span style="font-size:1.2rem; font-weight:bold;">
                                            Otopeni Aeroport
                                        </span>
                                    @else
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ $rezervare->cursa->oras_plecare->nume }}
                                    </span>
                                    <br>
                                    <span style="font-size:1rem;">
                                        @if (!empty($rezervare->statie))
                                            {{ $rezervare->statie->nume }}
                                        @else
                                            {{ $rezervare->statie_imbarcare }}
                                        @endif
                                    </span>
                                    @endif
                                @endif
                            </td>
                            <td style="">
                                Plecare:
                                <br>
                                @if (!empty($rezervare->ora))
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ \Carbon\Carbon::parse($rezervare->ora->ora)->format('H:i') }}
                                    </span>
                                @endif
                                <br>
                                {{-- @if (!empty(auth()->user())) --}}
                                    <span style="font-size:1rem;">
                                        {{ \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('dddd') }}
                                    </span>
                                    <br>
                                    {{ \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('D MMM YYYY') }}
                            </td>
                            <td>
                                <br>
                                <img src="{{ asset('images/sageata.gif') }}" width="50px">
                            </td>
                            <td style="">
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
                            </td>
                            <td style="">
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
                                {{-- @if (!empty(auth()->user())) --}}
                                    <span style="font-size:1rem;">
                                        {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                            ->addHours(\Carbon\Carbon::parse($rezervare->ora->ora)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare->ora->ora)->minute) 
                                            ->addHours(\Carbon\Carbon::parse($rezervare->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare->cursa->durata)->minute)                               
                                            ->isoFormat('dddd') }}
                                    </span>
                                    <br>
                                        {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                            ->addHours(\Carbon\Carbon::parse($rezervare->ora->ora)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare->ora->ora)->minute) 
                                            ->addHours(\Carbon\Carbon::parse($rezervare->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare->cursa->durata)->minute)
                                            ->isoFormat('D MMM YYYY') }}
                                <br>
                            </td>
                        </tr>
                    </table>
                              
                    <table class="table m-0 mb-2" style="border:5px solid #efe3b1;"> 
                        <tr>
                            <td>
                                Nr. persoane: <b>{{ $rezervare->nr_adulti +  $rezervare->nr_copii }}</b>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Total plata: <b>{{ $rezervare->pret_total }}</b>
                                <br>
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
                            </td>
                        </tr>
                        <tr>
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
                                        Detalii la +40 786 574 788, +40 748 836 345, +40 766 862 890
                                    </p>
                                </small>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12 d-flex justify-content-center">  
                    <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-2">
                        @csrf                                                 
                        @if ($rezervare->plata_online == "true")
                            <button type="submit" class="btn btn-primary mr-4" style="">Plătește rezervarea</button>
                        @else
                            <button type="submit" class="btn btn-primary mr-4" style="">Salvează rezervarea</button> 
                        @endif
                    </form>
                    
                    <a class="btn btn-secondary" href="https://www.zuzu-transfer-aeroport.ro/" role="button">Anulează rezervarea</a>

                </div>
            </div>
        </div>
    </div>

@endsection