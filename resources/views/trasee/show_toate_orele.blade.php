@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/trasee"><i class="fas fa-route mr-1"></i>Trasee</a></h4>
            </div> 
        </div>
    </div>

    <div class="container-fluid px-0 table-responsive-lg">
        @switch($trasee_nume->id)
            @case(1)   
                {{-- Traseu Tecuci - Otopeni --}}
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
                        @php ($total_persoane = 0)
                        @php ($nr_crt = 1)
                        @forelse ($trasee_nume->trasee as $traseu)
                            @forelse ($traseu->curse_ore as $cursa_ora)   
                            @forelse ($cursa_ora->rezervari->where('data_cursa', $search)->where('activa', 1) as $rezervare)  
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
                                        {{ $nr_crt++ }}
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
                                    <td align="center">  
                                        @if(!empty($rezervare->ora))    
                                            {{ \Carbon\Carbon::parse($rezervare->ora->ora)->format('H:i') }}
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if(!empty($rezervare->ora))    
                                            {{ \Carbon\Carbon::parse($rezervare->ora->ora)
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
                                        @elseif(!empty($rezervare->statie_imbarcare))
                                            {{ $rezervare->statie_imbarcare }}
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
                            @empty
                            @endforelse                                         
                            @empty
                                <div>Nu sunt rezervari pentru acest traseu</div>
                            @endforelse                                    
                        @empty
                        @endforelse  
                        </tbody>
                    </table>
                    
                    <p class="text-center">
                        <b>TOTAL PERSOANE: {{ $total_persoane }}</b>
                    </p>

                    <div class="text-center">
                        {{-- <a href="/trasee/toate_orele/{{ $trasee_nume->id }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}/export/traseu-pdf-toate-orele"
                            class="btn btn-success"
                            role="button"
                            target="_blank"
                            >
                            <i class="fas fa-file-pdf"></i> Raport cumulat
                        </a> --}}
                        <a href="/trasee/toate_orele/{{ $trasee_nume->id }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}/export/traseu-pdf-toate-orele-per-ora"
                            class="btn btn-success"
                            role="button"
                            target="_blank"
                            >
                            <i class="fas fa-file-pdf"></i> Raport complet {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d.m.Y') }}
                        </a>
                    </div>


                @break
            @case(2)
                {{-- Traseu Otopeni - Tecuci/Galati --}}
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
                        @php ($total_persoane = 0)
                            @forelse ($rezervari as $rezervare)    
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
                                    <td align="center">  
                                        @if(!empty($rezervare->ora))    
                                            {{ \Carbon\Carbon::parse($rezervare->ora->ora)->format('H:i') }}
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if(!empty($rezervare->ora))    
                                            {{ \Carbon\Carbon::parse($rezervare->ora->ora)
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
                            @empty
                                <div>Nu sunt rezervari pentru acest traseu</div>
                            @endforelse    
                        </tbody>
                    </table>
                    
                    <p class="text-center">
                        <b>TOTAL PERSOANE: {{ $total_persoane }}</b>
                    </p>

                    <div class="text-center">
                        <a href="/trasee/toate_orele/{{ $trasee_nume->id }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}/export/traseu-pdf-toate-orele-per-ora"
                            class="btn btn-success"
                            role="button"
                            target="_blank"
                            >
                            <i class="fas fa-file-pdf"></i> Raport complet {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d.m.Y') }}
                        </a>
                    </div>
                </h5>
                @break
            @case(3)    
                {{-- Traseu Galati - Otopeni --}} 
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
                        @php ($total_persoane = 0)
                        @php ($nr_crt = 1)
                        @forelse ($trasee_nume->trasee as $traseu)
                            @forelse ($traseu->curse_ore as $cursa_ora)   
                            @forelse ($cursa_ora->rezervari->where('data_cursa', $search)->where('activa', 1) as $rezervare)  
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
                                        {{ $nr_crt++ }}
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
                                    <td align="center">  
                                        @if(!empty($rezervare->ora))    
                                            {{ \Carbon\Carbon::parse($rezervare->ora->ora)->format('H:i') }}
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if(!empty($rezervare->ora))    
                                            {{ \Carbon\Carbon::parse($rezervare->ora->ora)
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
                            @empty
                            @endforelse                                         
                            @empty
                                <div>Nu sunt rezervari pentru acest traseu</div>
                            @endforelse                                    
                        @empty
                        @endforelse  
                        </tbody>
                    </table>
                    
                    <p class="text-center">
                        <b>TOTAL PERSOANE: {{ $total_persoane }}</b>
                    </p>

                    <div class="text-center">
                        {{-- <a href="/trasee/toate_orele/{{ $trasee_nume->id }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}/export/traseu-pdf-toate-orele"
                            class="btn btn-success"
                            role="button"
                            target="_blank"
                            >
                            <i class="fas fa-file-pdf"></i> Raport cumulat
                        </a> --}}
                        <a href="/trasee/toate_orele/{{ $trasee_nume->id }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}/export/traseu-pdf-toate-orele-per-ora"
                            class="btn btn-success"
                            role="button"
                            target="_blank"
                            >
                            <i class="fas fa-file-pdf"></i> Raport complet {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d.m.Y') }}
                        </a>
                    </div>
                @break
            @case(4)     
                {{-- Nu mai este necesar, pentru ca se scot cumulat toate plecarile din Otopeni la case(2) --}}                 
                <h5 class="p-3 mb-2 bg-secondary text-white">                                
                    {{-- {{$trasee->traseu_nume->nume}}:
                    traseu nr. {{$trasee->numar}} --}}
                </h5>
                @break
        @endswitch                
                  
    </div>
@endsection