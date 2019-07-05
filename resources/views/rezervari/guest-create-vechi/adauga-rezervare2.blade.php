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
{{-- 
        <div>
            @php
                dd( $rezervare->statie_id);
            @endphp
        </div> --}}

        <div class="card-body">
            <div class="form-row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <table class="table table-striped bg-light">
                        <tbody>
                            <tr>
                                <td class="text-right w-25 ">Client</td>
                                <td class="w-75">{{ $rezervare->nume }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">Cursa</td>
                                <td>
                                    @if(!empty($rezervare->cursa)) 
                                        {{ $rezervare->cursa->oras_plecare->nume }}
                                        -                                         
                                        {{ $rezervare->cursa->oras_sosire->nume }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right w-25 ">Stație îmbarcare</td>
                                <td class="w-75">
                                    @if(!empty($rezervare->statie->nume)) 
                                        {{ $rezervare->statie->nume }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Dată cursă</td>
                                <td>
                                    @if(!empty($rezervare->data_cursa)) 
                                    {{-- {{$rezervare->data_cursa}} --}}
                                        {{-- {{ \Carbon\Carbon::parse($rezervare->data_cursa)->format('d.m.Y') }}, --}}
                                        {{ \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervare->data_cursa)->format('d.m.Y') }},
                                    @endif
                                    @if(!empty($rezervare->ora_id)) 
                                        {{ \Carbon\Carbon::parse($rezervare->ora->ora)->format('H:i') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">De unde decolează avionul</td>
                                <td>
                                    {{ $rezervare->zbor_oras_decolare }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Oră decolare</td>
                                <td>
                                    {{ $rezervare->zbor_ora_decolare }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Ora aterizare</td>
                                <td>
                                    {{ $rezervare->zbor_ora_aterizare }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Telefon</td>
                                <td>
                                    {{ $rezervare->telefon }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Email</td>
                                <td>
                                    {{ $rezervare->email }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Nr. adulți</td>
                                <td>
                                    {{ $rezervare->nr_adulti }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Nr. copii</td>
                                <td>
                                    {{ $rezervare->nr_copii }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Preț total</td>
                                <td>
                                    {{ $rezervare->pret_total }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Comision agenție</td>
                                <td>
                                    {{ $rezervare->comision_agentie }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Tip plată</td>
                                <td>
                                    @if(!empty($rezervare->tip_plata)) 
                                        {{ $rezervare->tip_plata->nume }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Observații</td>
                                <td><pre style="white-space: pre-wrap;">{{ $rezervare->observatii }}</pre></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12 text-center">  
                    <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-2">
                        @csrf                                                 
                            
                        <button type="submit" class="btn btn-primary float-right" style="width: 100%; height:100%; white-space: normal;">Finalizează rezervarea</button> 
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection