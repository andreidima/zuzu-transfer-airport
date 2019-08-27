@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/trasee"><i class="fas fa-route mr-1"></i>Trasee</a></h4>
            </div> 
                <div class="">             
                    <form class="needs-validation" novalidate method="GET" action="/trasee">
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

        {{-- <form action="{{ route('trasee.store') }}" method="POST">
            @csrf 
        <input type="hidden" name="search" value="{{ $search }}">
            <input type="submit" value="Send.">
        </form> --}}


        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-10 container-fluid px-0 table-responsive-lg border">    
                    @forelse ($trasee_nume_tecuci_otopeni as $traseu_nume)                     
                        <h5 class="p-2 bg-secondary text-white mb-0 text-center">{{$traseu_nume->nume}}</h5>
                        <table class="table table-sm table-striped text-center mb-2">
                            @forelse ($traseu_nume->trasee as $traseu)
                                @if ($loop->first)
                                    <tr>
                                            @forelse ($traseu->curse_ore as $cursa_ora) 
                                                <th style="width: 11%">
                                                    {{$cursa_ora->cursa->oras_plecare->nume}}
                                                </th>
                                            @empty
                                            @endforelse
                                        <th style="width: 11%">
                                            {{$cursa_ora->cursa->oras_sosire->nume}}
                                        </th>
                                        <th style="width: 15%">

                                        </th>
                                    </tr>
                                @endif 
                                
                                
                                <tr>         
                                @forelse ($traseu->curse_ore as $cursa_ora)
                                    <td style="line-height:0.9rem">
                                            @if(!empty(\Carbon\Carbon::parse($cursa_ora->ora)))
                                                <a href="{{ $traseu->path() }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                                    class="text-dark">
                                                    {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                                </a>
                                            @endif                                            
                                            <br>
                                            <small class="text-danger">
                                                {{
                                                    $cursa_ora->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                    +
                                                    $cursa_ora->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii')
                                                }}
                                            </small>
                                    </td>
                                @empty
                                @endforelse
                                    <td style="line-height:1">
                                        <a href="{{ $traseu->path() }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                            class="text-dark">
                                            {{ \Carbon\Carbon::parse($cursa_ora->ora)
                                                ->addHours(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->hour)
                                                ->addMinutes(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->minute)
                                                ->format('H:i') }}
                                        </a>
                                        <br>
                                            <small class="text-danger">
                                                ={{
                                                    $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                    +
                                                    $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii')
                                                }}
                                            </small>
                                    </td>
                                    <td class="">
                                        <a href="{{ $traseu->path() }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                            class="btn btn-sm btn-primary"
                                            role="button"
                                            >
                                            Raport
                                        </a>        
                                    </td>
                                </tr>
                            @empty
                            @endforelse 
                        </table>
                    <div class="d-flex justify-content-between">
                        <div class="flex flex-vertical-center mx-auto">  
                                    <a href="trasee/toate_orele/1/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                        class="btn btn-success"
                                        role="button"
                                        >
                                        Raport complet {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d.m.Y') }}
                                    </a>
                        </div>
                    </div>

                    @empty
                        <div>Nu există trasee în baza de date. Încearcă alte date de căutare.</div>
                    @endforelse
                </div>  

                <div class="col-10">
                    <br><br>
                </div>


                
                <div class="col-lg-7 container-fluid px-0 table-responsive-lg border">    
                    @forelse ($trasee_nume_galati_otopeni as $traseu_nume)                     
                        <h5 class="p-2 bg-secondary text-white mb-0 text-center">{{$traseu_nume->nume}}</h5>
                        <table class="table table-sm table-striped text-center mb-2">
                            @forelse ($traseu_nume->trasee as $traseu)
                                @if ($loop->first)
                                    <tr>
                                            @forelse ($traseu->curse_ore as $cursa_ora) 
                                                <th style="width: 11%">
                                                    {{$cursa_ora->cursa->oras_plecare->nume}}
                                                </th>
                                            @empty
                                            @endforelse
                                        <th style="width: 11%">
                                            {{$cursa_ora->cursa->oras_sosire->nume}}
                                        </th>
                                        <th style="width: 15%">

                                        </th>
                                    </tr>
                                @endif 
                                
                                
                                <tr>         
                                @forelse ($traseu->curse_ore as $cursa_ora) 
                                    <td style="line-height:0.9rem">
                                            @if(!empty(\Carbon\Carbon::parse($cursa_ora->ora)))
                                                <a href="{{ $traseu->path() }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                                    class="text-dark">
                                                    {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                                </a>
                                            @endif                                            
                                            <br>
                                            <small class="text-danger">
                                                {{
                                                    $cursa_ora->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                    +
                                                    $cursa_ora->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii')
                                                }}
                                            </small>
                                    </td>
                                @empty
                                @endforelse
                                    <td style="line-height:1">
                                        <a href="{{ $traseu->path() }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                            class="text-dark">
                                            {{ \Carbon\Carbon::parse($cursa_ora->ora)
                                                ->addHours(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->hour)
                                                ->addMinutes(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->minute)
                                                ->format('H:i') }}
                                        </a>
                                        <br>
                                            <small class="text-danger">
                                                ={{
                                                    $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                    +
                                                    $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii')
                                                }}
                                            </small>
                                    </td>
                                    <td class="">
                                        <a href="{{ $traseu->path() }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                            class="btn btn-sm btn-primary"
                                            role="button"
                                            >
                                            Raport
                                        </a>        
                                    </td>
                                </tr>
                            @empty
                            @endforelse 
                        </table>
                    <div class="d-flex justify-content-between">
                        <div class="flex flex-vertical-center mx-auto">  
                                    <a href="trasee/toate_orele/2/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                        class="btn btn-success"
                                        role="button"
                                        >
                                        Raport complet {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d.m.Y') }}
                                    </a>
                        </div>
                    </div>

                    @empty
                        <div>Nu există trasee în baza de date. Încearcă alte date de căutare.</div>
                    @endforelse
                </div> 
            </div>   
        </div>
    </div>
@endsection