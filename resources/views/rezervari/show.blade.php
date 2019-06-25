@extends('layouts.app')

@section('content')   
    <div class="">
        {{-- <div class="d-flex justify-content-between card-header mb-4">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a> / {{ $rezervari->nume }}</h4>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ $rezervari->path() }}/modifica" role="button">Modifică Rezervare</a>
                <a class="btn btn-danger" href="#" role="button" data-toggle="modal" data-target="#stergeRezervare">Șterge Rezervare</a>
            </div>
        </div> --}}
    

    <!-- Modal pentru stergere rezervare-->
    {{-- <div class="modal fade" id="stergeRezervare" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $rezervari->nume }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ești sigur ca vrei să ștergi rezervarea?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                
                <form method="POST" action="{{ $rezervari->path() }}">
                    @method('DELETE')  
                    @csrf   
                    <button 
                        type="submit" 
                        class="btn btn-danger"  
                        >
                        Șterge Rezervare
                    </button>                    
                </form>
            
            </div>
            </div>
        </div>
    </div> --}}

        <div class="">
            <div class="row justify-content-center">
                <div class="col-lg-7 bg-light border">
        
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
                                        {{ $rezervari->comision_agentie }}
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
                            
                            {{-- @if (auth()->user()->isDispecer()) --}}
                                <a class="btn btn-sm btn-primary" href="{{ $rezervari->path() }}/modifica" role="button">Modifică Rezervarea</a>
                            {{-- @endif --}}
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
                                    Detalii la +40 786 574 788, +40 748 836 345, +40 766 862 890
                                </p>
                            </small>
                        </div>
                    </div>

                </div>    

                </div>
            </div>
        </div>
    </div>

@endsection