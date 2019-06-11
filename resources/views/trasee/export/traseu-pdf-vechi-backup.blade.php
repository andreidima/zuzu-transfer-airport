<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Raport</title>
    <style>
        body { 
            font-family: DejaVu Sans !important; 
            font-size: 12px !important;
        }

        * {
            margin: 15px 10px;
            padding: 0;
            text-indent: 0;
        }

        table{
            border-collapse:collapse;
            /* margin: 0px 0px; */
            margin-left: 30px;
            margin-top: 0px;
            border-style: solid;
            border-width:0px;
            width: 690px;
        }
        
        th, td {
            padding: 4px 8px 4px 8px;
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
    {{-- <div style="width:730px; height: 1030px; border-style: dashed ; border-width:2px; border-radius: 15px;">      --}}
        <div style="border-style: dashed ; border-width:2px; border-radius: 15px;">
                    @switch($trasee->traseu_nume->id)
                        @case(1)    
                            <table style="">
                                        <tr style="font-weight:bold;">
                                            <td style="border-width:0px; padding:0rem;">
                                                    <div style="background-color:gray; color:white; margin-left:0px; display: inline-block;">
                                                        <h2>
                                                            Dată cursă: {{ $data_traseu }}
                                                            <br>
                                                            Traseu: {{$trasee->traseu_nume->nume}}
                                                            <br>
                                                            Orar cursă:
                                                            {{ \Carbon\Carbon::parse($trasee->curse_ore->first()->ora)->format('H:i') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($trasee->curse_ore->first()->ora)
                                                                    ->addHours(\Carbon\Carbon::parse($trasee->curse_ore->first()->cursa->durata)->hour)
                                                                    ->addMinutes(\Carbon\Carbon::parse($trasee->curse_ore->first()->cursa->durata)->minute)
                                                                    ->format('H:i')
                                                            }}
                                                        </h2>
                                                </div>
                                            </td>
                                            <td style="border-width:0px; padding:0rem;">
                                                <div style="text-align:right;">
                                                    <h2>
                                                        Zuzu Transfer Aeroport
                                                        <br>
                                                        Tip traseu TUR
                                                    </h2>
                                                </div>
                                            </td>
                                        </tr>
                            </table>

                            <div style="clear:both;">&nbsp;</div>
                            <br><br><br>

                            <h3 style="margin: 0 0 0 40px;">Nume șofer ..................................................................... 
                                Nr. mașină .....................................</h3>
                            
                            <table style="">
                                @forelse ($trasee->curse_ore as $cursa_ora)
                                    <tr style="text-align:center; font-weight:bold;">
                                        <td colspan="6" style="border-width:0px; padding:0rem;">
                                            <h2 style="background-color:gray; color:white; margin:2rem -1px 0 -1px;">
                                            {{$cursa_ora->cursa->oras_plecare->nume}}
                                            - ora
                                            {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                            -
                                            {{
                                                $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_adulti')
                                                +
                                                $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_copii')
                                            }}
                                            persoane
                                            </h2>
                                        </td>
                                    </tr>

                                    @if (!empty($cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->count())) 
                                    
                                        <tr style="text-align:center; font-weight:bold;">
                                            <td>
                                                Nume rezervare
                                            </td>
                                            <td>
                                                Telefon
                                            </td>
                                            <td style="width:100px">
                                                Observații
                                            </td>
                                            <td>
                                                Suma
                                            </td>
                                            <td>
                                                Stație îmbarcare
                                            </td>
                                            <td style="">
                                                Nr. pers.
                                            </td>
                                        </tr>
                                        @forelse ($cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1) as $rezervare)
                                            <tr>
                                                <td>
                                                    {{ $rezervare->nume }}
                                                </td>
                                                <td>
                                                    {{ $rezervare->telefon }}
                                                </td>
                                                <td>
                                                    {{ $rezervare->observatii }}
                                                </td>
                                                <td>
                                                    {{ $rezervare->pret_total - $rezervare->comision_agentie}} lei
                                                </td>
                                                <td>
                                                    {{ $rezervare->statie->nume}} 
                                                </td>
                                                <td style="text-align:center;">
                                                    {{ $rezervare->nr_adulti + $rezervare->nr_copii}}
                                                </td>
                                            </tr>   
                                        @empty
                                        @endforelse
                                    @endif

                                @empty
                                @endforelse

                                
                            </table>
                            
                            @php
                                $nr_persoane = 0;
                                $suma = 0;    
                            @endphp

                            @forelse ($trasee->curse_ore as $cursa_ora)
                                @php
                                    $nr_persoane = $nr_persoane +
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_adulti') +
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('nr_copii');     
                                    $suma = $suma + $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('pret_total') -
                                        $cursa_ora->rezervari->where('data_cursa', $data_traseu_Ymd)->where('activa', 1)->sum('comision_agentie');
                                @endphp
                            @empty
                            @endforelse   

                            <table style="margin:2rem 0 1rem 0;">
                                <tr>
                                    <td style="border-width:0px;">

                                    </td>
                                    <td style="border-width:0px; background-color:lightgray; color:black; width:250px; text-align:right;">
                                        <h2>Numărul total de persoane: {{ $nr_persoane }}<br>
                                        Suma totală de încasat: {{ $suma }} lei</h2>
                                    </td>
                                </tr>
                            </table>

                            {{-- <h2>Numărul total de persoane: {{ $nr_persoane }}</h2>
                            <br>
                            <h2>Suma totală de încasat: {{ $suma }} lei</h2> --}}

                            @break
                        @case(2)                      
                            <h5 class="p-3 mb-2 bg-secondary text-white">                                
                                {{$trasee->traseu_nume->nume}}:
                                traseu nr. {{$trasee->numar}}
                            </h5>
                            @break
                        @case(3)                      
                            <h5 class="p-3 mb-2 bg-secondary text-white">                                
                                {{$trasee->traseu_nume->nume}}:
                                traseu nr. {{$trasee->numar}}
                            </h5>
                            @break
                        @case(4)                      
                            <h5 class="p-3 mb-2 bg-secondary text-white">                                
                                {{$trasee->traseu_nume->nume}}:
                                traseu nr. {{$trasee->numar}}
                            </h5>
                            @break
                    @endswitch

    </div>
</body>

</html>
    