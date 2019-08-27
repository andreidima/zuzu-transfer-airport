@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/statistica"><i class="fas fa-route mr-1"></i>Statistică</a></h4>
            </div> 
                <div class="">             
                    <form class="needs-validation" novalidate method="GET" action="/statistica">
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
                <div class="col-lg-2 container-fluid px-0 table-responsive-lg border mb-4">    
                    @forelse ($trasee_nume_tecuci_otopeni as $traseu_nume)                     
                        <h5 class="p-2 bg-secondary text-white mb-0 text-center">{{$traseu_nume->nume}}</h5>
                        <table class="table table-sm table-striped text-center mb-0">
                            @php
                                $total_persoane_tecuci_otopeni = 0;
                            @endphp
                            @forelse ($traseu_nume->trasee as $traseu)                           
                                
                                <tr>   
                                @php
                                    $cursa_ora = $traseu->curse_ore->first();
                                    
                                    $total_persoane_tecuci_otopeni += 
                                        $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                        +
                                        $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii');
                                @endphp
                                    <td style="">
                                            @if(!empty(\Carbon\Carbon::parse($cursa_ora->ora)))
                                                <a href="{{ $traseu->path() }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                                    class="text-dark">
                                                    {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                                </a>
                                            @endif    
                                    </td>
                                    <td style="">
                                        <h5 class="m-0 p-0">
                                            <span class="badge badge-secondary" style="background-color:#408080;">
                                                {{
                                                    $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                    +
                                                    $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii')
                                                }}
                                            </span>
                                        </h5>
                                    </td>
                                </tr>
                            @empty
                            @endforelse 
                                <tr class="text-white" style="background-color:#408080;">
                                    <td>Total</td>
                                    <td>
                                        {{ $total_persoane_tecuci_otopeni }}
                                        pers
                                    </td>
                                </tr>
                        </table>

                    @empty
                        <div>Nu există trasee în baza de date. Încearcă alte date de căutare.</div>
                    @endforelse
                </div>  


                
                <div class="col-lg-2 container-fluid px-0 table-responsive-lg border mb-4">    
                    @forelse ($trasee_nume_galati_otopeni as $traseu_nume)                     
                        <h5 class="p-2 bg-secondary text-white mb-0 text-center">{{$traseu_nume->nume}}</h5>
                        <table class="table table-sm table-striped text-center mb-0">
                            @php
                                $total_persoane_galati_otopeni = 0;
                            @endphp
                            @forelse ($traseu_nume->trasee as $traseu)
                                <tr>      
                                @php 
                                    $cursa_ora = $traseu->curse_ore->first();
                                    
                                    $total_persoane_galati_otopeni += 
                                        $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                        +
                                        $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii');
                                @endphp
                                    <td style="">
                                            @if(!empty(\Carbon\Carbon::parse($cursa_ora->ora)))
                                                <a href="{{ $traseu->path() }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                                    class="text-dark">
                                                    {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                                </a>
                                            @endif 
                                    </td>
                                    <td style="">
                                        <h5 class="m-0 p-0">
                                            <span class="badge badge-secondary" style="background-color:#408080;">
                                                {{
                                                    $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                    +
                                                    $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii')
                                                }}
                                            </span>
                                        </h5>
                                    </td>
                                </tr>
                            @empty
                            @endforelse 
                                <tr class="text-white" style="background-color:#408080;">
                                    <td>Total</td>
                                    <td>
                                        {{ $total_persoane_galati_otopeni }}
                                        pers
                                    </td>
                                </tr>
                        </table>

                    @empty
                        <div>Nu există trasee în baza de date. Încearcă alte date de căutare.</div>
                    @endforelse
                </div> 


                <div class="col-lg-2 container-fluid px-0 table-responsive-lg border"> 
                    <h5 class="p-2 bg-secondary text-white mb-0 text-center">Otopeni</h5>
                        <table class="table table-sm table-striped text-center mb-0">   
                            @php
                                $nr_rezervari[] = array();    
                                $total_persoane_otopeni = 0;
                            @endphp
                            @forelse ($trasee_nume_otopeni as $traseu_nume)
                                @forelse ($traseu_nume->trasee as $traseu) 
                                        @php                                             
                                            $total_persoane_otopeni += 
                                                $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                +
                                                $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii');
                                        @endphp
                                        <tr>  
                                            <td style="">
                                                {{ \Carbon\Carbon::parse($traseu->curse_ore->first()->ora)->format('H:i') }}     
                                            </td>
                                            <td style="">
                                                <h5 class="m-0 p-0">
                                                    <span class="badge badge-secondary" style="background-color:#408080;">
                                                        {{
                                                            $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                            +
                                                            $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii') 
                                                        }}
                                                    </span>
                                                </h5>
                                            </td>
                                        </tr> 
                                {{-- @empty
                                @endforelse --}}
                                @empty
                                @endforelse
                            @empty
                            @endforelse
                                <tr class="text-white" style="background-color:#408080;">
                                    <td>Total</td>
                                    <td>
                                        {{ $total_persoane_otopeni }}
                                        pers
                                    </td>
                                </tr>
                        </table>
                </div> 



            </div>   
        </div>
    </div>
@endsection