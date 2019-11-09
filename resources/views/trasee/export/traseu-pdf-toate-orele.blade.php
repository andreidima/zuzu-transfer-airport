<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Raport</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 11px;
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
            word-wrap:break-word;
            /* word-break: break-all; */
            /* table-layout: fixed; */
        }
        
        th, td {
            padding: 1px 1px;
            border-width:1px;
            border-style: solid;
            table-layout:fixed;
            font-weight: normal;
            
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
    {{-- <div style="width:730px; height: 1030px; border-style: dashed ; border-width:2px; border-radius: 15px;">      --}}
    <div style="border:dashed #999;
        width:690px; 
        min-height:600px;            
        padding: 15px 10px 15px 10px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;">

        @switch($trasee_nume->id)
            @case(1) 
            @case(2)   
                @break
            @case(3)                       
                <table style="">
                    <tr style="">
                        <td style="border-width:0px; padding:0rem; width:40%">
                                <img src="{{ asset('images/logo-zuzu.png') }}" width="150px">
                        </td>
                        <td style="border-width:0px; padding:0rem; width:60%; text-align:center; font-size:16px">
                            Tip traseu: RETUR
                            <br>
                            Pentru data: {{ $data_traseu }}
                        </td>
                    </tr>
                </table>

                {{-- <br><br><br>

                <p style="margin: 0 0 0 0px; font-size:1.2rem;">
                    Nume sofer .......................................................................................
                    Nr. masina ......................................
                </p> --}}

                <br>
                
                <table style="width:660px;">
                    <tr style="background-color:#e7d790;">
                        <th style="width:20px;">Nr. crt.</th>
                        <th style="width:85px;">Nume si prenume</th>
                        <th style="width:105px;">Telefon</th>
                        <th style="width:45px;">Sosire</th>
                        <th style="width:35px;">Ora at.</th>
                        <th style="width:75px;">Aterizare</th>
                        <th style="width:120px;">Statie imbarcare</th>
                        <th style="width:75px;">Observatii</th>
                        <th style="width:35px;">Suma</th>
                        <th style="width:30px;">Plata</th>
                        <th style="width:25px;">Nr. pers</th>
                    </tr>
                    @php 
                        $nrcrt = 1;
                        $nr_persoane = 0;
                        $suma = 0;    
                    @endphp
                    
                @forelse ($trasee_nume->trasee as $traseu) 
                    @forelse ($traseu->curse_ore as $cursa_ora)
                        @forelse ($cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1) as $rezervare)
                            @if (in_array($rezervare->telefon, $telefoane_clienti_neseriosi))
                                <tr style="background:#71f85f">
                            @else
                                <tr>
                            @endif
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
                                    @if(!empty($rezervare->statie_imbarcare))
                                        {{ $rezervare->statie_imbarcare }}
                                    @elseif(!empty($rezervare->statie))
                                        {{ $rezervare->statie->nume }}
                                    @endif 
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
                                    @if ($rezervare->oferta == 1)
                                        @if ($rezervare->id < $rezervare->tur_retur)
                                            ✪
                                            @if (($rezervare->comision_agentie == 0) && ($rezervare->tip_plata_id == 2))
                                                0
                                            @elseif ($rezervare->tip_plata_id == 3)
                                                0
                                            @else 
                                                {{ $rezervare->pret_total - $rezervare->comision_agentie }}
                                            @endif
                                            lei
                                        @else
                                            <p style="font-size:9px;">
                                                RETUR
                                            </p>
                                        @endif
                                    @else
                                        @if (($rezervare->comision_agentie == 0) && ($rezervare->tip_plata_id == 2))
                                            0
                                        @elseif ($rezervare->tip_plata_id == 3)
                                            0
                                        @else 
                                            {{ $rezervare->pret_total - $rezervare->comision_agentie }}
                                        @endif
                                        lei
                                    @endif
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

                        @php
                            $nr_persoane = $nr_persoane +
                                $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_adulti') +
                                $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_copii');     
                            $suma = $suma + $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('pret_total')
                                -
                                $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('comision_agentie') 
                                - 
                                $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)
                                    ->where('tip_plata_id', 2)->where('comision_agentie', 0)->sum('pret_total')
                                -
                                $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)
                                    ->where('tip_plata_id', 3)->sum('pret_total');
                        @endphp
                    @empty
                    @endforelse
                @empty
                @endforelse      

                    <tr>
                        <td colspan="9" style="text-align:right; padding-right:5px;">
                            Total: {{ $suma }} lei
                        </td>
                        <td>
                            Nr. pers
                        </td>
                        <td>
                            {{ $nr_persoane }}
                        </td>
                    </tr>
                </table>

            @break
        @endswitch

    </div>
</body>

</html>
    