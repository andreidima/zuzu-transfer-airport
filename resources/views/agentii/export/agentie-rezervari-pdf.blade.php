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
                    <div style="border:dashed #999;
                        width:690px; 
                        min-height:600px;            
                        padding: 15px 10px 15px 10px;
                        margin:0px 0px;
                            -moz-border-radius: 10px;
                            -webkit-border-radius: 10px;
                            border-radius: 10px;">
                        <table style="">
                            <tr>
                                <td style="border-width:0px; padding:0rem;">
                                    <img src="{{ asset('images/logo-zuzu.png') }}" style="width:150px; padding:0rem; margin:0rem;">
                                </td>
                                <td style="border-width:0px; padding:0rem; text-align:center; font-size:16px">
                                    Raport: {{ $agentie->nume }}
                                    <br>
                                    De la data: {{ $search_data_inceput }} la data {{ $search_data_sfarsit }}
                                    <br>
                                </td>
                            </tr>
                            <tr class="">
                                <td style="border-width:0px;">
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr style="background-color:#e7d790; font-weight: normal;">
                                <th style="width:25px">Nr. crt.</th>
                                <th style="width:130px">Nume si prenume</th>
                                <th style="width:60px">Plecare</th>
                                <th style="width:60px">Sosire</th>
                                <th style="width:70px">Data plecare</th>
                                <th style="width:45px">Sofer</th>
                                <th style="width:45px">Agentie</th>
                                <th style="width:170px">Statie imbarcare</th>
                                <th style="width:25px">Nr. ad.</th>
                                <th style="width:25px">Nr. cp.</th>
                            </tr>

                                @forelse ($rezervari as $rezervare)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $rezervare->nume }}
                                        </td>
                                        <td>
                                            {{ $rezervare->cursa->oras_plecare->nume }}
                                        </td>
                                        <td>
                                            {{ $rezervare->cursa->oras_sosire->nume }}
                                        </td>
                                        <td>
                                            {{ $rezervare->data_cursa }}
                                        </td>
                                    @if (($rezervare->tip_plata_id == 2) && ($rezervare->comision_agentie == 0))
                                        <td>
                                            
                                        </td>
                                        <td>
                                            @if ($rezervare->oferta == 1)
                                                @if ($rezervare->id < $rezervare->tur_retur)
                                                ✪
                                                @else
                                                RETUR
                                                @endif
                                            @endif
                                            {{ $rezervare->pret_total }} lei
                                        </td>
                                    @elseif (($rezervare->tip_plata_id == 2) && ($rezervare->comision_agentie > 0))
                                        <td>
                                            {{ $rezervare->pret_total - $rezervare->comision_agentie}} lei
                                        </td>
                                        <td>
                                            @if ($rezervare->oferta == 1)
                                                @if ($rezervare->id < $rezervare->tur_retur)
                                                ✪
                                                @else
                                                RETUR
                                                @endif
                                            @endif
                                            {{ $rezervare->comision_agentie }} lei
                                        </td>
                                    @else
                                        <td>
                                            {{ $rezervare->pret_total }} lei
                                        </td>
                                        <td>
                                            @if ($rezervare->oferta == 1)
                                                @if ($rezervare->id < $rezervare->tur_retur)
                                                ✪
                                                @else
                                                RETUR
                                                @endif
                                            @endif                                            
                                        </td>
                                    @endif
                                        <td>
                                            @if(!empty($rezervare->statie))
                                                {{ $rezervare->statie->nume }}
                                            @elseif(!empty($rezervare->statie_imbarcare))
                                                {{ $rezervare->statie_imbarcare }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $rezervare->nr_adulti }}
                                        </td>
                                        <td>
                                            {{ $rezervare->nr_copii }}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                        
                            {{-- @php
                                $nr_persoane = 0;    
                            @endphp

                            @forelse ($traseu->curse_ore as $cursa_ora)
                                @php
                                    $nr_persoane = $nr_persoane +
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_adulti') +
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_copii');     
                                    $suma = $suma + $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('pret_total') -
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('comision_agentie') - 
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)
                                            ->where('tip_plata_id', 2)->where('comision_agentie', 0)->sum('pret_total');
                                @endphp
                            @empty
                            @endforelse --}}

                            <tr>
                                <td colspan="8" style="text-align:right;">
                                    <b>Total Nr. Persoane:</b>
                                </td>
                                <td colspan="2" style="text-align:center;">
                                    <b>{{ $rezervari->sum('nr_adulti') + $rezervari->sum('nr_copii')}}</b>
                                </td>
                            </tr>
                        </table>
                    </div>

</body>

</html>
    