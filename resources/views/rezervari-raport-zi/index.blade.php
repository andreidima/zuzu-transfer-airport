@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="card-header">
            <div class="">
                <h4 class="mt-2"><i class="fas fa-file-alt mr-1"></i>Rezervari - extragere rapoarte</h4>
            </div> 
        </div>
        <div class="card-body">
            <div class="" id="rezervari-raport-zi">
                <form class="needs-validation" novalidate method="GET" action="/rezervari-raport-zi">
                    @csrf                    
                    <div class="input-group custom-search-form row d-flex justify-content-center m-0">
                        <div class="form-group d-flex col-8 justify-content-center">
                            <div class="mr-4 w-25">
                                <label for="search_data_inceput" class="mb-0">Data început</label>
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
                            <div class="mr-4 w-25">
                                <label for="search_data_inceput" class="mb-0">Data sfârșit</label>
                                <vue2-datepicker
                                    @if (!empty($search_data_inceput))
                                        data-veche="{{ $search_data_sfarsit }}"
                                    @endif
                                    nume-camp-db="search_data_sfarsit"
                                    tip="date"
                                    latime="150"
                                    {{-- data-veche="{{\Carbon\Carbon::today()}}" --}}
                                ></vue2-datepicker>
                            </div>
                            <div class="mr-4 w-25">
                                <script type="application/javascript"> 
                                    searchOrasVechi={!! json_encode($search_oras, "0") !!}
                                </script>  
                                <label for="search_oras" class="mb-0">Plecare din:</label>
                                    <select class="custom-select"
                                        name="search_oras"
                                        v-model="search_oras"
                                    @change='getOrePlecare()'
                                    >
                                            <option v-for='search_oras in orase_plecare'                                
                                            :value='search_oras.id'                                       
                                            >@{{search_oras.nume}}</option>
                                    </select>
                            </div>
                            <div class="w-25">
                                <script type="application/javascript"> 
                                    searchOraVeche={!! json_encode($search_ora, "0") !!}
                                </script>        
                                <label for="search_ora" class="mb-0">Ora de plecare:</label>
                                    <select class="custom-select"
                                        name="search_ora"
                                        v-model="search_ora"
                                    >
                                        {{-- <option value="0">Selectează Oras sosire</option> --}}
                                        <option v-for='search_ora in ore_plecare'                                
                                            :value='search_ora.id'                                       
                                            >
                                            @{{search_ora.ora}}
                                        </option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group d-flex align-self-end col-12 justify-content-center"> 
                            <button class="btn bg-primary text-white mr-4" type="submit">
                                <i class="fas fa-search"></i>Caută rezervări
                            </button>
                            <a class="btn bg-secondary text-white" href="/rezervari-raport-zi" role="button">
                                Resetează
                            </a>
                        </div>                  
                    </div>

                    <div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid px-0 table-responsive-lg">
        {{-- Traseu Otopeni - Tecuci/Galati --}} 
                @php ($total_persoane = 0)
                    @forelse ($rezervari as $rezervare)    

                        @if ($loop->first)
                            <table class="table table-sm" style="border:1px solid #333; width:100%;"> 
                                <thead>
                                    <tr style="height:35px; background-color:#336699; text-align:center; color:white;">
                                    <th>Nr.<br>crt.</th>
                                    <th>User</th>
                                    <th>Nume</th>
                                    <th>Telefon</th>
                                    <th>Plecare</th>
                                    <th>Sosire</th>
                                    <th>
                                        <div style="min-width:80px;">
                                            Data<br />plecare
                                        </div>
                                    </th>
                                    <th>Ora<br />imbarcare</th>
                                    <th>Ora<br />debarcare</th>
                                    <th>Plata</th>
                                    <th>Nr.<br />pers.</th>
                                    <th align="center">Statie<br />imbarcare</th>
                                    <th colspan="3">Diverse</th>
                                    </tr>
                                </thead>
                                <tbody>                             
                        @endif

                        @php ($total_persoane = $total_persoane + $rezervare->nr_adulti + $rezervare->nr_copii)
                        @if ($rezervare->activa == 0)
                            <tr style="color:black; height:15px; line-height:30px; border-bottom:solid 1px #99F; background:#99F;">
                        @elseif (empty($rezervare->created_at))
                            <tr style="color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F;">
                        @elseif (\Carbon\Carbon::parse($rezervare->created_at)->format('Y-m-d') == $rezervare->data_cursa)
                            <tr bgcolor=yellow style="color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F;">
                        @else
                            <tr style="color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F;">
                        @endif    
                        
                            <td align="center">
                                {{ $loop->iteration }}
                            </td>
                            <td align="center">
                                @if (empty($rezervare->user))
                                            <span style="color:#3672ED; font-size:1.5rem; font-weight: bold;">
                                                C
                                            </span>
                                @elseif ($rezervare->user->firma->id == 1)                                                                                
                                    <a href="#" 
                                        role="button"
                                        data-toggle="modal" 
                                        data-target="#userRezervare{{ $rezervare->id }}"
                                        title="{{ $rezervare->user->nume }}"
                                        >
                                            <span style="color:#ed8336; font-size:1.5rem; font-weight: bold;">
                                                D
                                            </span>
                                    </a>                                    

                                    <!-- The Modal -->
                                    <div class="modal" id="userRezervare{{ $rezervare->id }}" >
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h6 class="modal-title">Client: {{ $rezervare->nume }}</h6>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <h6 class="modal-title">Dispecer: {{ $rezervare->user->nume }}</h6>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                @else                                                                            
                                    <a href="#" 
                                        role="button"
                                        data-toggle="modal" 
                                        data-target="#userRezervare{{ $rezervare->id }}"
                                        title="{{ $rezervare->user->firma->nume }}"
                                        >
                                            <span style="color:#36BE39; font-size:1.5rem; font-weight: bold;">
                                                A
                                            </span>
                                    </a>                                    

                                    <!-- The Modal -->
                                    <div class="modal" id="userRezervare{{ $rezervare->id }}" >
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h6 class="modal-title">Client: {{ $rezervare->nume }}</h6>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <h6 class="modal-title">Agenție: {{ $rezervare->user->firma->nume }}</h6>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td align="center" style="text-align:left;">
                                {{ $rezervare->nume }}
                            </td>
                            <td align="center" style="text-align:left;">
                                {{ $rezervare->telefon }}
                            </td>
                            <td align="center">
                                @if (!empty($rezervare->cursa->oras_plecare))
                                    @if ($rezervare->cursa->oras_plecare->nume === 'Ramnicu Sarat')
                                        Rm.Sarat
                                    @else
                                        {{$rezervare->cursa->oras_plecare->nume}}
                                    @endif
                                @endif
                            </td>
                            <td align="center">
                                @if (!empty($rezervare->cursa->oras_sosire))
                                    @if ($rezervare->cursa->oras_sosire->nume === 'Ramnicu Sarat')
                                        Rm.Sarat
                                    @else
                                        {{$rezervare->cursa->oras_sosire->nume}}
                                    @endif
                                @endif
                            </td>
                            <td align="center">
                                {{ $rezervare->data_cursa }}
                            </td>
                            <td align="center">  
                                @if(!empty($rezervare->ora))    
                                    {{ \Carbon\Carbon::parse($rezervare->ora)->format('H:i') }}
                                @endif
                            </td>
                            <td align="center">
                                @if(!empty($rezervare->ora))    
                                    {{ \Carbon\Carbon::parse($rezervare->ora)
                                        ->addHours(\Carbon\Carbon::parse($rezervare->cursa->durata)->hour)
                                        ->addMinutes(\Carbon\Carbon::parse($rezervare->cursa->durata)->minute)
                                        ->format('H:i') }}  
                                @endif
                            </td>
                            <td align="center">
                                @if(!empty($rezervare->tip_plata))
                                    {{ $rezervare->tip_plata->nume }}
                                @else
                                    -
                                @endif                                
                            </td>
                            <td align="center">
                                {{ $rezervare->nr_adulti + $rezervare->nr_copii}}</a>
                            </td>
                            <td align="center">
                                @if(!empty($rezervare->statie))
                                    {{ $rezervare->statie->nume }}
                                @else
                                    -
                                @endif
                            </td>
                            <td align="center" style="border-right:#333 1px solid;">   
                                <div style="min-width:90px;">
                                    <div style="float:right; ">  
                                        <form  
                                            class="needs-validation" novalidate 
                                            method="POST" action="{{ url('rezervari/activa', $rezervare->id) }}">
                                                @method('PATCH')
                                                @csrf  
                                            
                                            @if ($rezervare->activa == 1) 
                                                <button type="submit" class="btn btn-dark btn-sm" title="Anulează Rezervarea">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm" title="Activează Rezervarea">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            @endif
                                            
                                        </form> 
                                    </div> 

                                    <div style="float:right;" class="">
                                        <a class="btn btn-danger btn-sm" 
                                            href="#" 
                                            role="button"
                                            data-toggle="modal" 
                                            data-target="#stergeRezervare{{ $rezervare->id }}"
                                            title="Șterge Rezervarea"
                                            >
                                            <i class="far fa-trash-alt"></i>
                                        </a>
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
                                                                Șterge Rezervare
                                                            </button>                    
                                                        </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> 

                                    <div style="float:right;" class="">
                                        <a href="{{ $rezervare->path() }}/modifica"
                                            {{-- class="btn btn-primary btn-sm"
                                            role="button" --}}
                                            title="Editează Rezervarea"
                                            >
                                            {{-- <i class="fas fa-edit"></i> --}}
                                            <img src="{{ asset('images/icon-edit.jpg') }}" height="26px">
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>  
                        
                        @if ($loop->last) 
                                </tbody>
                            </table>
                        @endif
                    @empty
                            {{-- <p>
                                Nu exista rezervari dupa aceste campuri de cautare
                            </p> --}}
                    @endforelse   
                {{-- <nav>
                    <ul class="pagination justify-content-center">
                        @if ($rezervari instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {{$rezervari->links('vendor.pagination.bootstrap-4')}}
                        @endif
                    </ul>
                </nav>  --}}

    </div>
@endsection