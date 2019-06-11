@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/trasee"><i class="fas fa-route mr-1"></i>Trasee</a></h4>
            </div> 
                <div class="">             
                    <form class="needs-validation" novalidate method="GET" action="traseu_dupa_data">
                        @csrf                    
                        <div class="input-group custom-search-form" id="app1">
                            {{-- <input type="text" class="form-control" name="search" placeholder="Caută..."> --}}
                                        <vue2-datepicker
                                            data-veche="{{ $search }}"
                                            nume-camp-db="search"
                                            tip="date"
                                            latime="150"
                                            {{-- data-veche="{{\Carbon\Carbon::today()}}" --}}
                                        ></vue2-datepicker>
                            <span class="input-group-btn">
                                <button class="btn btn-default-sm bg-primary" style="height: 34px;" type="submit">
                                    <i class="fas fa-search text-white"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            {{-- <div>
                <a class="btn btn-primary" href="/trasee/adauga" role="button">Adaugă Traseu</a>
            </div> --}}
        </div>

        <div class="card-body">
            <div class="row justify-content-center mb-4">
                <div class="col-12 mb-4">  


                    @switch($trasee->traseu_nume->id)
                        @case(1)    
                            <div class="d-flex justify-content-between card-header">
                                <div class="flex flex-vertical-center">
                                    {{$trasee->traseu_nume->nume}}:
                                </div>
                                <div class="flex flex-vertical-center">
                                    {{ \Carbon\Carbon::parse($trasee->curse_ore->first()->ora)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($trasee->curse_ore->first()->ora)
                                            ->addHours(\Carbon\Carbon::parse($trasee->curse_ore->first()->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($trasee->curse_ore->first()->cursa->durata)->minute)
                                            ->format('H:i')
                                    }}
                                </div>
                                <div class="flex flex-vertical-center">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}
                                </div>
                            </div>

                            <div class="card-body shadow-sm">
                        {{-- <div class="card bg-white mb-3 shadow-sm p-0" style=""> --}}
                            <div class="row justify-content-between card-body py-1 px-3">
                            @forelse ($trasee->curse_ore as $cursa_ora) 
                                <div class="col-sm-12"> 
                                    <div class="d-flex justify-content-between bg-secondary text-white">
                                        <div class="flex flex-vertical-center">                    
                                            <h6 class="p-1 mb-0">
                                                {{$cursa_ora->cursa->oras_plecare->nume}}
                                                - ora
                                                {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                                -
                                                {{
                                                    $cursa_ora->rezervari->where('data_cursa', $search)->sum('nr_adulti')
                                                    +
                                                    $cursa_ora->rezervari->where('data_cursa', $search)->sum('nr_copii')
                                                }}
                                                persoane
                                            </h6>
                                        </div>
                                    </div>
                                
                                @forelse ($cursa_ora->rezervari->where('data_cursa', $search) as $rezervare)
                                    {{-- <li>
                                        <a href="{{ $rezervare->path() }}">
                                            {{ $rezervare->nume }}
                                            -
                                            {{ $rezervare->nr_adulti + $rezervare->nr_copii}} persoane
                                        </a>
                                    </li>  --}}
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
                                                                ->addHours(\Carbon\Carbon::parse($rezervare->ora->ora)->hour)
                                                                ->addMinutes(\Carbon\Carbon::parse($rezervare->ora->ora)->minute)
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
                                @endforelse

                                <br>
                                </div>
                            @empty
                            @endforelse
                            </div>
                                <div class="text-center">
                                            <a href="{{ $trasee->path() }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}/export/traseu-pdf"
                                                class="btn btn-success"
                                                role="button"
                                                target="_blank"
                                                >
                                                <i class="fas fa-file-pdf"></i> Generează Raport
                                            </a>
                                </div>
                            </div>

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


                    
                            {{-- @forelse ($trasee->curse_ore as $cursa_ora)  
                        <td>
                            {{$search}}
                            {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                            -
                            <small>
                            {{
                                $cursa_ora->rezervari->where('data_cursa', $search)->sum('nr_adulti')
                                +
                                $cursa_ora->rezervari->where('data_cursa', $search)->sum('nr_copii')
                            }}
                            pers.
                            </small>
                        </td>
                    @empty
                    @endforelse --}}



                    {{-- <table class="table table-sm table-striped text-center">
                        @forelse ($traseu_nume->trasee as $traseu)
                            @if ($loop->first)
                                <tr>
                                        @forelse ($traseu->curse_ore as $cursa_ora) 
                                            <td>
                                                {{$cursa_ora->cursa->oras_plecare->nume}}
                                            </td>
                                        @empty
                                        @endforelse
                                    <td>
                                        {{$cursa_ora->cursa->oras_sosire->nume}}                                    
                                    </td>
                                </tr>
                            @endif 

                            <tr>
                            @forelse ($traseu->curse_ore as $cursa_ora)  
                                <td>
                                    {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                    -
                                    <small>
                                    {{
                                        $cursa_ora->rezervari->where('data_cursa', $search)->sum('nr_adulti')
                                        +
                                        $cursa_ora->rezervari->where('data_cursa', $search)->sum('nr_copii')
                                    }}
                                    pers.
                                    </small>
                                </td>
                            @empty
                            @endforelse
                                <td>
                                    {{ \Carbon\Carbon::parse($cursa_ora->ora)
                                        ->addHours(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->minute)
                                        ->format('H:i') }}
                                </td>
                            </tr>
                        @empty
                        @endforelse 
                    </table> --}}

                    
                </div>      
            </div>   
        </div>
    </div>
@endsection