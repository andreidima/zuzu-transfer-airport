@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a></h4>
            </div> 
                <div class="">             
                    <form class="needs-validation" novalidate method="GET" action="/rezervari">
                        @csrf                    
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" name="search" placeholder="Caută...">
                            <span class="input-group-btn">
                                <button class="btn btn-default-sm bg-primary" type="submit">
                                    <i class="fas fa-search text-white"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            <div>
                <a class="btn btn-primary" href="/rezervari/adauga" role="button">Adaugă Rezervare</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row justify-content-center mb-4">
                <div class="col-12 mb-4">               
                    {{-- <h5 class="p-3 mb-2 bg-secondary text-white">Rezervări curente: {{ $rezervari_curente_nr }}</h5> --}}
                    @forelse ($rezervari as $rezervare)
                        <div class="card mb-3 shadow-sm p-0
                                @if ($rezervare->activa == 0)
                                    bg-secondary text-white
                                @elseif (\Carbon\Carbon::parse($rezervare->created_at)->format('Y-m-d') == $rezervare->data_cursa)
                                    bg-warning text-dark 
                                @endif                        
                        ">
                            <div class="row justify-content-between card-body py-1 px-3">
                                <div class="col-sm-4">
                                    Client: <a href="{{ $rezervare->path() }}">{{ $rezervare->nume }} - 
                                    {{ $rezervare->nr_adulti + $rezervare->nr_copii}} persoane</a>
                                    <br>
                                    Telefon:
                                        @if(!empty($rezervare->telefon)) 
                                            {{ $rezervare->telefon }} </a>
                                        @endif
                                </div>
                                <div class="col-sm-4 text-center">
                                    @if(!empty($rezervare->cursa->oras_plecare->nume)) 
                                        {{ $rezervare->cursa->oras_plecare->nume }} </a>
                                    @endif
                                    -                                        
                                    @if(!empty($rezervare->cursa->oras_sosire->nume)) 
                                        {{ $rezervare->cursa->oras_sosire->nume }} </a>
                                    @endif
                                    <br>
                                    {{-- Mod plată:
                                        @if(!empty($rezervare->tip_plata->nume)) 
                                            {{ $rezervare->tip_plata->nume }} </a>
                                        @endif --}}
                                    
                                    <div>
                                        {{-- Dată cursă: --}}
                                        
                                        @if (!empty($rezervare->data_cursa && $rezervare->ora_id))
                                            {{-- <span class="text-danger">
                                                {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                                    ->addHours(\Carbon\Carbon::parse($rezervare->ora)->hour)
                                                    ->addMinutes(\Carbon\Carbon::parse($rezervare->ora)->minute)
                                                    ->diffForHumans(now()) }}
                                            </span>
                                            <br> --}}
                                                {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                                    ->addHours(\Carbon\Carbon::parse($rezervare->ora)->hour)
                                                    ->addMinutes(\Carbon\Carbon::parse($rezervare->ora)->minute)
                                                    ->format('d.m.Y, H:i') }}
                                        @else
                                            nespecificat
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="col-sm-4 align-self-center">    
                                        <div style="float:right;" class="mr-1">   
                                            <form  
                                                class="needs-validation" novalidate 
                                                method="POST" action="{{ url('rezervari/activa', $rezervare->id) }}">
                                                    @method('PATCH')
                                                    @csrf  
                                                
                                                @if ($rezervare->activa == 1) 
                                                    <button type="submit" class="btn btn-dark float-right" title="Anulează Rezervarea">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-success float-right" title="Activează Rezervarea">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                @endif
                                                
                                            </form> 
                                        </div> 

                                        <div style="float:right;" class="mr-1">
                                            <a class="btn btn-danger" 
                                                href="#" 
                                                role="button"
                                                data-toggle="modal" 
                                                data-target="#stergeRezervare{{ $rezervare->id }}"
                                                title="Șterge Rezervarea"
                                                >
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                                <!-- Modal -->
                                                <div class="modal fade text-dark" id="stergeRezervare{{ $rezervare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Client: <b>{{ $rezervare->nume }}</b></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să ștergi rezervarea?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                            
                                                            <form method="POST" action="{{ $rezervare->path() }}">
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
                                        </div>

                                        <div style="float:right;" class="mr-1">
                                            <a href="{{ $rezervare->path() }}/modifica"
                                                class="btn btn-primary"
                                                role="button"
                                                title="Editează Rezervarea"
                                                >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div> 

                                        <div style="float:right;" class="mr-1">
                                            <a href="{{ $rezervare->path() }}/export/rezervare-pdf"
                                                class="btn btn-success"
                                                role="button"
                                                target="_blank"
                                                title="Descarcă bilet"
                                                >
                                                <i class="fas fa-ticket-alt"></i>
                                            </a>
                                        </div>
                                </div>
                                {{-- <div class="col-sm-2 text-right">
                                </div> --}}
                            </div>
                        </div>                    
                    @empty
                        <div>Momentan nu sunt rezervări în așteptare. Adaugă una...</div>
                    @endforelse
                    <nav>
                        <ul class="pagination justify-content-center">
                            {{$rezervari->links('vendor.pagination.bootstrap-4')}}
                        </ul>
                    </nav>
                </div> 
                {{-- <div class="col-12 mb-4">               
                    <h5 class="p-3 mb-2 bg-secondary text-white">Rezervări curente: {{ $rezervari_curente_nr }}</h5>
                    @forelse ($rezervari_curente as $rezervare)
                        <div class="card bg-white mb-3 shadow-sm p-0" style="">
                            <div class="row justify-content-between card-body py-1 px-3">
                                <div class="col-sm-4">
                                    Client: <a href="{{ $rezervare->path() }}">{{ $rezervare->nume }} - 
                                    {{ $rezervare->nr_adulti + $rezervare->nr_copii}} persoane</a>
                                    <br>
                                    Telefon:
                                        @if(!empty($rezervare->telefon)) 
                                            {{ $rezervare->telefon }} </a>
                                        @endif
                                </div>
                                <div class="col-sm-4 text-center">
                                    @if(!empty($rezervare->cursa->oras_plecare->nume)) 
                                        {{ $rezervare->cursa->oras_plecare->nume }} </a>
                                    @endif
                                    -                                        
                                    @if(!empty($rezervare->cursa->oras_sosire->nume)) 
                                        {{ $rezervare->cursa->oras_sosire->nume }} </a>
                                    @endif
                                    <br>
                                    Mod plată:
                                        @if(!empty($rezervare->tip_plata->nume)) 
                                            {{ $rezervare->tip_plata->nume }} </a>
                                        @endif
                                </div>
                                <div class="col-sm-4 text-right">
                                    Dată cursă:
                                    
                                    @if (!empty($rezervare->data_cursa && $rezervare->ora_id))
                                        <span class="text-danger">
                                            {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                                ->addHours(\Carbon\Carbon::parse($rezervare->ora)->hour)
                                                ->addMinutes(\Carbon\Carbon::parse($rezervare->ora)->minute)
                                                ->diffForHumans(now()) }}
                                        </span>
                                        <br>
                                            {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                                ->addHours(\Carbon\Carbon::parse($rezervare->ora)->hour)
                                                ->addMinutes(\Carbon\Carbon::parse($rezervare->ora)->minute)
                                                ->format('d.m.Y, H:i') }}
                                    @else
                                        nespecificat
                                    @endif
                                </div>
                            </div>
                        </div>                    
                    @empty
                        <div>Momentan nu sunt rezervări în așteptare. Adaugă una...</div>
                    @endforelse
                    <nav>
                        <ul class="pagination justify-content-center">
                            {{$rezervari_curente->links('vendor.pagination.bootstrap-4')}}
                        </ul>
                    </nav>
                </div>                             
                <div class="col-12">
                    <h5 class="p-3 mb-2 bg-secondary text-white">Rezervări vechi: {{ $rezervari_vechi_nr }}</h5>
                    @forelse ($rezervari_vechi as $rezervare)
                        <div class="card bg-white mb-3 shadow-sm p-0" style="">
                            <div class="row justify-content-between card-body py-1 px-3">
                                <div class="col-sm-4">
                                    Client: <a href="{{ $rezervare->path() }}">{{ $rezervare->nume }} - 
                                    {{ $rezervare->nr_adulti + $rezervare->nr_copii}} persoane</a>
                                    <br>
                                    Telefon:
                                        @if(!empty($rezervare->telefon)) 
                                            {{ $rezervare->telefon }} </a>
                                        @endif
                                </div>
                                <div class="col-sm-4 text-center">
                                    @if(!empty($rezervare->cursa->oras_plecare->nume)) 
                                        {{ $rezervare->cursa->oras_plecare->nume }} </a>
                                    @endif
                                    -                                        
                                    @if(!empty($rezervare->cursa->oras_sosire->nume)) 
                                        {{ $rezervare->cursa->oras_sosire->nume }} </a>
                                    @endif
                                    <br>
                                    Mod plată:
                                        @if(!empty($rezervare->tip_plata->nume)) 
                                            {{ $rezervare->tip_plata->nume }} </a>
                                        @endif
                                </div>
                                <div class="col-sm-4 text-right">
                                    Dată cursă:
                                    
                                    @if (!empty($rezervare->data_cursa && $rezervare->ora_id))
                                        <span class="text-danger">
                                            {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                                ->addHours(\Carbon\Carbon::parse($rezervare->ora)->hour)
                                                ->addMinutes(\Carbon\Carbon::parse($rezervare->ora)->minute)
                                                ->diffForHumans(now()) }}
                                        </span>
                                        <br>
                                            {{ \Carbon\Carbon::parse($rezervare->data_cursa)
                                                ->addHours(\Carbon\Carbon::parse($rezervare->ora)->hour)
                                                ->addMinutes(\Carbon\Carbon::parse($rezervare->ora)->minute)
                                                ->format('d.m.Y, H:i') }}
                                    @else
                                        nespecificat
                                    @endif
                                </div>
                            </div>
                        </div>                    
                    @empty
                        <div>Momentan nu sunt rezervări vechi. Adaugă una...</div>
                    @endforelse
                    <nav>
                        <ul class="pagination justify-content-center">
                            {{$rezervari_vechi->links('vendor.pagination.bootstrap-4')}}
                        </ul>
                    </nav>
                </div>     --}}
            </div>    
        </div>
    </div>
@endsection