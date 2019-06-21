@extends('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/agentii"><i class="fas fa-handshake mr-1"></i>Agenții</a> / {{ $agentii->nume }}</h4>
            </div> 
        </div>


        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-12 bg-light border">
                    <table class="table table-sm table-striped" style="font-size:0.8rem">
                        <tr style="height:35px; background-color:#336699; text-align:center; color:white;">
                            <td>
                                Nr.<br>Crt.
                            </td>
                            <td>
                                Nume
                            </td>
                            <td>
                                Telefon
                            </td>
                            <td>
                                Plecare
                            </td>
                            <td>
                                Sosire
                            </td>
                            <td>
                                Data<br>plecare
                            </td>
                            <td>
                                Ora<br>imbarcare
                            </td>
                            <td>
                                Ora<br>debarcare
                            </td>
                            <td>
                                Plata
                            </td>
                            <td>
                                Nr.<br>persoane
                            </td>
                            <td>
                                Statie<br>imbarcare
                            </td>
                        @forelse ($rezervari as $rezervare)                        
                            @if ($rezervare->activa == 0)
                                <tr style="background:#99F;">
                            @else
                                    <tr>
                            @endif
                                    <td>
                                        {{ $loop->iteration }}.
                                    </td>
                                    <td>
                                        {{ $rezervare->nume }}
                                    </td>
                                    <td>
                                        {{ $rezervare->telefon }}
                                    </td>
                                    <td>
                                        @if (!empty($rezervare->cursa->oras_plecare))
                                            @if ($rezervare->cursa->oras_plecare->nume == "Ramnicu Sarat")
                                                Rm.Sarat
                                            @else
                                                {{ $rezervare->cursa->oras_plecare->nume }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($rezervare->cursa->oras_sosire))
                                            @if ($rezervare->cursa->oras_sosire->nume == "Ramnicu Sarat")
                                                Rm.Sarat
                                            @else
                                                {{ $rezervare->cursa->oras_sosire->nume }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        {{ $rezervare->data_cursa }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($rezervare->ora->ora)->format('H:i') }}
                                    </td>
                                    <td class="text-center">                                
                                        @if (!empty($rezervare->ora->ora && $rezervare->cursa->durata))
                                            {{ \Carbon\Carbon::parse($rezervare->ora->ora)
                                                ->addHours(\Carbon\Carbon::parse($rezervare->cursa->durata)->hour)
                                                ->addMinutes(\Carbon\Carbon::parse($rezervare->cursa->durata)->minute)
                                                ->format('H:i') }}                        
                                        @endif
                                    </td>
                                    <td class="text-center">                                
                                        @if (!empty($rezervare->tip_plata))
                                            {{ $rezervare->tip_plata->nume }}
                                        @else
                                            -
                                        @endif 
                                    </td>
                                    <td class="text-center">
                                        {{ $rezervare->nr_adulti + $rezervare->nr_copii }}
                                    </td>
                                    <td>                                
                                        @if(!empty($rezervare->statie))
                                            {{ $rezervare->statie->nume }}
                                        @endif
                                        {{ $rezervare->statie_imbarcare }}
                                    </td>
                                </tr>                                    
                        @empty
                            Nu sunt rezervări
                        @endforelse
                    </table>

                    <nav>
                        <ul class="pagination justify-content-center">
                            {{$rezervari->links('vendor.pagination.bootstrap-4')}}
                        </ul>
                    </nav>


                </div>
            </div>
        </div>
    </div>

@endsection