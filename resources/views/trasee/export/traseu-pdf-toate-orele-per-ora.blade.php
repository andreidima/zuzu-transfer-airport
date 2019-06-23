<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Raport</title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif !important; 
            font-size: 14px;
        }

        * {
            /* padding: 0;
            text-indent: 0; */
        }

        table{
            border-collapse:collapse;
            /* margin: 0px 0px; */
            /* margin-left: 5px; */
            margin-top: 0px;
            border-style: solid;
            border-width:0px;
            width: 100%;
        }
        
        th, td {
            padding: 1px 1px;
            border-width:1px;
            border-style: solid;
            
        }
        tr {
            /* text-align:; */
            /* border-style: solid;
            border-width:1px; */
        }
        hr { 
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 0.5px;
        } 
    </style>
</head>

<body>
    @switch($trasee_nume->id)
        @case(1)    
            @forelse ($trasee_nume->trasee as $traseu)     
                @if ($traseu->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->count() > 0)          
                    <div style="border:dashed #999;
                        width:690px; 
                        min-height:600px;            
                        padding: 15px 10px 15px 10px;
                        margin:0px 0px;
                            -moz-border-radius: 10px;
                            -webkit-border-radius: 10px;
                            border-radius: 10px;">
                        <table style="">
                            <tr style="">
                                <td style="border-width:0px; padding:0rem; width:40%">
                                        <img src="{{ asset('images/logo-zuzu.png') }}" width="250px">
                                </td>
                                <td style="border-width:0px; padding:0rem; width:60%; text-align:center; font-size:16px">
                                    Tip traseu: TUR
                                    <br>
                                    Pentru data: {{ $data_traseu }}
                                    <br>
                                    @forelse ($traseu->curse_ore as $cursa_ora)
                                        @if ($cursa_ora->cursa->oras_plecare->nume == "Adjud")
                                            ADJ:
                                        @elseif ($cursa_ora->cursa->oras_plecare->nume == "Panciu")
                                            PAN:
                                        @elseif ($cursa_ora->cursa->oras_plecare->nume == "Tecuci")
                                            TC:
                                        @elseif ($cursa_ora->cursa->oras_plecare->nume == "Marasesti")
                                            MAR:
                                        @elseif ($cursa_ora->cursa->oras_plecare->nume == "Focsani")
                                            FCS:
                                        @elseif ($cursa_ora->cursa->oras_plecare->nume == "Ramnicu Sarat")
                                            RM:
                                        @elseif ($cursa_ora->cursa->oras_plecare->nume == "Buzau")
                                            BZ:
                                        @endif
                                        @if($loop->last)
                                            {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                        @else($loop->last)
                                            {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}},
                                        @endif
                                    @empty
                                    @endforelse
                                </td>
                            </tr>
                        </table>

                        <br><br><br>

                        <p style="margin: 0 0 0 0px;">
                            Nume sofer ......................................................................................................
                            Nr. masina ......................................................
                        </p>

                        <br>
                        
                        <table style="">
                            <tr style="background-color:#e7d790">
                                <td>Nr. crt.</td>
                                <td>Nume si prenume</td>
                                <td>Telefon</td>
                                <td>Plecare</td>
                                <td>Statie imbarcare</td>
                                <td>Ora decolare</td>
                                <td>Observatii</td>
                                <td>Suma</td>
                                <td>Plata</td>
                                <td>Nr. pers.</td>
                            </tr>
                            @php 
                                ($nrcrt = 1) 
                            @endphp
                            @forelse ($traseu->curse_ore as $cursa_ora)
                                @forelse ($cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1) as $rezervare)
                                    <tr>
                                        <td>
                                            {{ $nrcrt++ }}
                                        </td>
                                        <td>
                                            {{ $rezervare->nume }}
                                        </td>
                                        <td>
                                            {{ $rezervare->telefon }}
                                        </td>
                                        <td>
                                            {{$cursa_ora->cursa->oras_plecare->nume}}
                                        </td>
                                        <td>
                                            @if(!empty($rezervare->statie))
                                                {{ $rezervare->statie->nume }}
                                            @elseif(!empty($rezervare->statie_imbarcare))
                                                {{ $rezervare->statie_imbarcare }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{ $rezervare->zbor_ora_decolare}}
                                        </td>
                                        <td>
                                            @if (empty($rezervare->user))
                                                <span style="color:#3672ED; font-size:2rem; margin:0px; padding:0px;">
                                                    C
                                                </span>
                                            @elseif ($rezervare->user->firma->id == 1) 
                                                <span style="color:#ed8336; font-size:2rem;">
                                                    D
                                                </span>  
                                            @else 
                                                {{ $rezervare->user->firma->nume }}                               
                                            @endif
                                        </td>
                                        <td>
                                            {{ $rezervare->pret_total - $rezervare->comision_agentie - $rezervare->plata_avans }} lei
                                        </td>
                                        <td>
                                            @if ($rezervare->tip_plata->nume == "Sofer")
                                                S
                                            @else
                                                {{ $rezervare->tip_plata->nume }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $rezervare->nr_adulti + $rezervare->nr_copii}}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            @empty
                            @endforelse
                        
                            @php
                                $nr_persoane = 0;
                                $suma = 0;    
                            @endphp

                            @forelse ($traseu->curse_ore as $cursa_ora)
                                @php
                                    $nr_persoane = $nr_persoane +
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_adulti') +
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_copii');     
                                    $suma = $suma + $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('pret_total') -
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('comision_agentie');
                                @endphp
                            @empty
                            @endforelse

                            <tr>
                                <td colspan="7" style="text-align:right;">
                                    Total:
                                </td>
                                <td>
                                    {{ $suma }} lei
                                </td>
                                <td>
                                    Nr. pers.
                                </td>
                                <td>
                                    {{ $nr_persoane }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    @if ($loop->last)
                    @else
                        <div style="page-break-after: always;"></div>
                    @endif
                @endif
            @empty
            @endforelse

            @break
        @case(2)
            @forelse ($curse_ore as $ora => $curse_per_ora)     
                    <div style="border:dashed #999;
                        width:690px; 
                        min-height:600px;            
                        padding: 15px 10px 15px 10px;
                        margin:0px 0px;
                            -moz-border-radius: 10px;
                            -webkit-border-radius: 10px;
                            border-radius: 10px;">
                        <table style="">
                            <tr style="">
                                <td style="border-width:0px; padding:0rem; width:40%">
                                        <img src="{{ asset('images/logo-zuzu.png') }}" width="250px">
                                </td>
                                <td style="border-width:0px; padding:0rem; width:60%; text-align:center; font-size:16px">
                                    Tip traseu: RETUR
                                    <br>
                                    Pentru data: {{ $data_traseu }}
                                    <br>
                                    ora: {{\Carbon\Carbon::parse($curse_per_ora->first()->ora)->format('H:i')}}
                                </td>
                            </tr>
                        </table>

                        <br><br><br>

                        <p style="margin: 0 0 0 0px;">
                            Nume sofer ......................................................................................................
                            Nr. masina ......................................................
                        </p>

                        <br>
                        
                        <table style="">
                            <tr style="background-color:#e7d790">
                                <td>Nr. crt.</td>
                                <td>Nume si prenume</td>
                                <td>Telefon</td>
                                <td>Sosire</td>
                                <td>Ora aterizarii</td>
                                <td>Aterizare</td>
                                <td>Statie imbarcare</td>
                                <td>Observatii</td>
                                <td>Suma</td>
                                <td>Plata</td>
                                <td>Nr. pers.</td>
                            </tr>
                            @php 
                                ($nrcrt = 1) 
                            @endphp
                            @forelse ($curse_per_ora as $cursa_ora)
                                @forelse ($cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1) as $rezervare)
                                    <tr>
                                        <td>
                                            {{ $nrcrt++ }}
                                        </td>
                                        <td>
                                            {{ $rezervare->nume }}
                                        </td>
                                        <td>
                                            {{ $rezervare->telefon }}
                                        </td>
                                        <td>
                                            {{$cursa_ora->cursa->oras_sosire->nume}}
                                        </td>
                                        <td>
                                            {{ $rezervare->zbor_ora_aterizare}}
                                        </td>
                                        <td>
                                            {{ $rezervare->zbor_oras_decolare}}
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            @if (empty($rezervare->user))
                                                <span style="color:#3672ED; font-size:2rem; margin:0px; padding:0px;">
                                                    C
                                                </span>
                                            @elseif ($rezervare->user->firma->id == 1) 
                                                <span style="color:#ed8336; font-size:2rem;">
                                                    D
                                                </span>  
                                            @else 
                                                {{ $rezervare->user->firma->nume }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $rezervare->pret_total - $rezervare->comision_agentie - $rezervare->plata_avans }} lei
                                        </td>
                                        <td>
                                            @if ($rezervare->tip_plata->nume == "Sofer")
                                                S
                                            @else
                                                {{ $rezervare->tip_plata->nume }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $rezervare->nr_adulti + $rezervare->nr_copii}}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            @empty
                            @endforelse
                        
                            @php
                                $nr_persoane = 0;
                                $suma = 0;    
                            @endphp

                            @forelse ($curse_per_ora as $cursa_ora)
                                @php
                                    $nr_persoane = $nr_persoane +
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_adulti') +
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_copii');     
                                    $suma = $suma + $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('pret_total') -
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('comision_agentie');
                                @endphp
                            @empty
                            @endforelse

                            <tr>
                                <td colspan="9" style="text-align:right; padding-right:5px;">
                                    Total plata: {{ $suma }} lei
                                </td>
                                <td>
                                    Nr. pers.
                                </td>
                                <td>
                                    {{ $nr_persoane }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    @if ($loop->last)
                    @else
                        <div style="page-break-after: always;"></div>
                    @endif
            @empty
            @endforelse

            @break
        @case(3)   
            @forelse ($trasee_nume->trasee as $traseu) 
                @if ($traseu->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->count() > 0)               
                    <div style="border:dashed #999;
                        width:690px; 
                        min-height:600px;            
                        padding: 15px 10px 15px 10px;
                        margin:0px 0px;
                            -moz-border-radius: 10px;
                            -webkit-border-radius: 10px;
                            border-radius: 10px;">
                        <table style="">
                            <tr style="">
                                <td style="border-width:0px; padding:0rem; width:40%">
                                        <img src="{{ asset('images/logo-zuzu.png') }}" width="250px">
                                </td>
                                <td style="border-width:0px; padding:0rem; width:60%; text-align:center; font-size:16px">
                                    Tip traseu: TUR
                                    <br>
                                    Pentru data: {{ $data_traseu }}
                                    <br>
                                    @forelse ($traseu->curse_ore as $cursa_ora)
                                        @if ($cursa_ora->cursa->oras_plecare->nume == "Galati")
                                            GL:
                                        @elseif ($cursa_ora->cursa->oras_plecare->nume == "Braila")
                                            BR:
                                        @elseif ($cursa_ora->cursa->oras_plecare->nume == "Ianca")
                                            IAN:
                                        @elseif ($cursa_ora->cursa->oras_plecare->nume == "Buzau")
                                            BZ:
                                        @endif
                                        @if($loop->last)
                                            {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                        @else($loop->last)
                                            {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}},
                                        @endif
                                    @empty
                                    @endforelse
                                </td>
                            </tr>
                        </table>

                        <br><br><br>

                        <p style="margin: 0 0 0 0px;">
                            Nume sofer ......................................................................................................
                            Nr. masina ......................................................
                        </p>

                        <br>
                        
                        <table style="">
                            <tr style="background-color:#e7d790">
                                <td>Nr. crt.</td>
                                <td>Nume si prenume</td>
                                <td>Telefon</td>
                                <td>Plecare</td>
                                <td>Statie imbarcare</td>
                                <td>Ora decolare</td>
                                <td>Observatii</td>
                                <td>Suma</td>
                                <td>Plata</td>
                                <td>Nr. pers.</td>
                            </tr>
                            @php 
                                ($nrcrt = 1) 
                            @endphp
                            @forelse ($traseu->curse_ore as $cursa_ora)
                                @forelse ($cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1) as $rezervare)
                                    <tr>
                                        <td>
                                            {{ $nrcrt++ }}
                                        </td>
                                        <td>
                                            {{ $rezervare->nume }}
                                        </td>
                                        <td>
                                            {{ $rezervare->telefon }}
                                        </td>
                                        <td>
                                            {{$cursa_ora->cursa->oras_plecare->nume}}
                                        </td>
                                        <td>
                                            @if(!empty($rezervare->statie))
                                                {{ $rezervare->statie->nume }}
                                            @elseif(!empty($rezervare->statie_imbarcare))
                                                {{ $rezervare->statie_imbarcare }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{ $rezervare->zbor_ora_decolare}}
                                        </td>
                                        <td>
                                            @if (empty($rezervare->user))
                                                <span style="color:#3672ED; font-size:2rem; margin:0px; padding:0px;">
                                                    C
                                                </span>
                                            @elseif ($rezervare->user->firma->id == 1) 
                                                <span style="color:#ed8336; font-size:2rem;">
                                                    D
                                                </span>  
                                            @else 
                                                {{ $rezervare->user->firma->nume }}                               
                                            @endif
                                        </td>
                                        <td>
                                            {{ $rezervare->pret_total - $rezervare->comision_agentie - $rezervare->plata_avans }} lei
                                        </td>
                                        <td>
                                            @if ($rezervare->tip_plata->nume == "Sofer")
                                                S
                                            @else
                                                {{ $rezervare->tip_plata->nume }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $rezervare->nr_adulti + $rezervare->nr_copii}}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            @empty
                            @endforelse
                        
                            @php
                                $nr_persoane = 0;
                                $suma = 0;    
                            @endphp

                            @forelse ($traseu->curse_ore as $cursa_ora)
                                @php
                                    $nr_persoane = $nr_persoane +
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_adulti') +
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_copii');     
                                    $suma = $suma + $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('pret_total') -
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('comision_agentie');
                                @endphp
                            @empty
                            @endforelse

                            <tr>
                                <td colspan="7" style="text-align:right;">
                                    Total:
                                </td>
                                <td>
                                    {{ $suma }} lei
                                </td>
                                <td>
                                    Nr. pers.
                                </td>
                                <td>
                                    {{ $nr_persoane }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    @if ($loop->last)
                    @else
                        <div style="page-break-after: always;"></div>
                    @endif
                @endif
            @empty
            @endforelse
            @break
        @case(4)   
            @break
    @endswitch

</body>

</html>
    