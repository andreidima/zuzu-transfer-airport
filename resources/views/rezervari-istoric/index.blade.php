@extends ('layouts.app')

@section('content')   
    <div class="container card">
        <div class="row card-header px-0">
            <div class="col-lg-4">
                <h4 class="mt-2"><a href="/rezervari-istoric" style="color:#408080"><i class="fas fa-file-alt mr-1"></i>Rezervări - istoric</a></h4>
            </div> 
            <div class="col-lg-8 mb-2">             
                <form class="needs-validation" novalidate method="GET" action="/rezervari-istoric">
                    @csrf                    
                    <div class="input-group custom-search-form">
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="search_nume_telefon" placeholder="Caută nume sau telefon...">
                        </div>
                        <div class="col-lg-1">
                            <span class="input-group-btn">
                                <button class="btn btn-default-sm" type="submit" style="background-color:#408080">
                                    <i class="fas fa-search text-white"></i>
                                </button>
                            </span>
                        </div>
                        <div class="col-lg-3">                            
                            <input type="text" class="form-control" name="search_cod_bilet" placeholder="Caută cod bilet...">
                        </div>
                        <div class="col-lg-3">                            
                            <input type="text" class="form-control" name="search_user" placeholder="Caută utilizator...">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <div>
        <table class="table table-sm" style="border:1px solid #333; width:100%;"> 
            <thead>
                <tr style="height:35px; background-color:#408080; text-align:center; color:white; font-size:0.7rem">
                <th class="px-0">Nr.<br>crt.</th>
                @if (auth()->user()->isDispecer())
                    <th class="px-0">User</th>
                @endif
                @if (auth()->user()->isDispecer())
                    <th style="min-width:150px;">Nume</th>
                @else
                    <th style="min-width:120px;">Nume</th>
                @endif
                <th style="min-width:140px;">Telefon</th>
                <th>Plecare</th>
                <th>Sosire</th>
                <th>
                    <div style="min-width:90px;">
                        Data<br />plecare
                    </div>
                </th>
                @if (!auth()->user()->isDispecer())
                    <th class="px-0">Decolare</th>
                @endif
                <th class="px-0">Ora<br />aterizare</th>
                <th class="px-0">Ora<br />imbarcare</th>
                <th>Plata</th>
                <th class="px-0">Nr.<br />pers.</th>
                <th align="center" class="px-0">Statie<br />imb.</th>
                <th>Operațiune</th>
                <th class="px-0">Data<br />operațiune</th>
                </tr>
            </thead>
            <tbody>               
                @forelse ($rezervari as $rezervare)                         
                    @if ($rezervare->activa == 0)
                        <tr style="color:black; height:15px; line-height:30px; border-bottom:solid 1px #99F; background:#99F;">
                    @elseif (\Carbon\Carbon::parse($rezervare->created_at)->format('Y-m-d') === $rezervare->data_cursa
                                && $rezervare->data_cursa === \Carbon\Carbon::today()->format('Y-m-d')
                                && ($rezervare->cursa->plecare_id === 8))
                        <tr bgcolor=yellow style="color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F;">
                    @elseif (\Carbon\Carbon::parse($rezervare->created_at)->format('Y-m-d') === $rezervare->data_cursa
                                && $rezervare->data_cursa === \Carbon\Carbon::today()->format('Y-m-d')
                                && ($rezervare->cursa->plecare_id !== 8)
                                && (!in_array($rezervare->ora_id, [293, 294, 307])))
                        <tr style="color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F; background-color:palegoldenrod">
                    @elseif (in_array($rezervare->telefon, $telefoane_clienti_neseriosi))
                        <tr style="color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F; background:#c6fabf"> 
                    @else
                        <tr style="color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F;">
                    @endif    
                    
                        <td align="center" class="px-0">
                            {{ $loop->iteration }}
                        </td>

                        @if (auth()->user()->isDispecer())
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
                                        <div class="modal-dialog modal-dialog-centered">
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
                                        <div class="modal-dialog modal-dialog-centered">
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
                        @endif
                        
                        <td align="center" style="text-align:left; word-break: break-word;">
                            <a href="{{ $rezervare->path() }}">
                                <span title="Cod bilet: RO{{ $rezervare->id }}">
                                        {{ $rezervare->nume }}
                                </span>
                            </a>
                        </td>
                        <td align="center" style="text-align:left; word-break: break-word;">
                                {{ $rezervare->telefon }}
                        </td>
                        <td align="center">
                            @if (!empty($rezervare->cursa->oras_plecare))
                                {{ $rezervare->cursa->oras_plecare->nume }}
                            @endif
                        </td>
                        <td align="center">
                            @if (!empty($rezervare->cursa->oras_sosire))
                                {{ $rezervare->cursa->oras_sosire->nume }}
                            @endif
                        </td>
                        <td align="center">
                            {{ $rezervare->data_cursa }}
                        </td>

                        @if (!auth()->user()->isDispecer())
                            <td align="center" style="text-align:left; word-break: break-word;">
                                {{ $rezervare->zbor_oras_decolare }}
                            </td>
                        @endif

                        <td align="center">
                            {{ $rezervare->zbor_ora_aterizare }}
                        </td>
                        <td align="center">                                
                            {{ \Carbon\Carbon::parse($rezervare->ora)->format('H:i') }}
                        </td>
                        <td class="px-0" align="center">
                            @if($rezervare->tip_plata_id === 3)
                                <img src="{{ asset('images/card.jpg') }}" height="">
                            @elseif(!empty($rezervare->tip_plata))
                                {{ $rezervare->tip_plata->nume }}
                            @else
                                -
                            @endif                                
                        </td>
                        <td align="center">
                            {{ $rezervare->nr_adulti + $rezervare->nr_copii}}</a>
                        </td>
                        <td class="px-0" align="center" style="word-break: break-word;">
                            @if (auth()->user()->isDispecer())
                                @if(!empty($rezervare->statie_imbarcare))
                                    <!-- Button to Open the Modal -->
                                    <button type="button"
                                        class="btn btn-white btn-sm"
                                        data-toggle="modal"
                                        data-target="#rezervareStatie{{ $rezervare->id }}"
                                        title="{{ $rezervare->statie_imbarcare }}">
                                        <img src="{{ asset('images/icon-details.png') }}" height="">
                                    </button>

                                    <!-- The Modal -->
                                    <div class="modal" id="rezervareStatie{{ $rezervare->id }}" >
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h6 class="modal-title">Client: {{ $rezervare->nume }}</h6>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <h6 class="modal-title">Îmbarcare: {{ $rezervare->statie_imbarcare }}</h6>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                @elseif(!empty($rezervare->statie))
                                    <!-- Button to Open the Modal -->
                                    <button type="button" 
                                        class="btn btn-white btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#rezervareStatie{{ $rezervare->id }}"
                                        title="{{ $rezervare->statie->nume }}">
                                        <img src="{{ asset('images/icon-details.png') }}" height="">
                                    </button>

                                    <!-- The Modal -->
                                    <div class="modal" id="rezervareStatie{{ $rezervare->id }}" >
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h6 class="modal-title">Client: {{ $rezervare->nume }}</h6>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <h6 class="modal-title">Îmbarcare: {{ $rezervare->statie->nume }}</h6>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                @else
                                    -
                                @endif
                            @else
                                {{ $rezervare->statie_imbarcare }}
                            @endif
                        </td>
                        <td class="px-0" align="center">
                            {{ $rezervare->operatie }}
                        </td> 
                        <td class="px-0" align="center">
                            {{ \Carbon\Carbon::parse($rezervare->data_operatie)->isoFormat('HH:mm D.MM.YYYY') ?? '' }}
                        </td>                       
                    </tr>                                          
                @empty
                    {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                @endforelse
                </tbody>
        </table>
            <p class="text-center">
            Pagina nr. {{$rezervari->currentPage()}}
            </p>

            <nav>
                <ul class="pagination justify-content-center">
                    {{$rezervari->appends(Request::except('page'))->links()}}
                </ul>
            </nav> 

    </div>
@endsection