@extends('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header mb-4">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a> / {{ $rezervari->nume }}</h4>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ $rezervari->path() }}/modifica" role="button">Modifică Rezervare</a>
                <a class="btn btn-danger" href="#" role="button" data-toggle="modal" data-target="#stergeRezervare">Șterge Rezervare</a>
            </div>
        </div>
        
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
    

    <!-- Modal -->
    <div class="modal fade" id="stergeRezervare" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        {{-- onclick="return confirm('Ești sigur ca vrei să ștergi clientul? Se vor șterge automat și toate proiectele asociate acestui client.')"> --}}
                        Șterge Rezervare
                    </button>                    
                </form>
            
            </div>
            </div>
        </div>
    </div>

        <div class="card-body">
            <div class="form-row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <table class="table table-striped bg-light">
                        <tbody>
                            <tr>
                                <td class="text-right w-25 ">Client</td>
                                <td class="w-75">{{ $rezervari->nume }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">Cursa</td>
                                <td>
                                    @if(!empty($rezervari->cursa)) 
                                        {{ $rezervari->cursa->oras_plecare->nume }}
                                        -                                         
                                        {{ $rezervari->cursa->oras_sosire->nume }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right w-25 ">Stație îmbarcare</td>
                                <td class="w-75">
                                    @if(!empty($rezervari->statie)) 
                                        {{ $rezervari->statie->nume }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Dată cursă</td>
                                <td>
                                    @if(!empty($rezervari->data_cursa)) 
                                        {{ \Carbon\Carbon::parse($rezervari->data_cursa)->format('d.m.Y') }},
                                    @endif
                                    @if(!empty($rezervari->ora_id)) 
                                        {{ \Carbon\Carbon::parse($rezervari->ora->ora)->format('H:i') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">De unde decolează avionul</td>
                                <td>
                                    {{ $rezervari->zbor_oras_decolare }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Oră decolare</td>
                                <td>
                                    {{ $rezervari->zbor_ora_decolare }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Ora aterizare</td>
                                <td>
                                    {{ $rezervari->zbor_ora_aterizare }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Telefon</td>
                                <td>
                                    {{ $rezervari->telefon }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Email</td>
                                <td>
                                    {{ $rezervari->email }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Nr. adulți</td>
                                <td>
                                    {{ $rezervari->nr_adulti }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Nr. copii</td>
                                <td>
                                    {{ $rezervari->nr_copii }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Preț total</td>
                                <td>
                                    {{ $rezervari->pret_total }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Comision agenție</td>
                                <td>
                                    {{ $rezervari->comision_agentie }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Tip plată</td>
                                <td>
                                    @if(!empty($rezervari->tip_plata)) 
                                        {{ $rezervari->tip_plata->nume }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Observații</td>
                                <td><pre style="white-space: pre-wrap;">{{ $rezervari->observatii }}</pre></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-primary" href="/rezervari/adauga" role="button">Adaugă o nouă Rezervare</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection