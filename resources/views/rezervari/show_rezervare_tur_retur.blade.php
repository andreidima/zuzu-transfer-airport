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
                        @if (in_array($rezervare_tur->telefon, $telefoane_clienti_neseriosi))
                            <tr style="border-bottom:0px;">
                                <td class="text-danger">
                                    Persoana <b>{{ $rezervare_tur->nume }}</b> este în lista de neserioși
                                </td>
                            </tr>
                        @endif
                        <tr style="border-bottom:0px;">
                            <td>
                                Călător: <b>{{ $rezervare_tur->nume }}</b>
                            <br>
                                Telefon: <b>{{ $rezervare_tur->telefon }}</b>
                            <br>
                                E-mail: <b>{{ $rezervare_tur->email }}</b>
                            </td>
                        </tr>                       
                    </table>

                    <table class="table m-0" style="border:5px solid #efe3b1; border-bottom:0px; border-top:0px;">    
                        <tr style="text-align:center; font-weight:bold;">
                            <td colspan="5" style="padding:0rem;">
                                <h4 style="background-color:#e7d790; color:black; margin:0px 0px 2px 0px; padding:2px 0px">
                                Informații Rezervare bilet Tur
                                </h4>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td style="">
                                Imbarcare: 
                                <br>
                                @if (!empty($rezervare_tur->cursa->oras_plecare))
                                    @if ($rezervare_tur->cursa->oras_plecare->nume == "Otopeni")
                                        <span style="font-size:1.2rem; font-weight:bold;">
                                            Otopeni Aeroport
                                        </span>
                                    @else
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ $rezervare_tur->cursa->oras_plecare->nume }}
                                    </span>
                                    <br>
                                    <span style="font-size:1rem;">
                                        @if (!empty($rezervare_tur->statie))
                                            {{ $rezervare_tur->statie->nume }}
                                        @else
                                            {{ $rezervare_tur->statie_imbarcare }}
                                        @endif
                                    </span>
                                    @endif
                                @endif
                            </td>
                            <td style="">
                                Plecare:
                                <br>
                                @if (!empty($rezervare_tur->ora))
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ \Carbon\Carbon::parse($rezervare_tur->ora->ora)->format('H:i') }}
                                    </span>
                                @endif
                                <br>
                                
                                    <span style="font-size:1rem;">
                                        {{ \Carbon\Carbon::parse($rezervare_tur->data_cursa)->isoFormat('dddd') }}
                                    </span>
                                    <br>
                                    {{ \Carbon\Carbon::parse($rezervare_tur->data_cursa)->isoFormat('D MMM YYYY') }}
                            </td>
                            <td>
                                <br>
                                <img src="{{ asset('images/sageata.gif') }}" width="50px">
                            </td>
                            <td style="">
                                Debarcare:
                                <br>
                                @if (!empty($rezervare_tur->cursa->oras_sosire))
                                    @if ($rezervare_tur->cursa->oras_sosire->nume == "Otopeni")
                                        <span style="font-size:1.2rem; font-weight:bold;">
                                            Otopeni Aeroport
                                        </span>
                                    @else
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ $rezervare_tur->cursa->oras_sosire->nume }}
                                    </span>
                                    @endif
                                @endif
                            </td>
                            <td style="">
                                Sosire:
                                <br>
                                @if (!empty($rezervare_tur->ora->ora && $rezervare_tur->cursa->durata))
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ \Carbon\Carbon::parse($rezervare_tur->ora->ora)
                                            ->addHours(\Carbon\Carbon::parse($rezervare_tur->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare_tur->cursa->durata)->minute)
                                            ->format('H:i') }}   
                                    </span>                          
                                @endif
                                <br>
                                
                                    <span style="font-size:1rem;">
                                        {{ \Carbon\Carbon::parse($rezervare_tur->data_cursa)
                                            ->addHours(\Carbon\Carbon::parse($rezervare_tur->ora->ora)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare_tur->ora->ora)->minute) 
                                            ->addHours(\Carbon\Carbon::parse($rezervare_tur->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare_tur->cursa->durata)->minute)                               
                                            ->isoFormat('dddd') }}
                                    </span>
                                    <br>
                                        {{ \Carbon\Carbon::parse($rezervare_tur->data_cursa)
                                            ->addHours(\Carbon\Carbon::parse($rezervare_tur->ora->ora)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare_tur->ora->ora)->minute) 
                                            ->addHours(\Carbon\Carbon::parse($rezervare_tur->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare_tur->cursa->durata)->minute)
                                            ->isoFormat('D MMM YYYY') }}
                                <br>
                            </td>
                        </tr>
                    </table>
                              
                    <table class="table m-0 mb-2" style="border:5px solid #efe3b1;"> 
                        <tr>
                            <td>
                                Nr. persoane: <b>{{ $rezervare_tur->nr_adulti +  $rezervare_tur->nr_copii }}</b>
                            </td>
                            <td>                          
                                Total plata acum:
                                    <b>
                                    @if (($rezervare_tur->comision_agentie == 0) && ($rezervare_tur->tip_plata_id == 2))
                                        {{ $rezervare_tur->pret_total }}
                                    @else 
                                        {{ $rezervare_tur->comision_agentie - 0}}
                                    @endif
                                    </b>
                                    lei                                
                                <br>                                
                                Total plata la imbarcare:
                                    <b>
                                    @if (($rezervare_tur->comision_agentie == 0) && ($rezervare_tur->tip_plata_id == 2))
                                        0
                                    @else 
                                        {{ $rezervare_tur->pret_total - $rezervare_tur->comision_agentie }}
                                    @endif
                                    </b>
                                    lei
                            </td>
                        </tr>
                        <tr>
                            <td style="border:0px;">
                                Stație îmbarcare:
                                    @if (!empty($rezervare_tur->statie))
                                        <b>{{ $rezervare_tur->statie->nume }}</b>
                                    @endif
                                <br>
                                Detalii zbor:
                                    <b>
                                    {{ $rezervare_tur->zbor_ora_decolare }}
                                    -
                                    {{ $rezervare_tur->zbor_ora_aterizare }}
                                    /
                                    {{ $rezervare_tur->zbor_oras_decolare}}
                                    </b>
                            </td>
                            <td style="border:0px;">                    
                                @if (auth()->user()->isDispecer())
                                    <a class="btn btn-sm btn-primary mr-4" href="{{ $rezervare_tur->path() }}/modifica" role="button">Modifică Rezervarea</a>
                                @endif

                                <a href="{{ $rezervare_tur->path() }}/export/rezervare-pdf"
                                    title="Descarcă bilet"
                                    >
                                    <img src="{{ asset('images/download-flat.png') }}" height="50px">
                                </a>                            
                            </td>
                        </tr>
                    </table>

                    

                    <table class="table m-0" style="border:5px solid #efe3b1; border-bottom:0px; border-top:0px;">    
                        <tr style="text-align:center; font-weight:bold;">
                            <td colspan="5" style="padding:0rem;">
                                <h4 style="background-color:#e7d790; color:black; margin:0px 0px 2px 0px; padding:2px 0px">
                                Informații Rezervare bilet Retur
                                </h4>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td style="">
                                Imbarcare: 
                                <br>
                                @if (!empty($rezervare_retur->cursa->oras_plecare))
                                    @if ($rezervare_retur->cursa->oras_plecare->nume == "Otopeni")
                                        <span style="font-size:1.2rem; font-weight:bold;">
                                            Otopeni Aeroport
                                        </span>
                                    @else
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ $rezervare_retur->cursa->oras_plecare->nume }}
                                    </span>
                                    <br>
                                    <span style="font-size:1rem;">
                                        @if (!empty($rezervare_retur->statie))
                                            {{ $rezervare_retur->statie->nume }}
                                        @else
                                            {{ $rezervare_retur->statie_imbarcare }}
                                        @endif
                                    </span>
                                    @endif
                                @endif
                            </td>
                            <td style="">
                                Plecare:
                                <br>
                                @if (!empty($rezervare_retur->ora))
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ \Carbon\Carbon::parse($rezervare_retur->ora->ora)->format('H:i') }}
                                    </span>
                                @endif
                                <br>
                                
                                    <span style="font-size:1rem;">
                                        {{ \Carbon\Carbon::parse($rezervare_retur->data_cursa)->isoFormat('dddd') }}
                                    </span>
                                    <br>
                                    {{ \Carbon\Carbon::parse($rezervare_retur->data_cursa)->isoFormat('D MMM YYYY') }}
                            </td>
                            <td>
                                <br>
                                <img src="{{ asset('images/sageata.gif') }}" width="50px">
                            </td>
                            <td style="">
                                Debarcare:
                                <br>
                                @if (!empty($rezervare_retur->cursa->oras_sosire))
                                    @if ($rezervare_retur->cursa->oras_sosire->nume == "Otopeni")
                                        <span style="font-size:1.2rem; font-weight:bold;">
                                            Otopeni Aeroport
                                        </span>
                                    @else
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ $rezervare_retur->cursa->oras_sosire->nume }}
                                    </span>
                                    @endif
                                @endif
                            </td>
                            <td style="">
                                Sosire:
                                <br>
                                @if (!empty($rezervare_retur->ora->ora && $rezervare_retur->cursa->durata))
                                    <span style="font-size:1.2rem; font-weight:bold;">
                                        {{ \Carbon\Carbon::parse($rezervare_retur->ora->ora)
                                            ->addHours(\Carbon\Carbon::parse($rezervare_retur->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare_retur->cursa->durata)->minute)
                                            ->format('H:i') }}   
                                    </span>                          
                                @endif
                                <br>
                                
                                    <span style="font-size:1rem;">
                                        {{ \Carbon\Carbon::parse($rezervare_retur->data_cursa)
                                            ->addHours(\Carbon\Carbon::parse($rezervare_retur->ora->ora)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare_retur->ora->ora)->minute) 
                                            ->addHours(\Carbon\Carbon::parse($rezervare_retur->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare_retur->cursa->durata)->minute)                               
                                            ->isoFormat('dddd') }}
                                    </span>
                                    <br>
                                        {{ \Carbon\Carbon::parse($rezervare_retur->data_cursa)
                                            ->addHours(\Carbon\Carbon::parse($rezervare_retur->ora->ora)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare_retur->ora->ora)->minute) 
                                            ->addHours(\Carbon\Carbon::parse($rezervare_retur->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($rezervare_retur->cursa->durata)->minute)
                                            ->isoFormat('D MMM YYYY') }}
                                <br>
                            </td>
                        </tr>
                    </table>
                              
                    <table class="table m-0 mb-2" style="border:5px solid #efe3b1;"> 
                        <tr>
                            <td>
                                Nr. persoane: <b>{{ $rezervare_retur->nr_adulti +  $rezervare_retur->nr_copii }}</b>
                            </td>
                            <td>                          
                                Total plata acum:
                                    <b>
                                    @if (($rezervare_retur->comision_agentie == 0) && ($rezervare_retur->tip_plata_id == 2))
                                        {{ $rezervare_retur->pret_total }}
                                    @else 
                                        {{ $rezervare_retur->comision_agentie - 0}}
                                    @endif
                                    </b>
                                    lei                                
                                <br>                                
                                Total plata la imbarcare:
                                    <b>
                                    @if (($rezervare_retur->comision_agentie == 0) && ($rezervare_retur->tip_plata_id == 2))
                                        0
                                    @else 
                                        {{ $rezervare_retur->pret_total - $rezervare_retur->comision_agentie }}
                                    @endif
                                    </b>
                                    lei
                            </td>
                        </tr>
                        <tr>
                            <td style="border:0px;">
                                Stație îmbarcare:
                                    @if (!empty($rezervare_retur->statie))
                                        <b>{{ $rezervare_retur->statie->nume }}</b>
                                    @endif
                                <br>
                                Detalii zbor:
                                    <b>
                                    {{ $rezervare_retur->zbor_ora_decolare }}
                                    -
                                    {{ $rezervare_retur->zbor_ora_aterizare }}
                                    /
                                    {{ $rezervare_retur->zbor_oras_decolare}}
                                    </b>
                            </td>
                            <td style="border:0px;">                    
                                @if (auth()->user()->isDispecer())
                                    <a class="btn btn-sm btn-primary mr-4" href="{{ $rezervare_retur->path() }}/modifica" role="button">Modifică Rezervarea</a>
                                @endif

                                <a href="{{ $rezervare_retur->path() }}/export/rezervare-pdf"
                                    title="Descarcă bilet"
                                    >
                                    <img src="{{ asset('images/download-flat.png') }}" height="50px">
                                </a>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <a class="btn btn-sm btn-primary mr-2" href="/rezervari/adauga" role="button">Adaugă o nouă Rezervare</a>


                </div>
            </div>

        </div>

@endsection