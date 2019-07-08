@extends('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                @if (auth()->user()->isDispecer())
                    <h4 class="mt-2"><a href="/agentii"><i class="fas fa-handshake mr-1"></i>Agenții</a> / {{ $agentii->nume }}</h4>
                @else
                    <h4 class="mt-2">Raport Rezervări</h4>
                @endif
            </div> 
        </div>


        <div class="card-body">
            
            <div class="" id="app1">                
                @if (auth()->user()->isDispecer())
                    <form class="needs-validation" novalidate method="GET" action="{{ $agentii->path() }}/rezervari">
                @else
                    <form class="needs-validation" novalidate method="GET" action="rezervari">
                @endif
                    @csrf                    
                    <div class="input-group custom-search-form row d-flex justify-content-center mb-3">
                        <div class="d-flex col-8 justify-content-center">
                            <div class="d-flex mr-4 w-35 align-items-center">
                                <label for="search_data_inceput" class="mb-0 mr-1">Data început</label>
                                <vue2-datepicker
                                    @if (!empty($search_data_inceput))
                                        data-veche="{{ $search_data_inceput }}"
                                    @endif
                                    nume-camp-db="search_data_inceput"
                                    tip="date"
                                    latime="150"
                                    {{-- data-veche="{{\Carbon\Carbon::today()}}" --}}
                                ></vue2-datepicker>
                            </div>
                            <div class="d-flex mr-4 w-35 align-items-center">
                                <label for="search_data_inceput" class="mb-0 mr-1">Data sfârșit</label>
                                <vue2-datepicker
                                    @if (!empty($search_data_sfarsit))
                                        data-veche="{{ $search_data_sfarsit }}"
                                    @endif
                                    nume-camp-db="search_data_sfarsit"
                                    tip="date"
                                    latime="150"
                                    {{-- data-veche="{{\Carbon\Carbon::today()}}" --}}
                                ></vue2-datepicker>
                            </div>
                            <div class="d-flex mr-4 w-30"> 
                                <button class="btn bg-primary text-white mr-4" type="submit">
                                    <i class="fas fa-search"></i>Filtrează
                                </button>
                                {{-- <a class="btn bg-secondary text-white" href="/rezervari-raport-zi" role="button">
                                    {{ $agentii->path() }}
                                </a> --}}
                            </div> 
                        </div>                 
                    </div>

                    <div>
                    </div>
                </form>
            </div>

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
                                    <td style="max-width:200px; word-break: break-word;">
                                        {{ $rezervare->nume }}
                                    </td>
                                    <td style="max-width:200px; word-break: break-word;">
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
                                        @if (!empty($rezervare->ora))
                                            {{ \Carbon\Carbon::parse($rezervare->ora->ora)->format('H:i') }}
                                        @endif
                                    </td>
                                    <td class="text-center">                                
                                        @if (!empty($rezervare->ora->ora) && !empty($rezervare->cursa->durata))
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
                                    <td style="max-width:200px; word-break: break-word;">                                
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
                            {{$rezervari->appends(request()->query())->links()}}
                        </ul>
                    </nav>                  


                    <div class="text-center">

                        {{-- agentii/{agentii}/rezervari/{data_inceput}/{data_sfarsit}/export/{view_type} --}}

                            {{-- <a href="/agentii/{{ $agentii->id }}/rezervari/export/agentie-rezervari-pdf"
                                class="btn btn-success" role="button" target="_blank">
                                <i class="fas fa-file-pdf"></i> Raport
                            </a>

                            <a href="/agentii/{{ $agentii->id }}/rezervari/{{ $search_data_inceput }}/{{ $search_data_sfarsit }}/export/agentie-rezervari-pdf"
                                class="btn btn-success" role="button" target="_blank">
                                <i class="fas fa-file-pdf"></i> Raport
                            </a> --}}
                        
                        {{-- @if (empty($search_data_inceput) || empty($search_data_sfarsit))
                            <a href="/agentii/{{ $agentii->id }}/rezervari/export/agentie-rezervari-pdf"
                                class="btn btn-success" role="button" target="_blank">
                                <i class="fas fa-file-pdf"></i> Raport
                            </a>
                        @else
                            <a href="/agentii/{{ $agentii->id }}/rezervari/export/agentie-rezervari-pdf/{{ $search_data_inceput }}/{{ $search_data_sfarsit }}"
                                class="btn btn-success" role="button" target="_blank">
                                <i class="fas fa-file-pdf"></i> Raport
                            </a>
                        @endif --}}
                        
                        @isset($search_data_inceput, $search_data_sfarsit)                         
                            @if (auth()->user()->isDispecer())
                                <a href="/agentii/{{ $agentii->id }}/rezervari/export/agentie-rezervari-pdf/{{ $search_data_inceput }}/{{ $search_data_sfarsit }}"
                            @else
                                <a href="/agentii/rezervari/export/agentie-rezervari-pdf/{{ $search_data_inceput }}/{{ $search_data_sfarsit }}"
                            @endif
                                    class="btn btn-success" role="button" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Raport
                                </a>
                        @endisset

                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection