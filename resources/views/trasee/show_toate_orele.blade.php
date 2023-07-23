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
                <table class="table table-sm" style="border:1px solid #333; width:100%;">
                    <thead>
                        <tr style="height:35px; background-color:#336699; text-align:center; color:white; font-size:0.7rem">
                        <th class="px-0">Nr.<br>crt.</th>
                        <th class="px-0">User</th>
                        <th class="px-0">Nume</th>
                        <th class="px-0">Telefon</th>
                        <th class="px-0">Plecare</th>
                        <th class="px-0">Sosire</th>
                        <th class="px-0">
                            <div style="min-width:90px;">
                                Data<br />plecare
                            </div>
                        </th>
                        <th class="px-0">Ora<br />imbarcare</th>
                        <th class="px-0">Ora<br />aterizare</th>
                        <th class="px-0">Plata</th>
                        <th class="px-0">Nr.<br />pers.</th>
                        <th class="px-0" align="center">Statie<br />imbarcare</th>
                        <th class="px-0" colspan="3">Diverse</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php ($total_persoane = 0)
                        @php ($nr_crt = 1)
                        @forelse($trasee_nume as $traseu_nume)
                        @forelse ($traseu_nume->trasee->sortBy('numar') as $traseu)
                            @forelse ($traseu->curse_ore as $cursa_ora)
                            @forelse ($cursa_ora->rezervari
                                    // ->where('data_cursa', $search)
                                    ->where('activa', 1)->sortByDesc('created_at') as $rezervare)
                                @php ($total_persoane = $total_persoane + $rezervare->nr_adulti + $rezervare->nr_copii)
                                @if ($rezervare->activa == 0)
                                    <tr style="font-size:0.8rem; color:black; height:15px; line-height:30px; border-bottom:solid 1px #99F; background:#99F;">
                                @elseif (empty($rezervare->created_at))
                                    <tr style="font-size:0.8rem; color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F;">
                                @elseif (\Carbon\Carbon::parse($rezervare->created_at)->format('Y-m-d') === $rezervare->data_cursa
                                            && $rezervare->data_cursa === \Carbon\Carbon::today()->format('Y-m-d'))
                                    <tr bgcolor=yellow style="font-size:0.8rem; color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F;">
                                @elseif (in_array($rezervare->telefon, $telefoane_clienti_neseriosi))
                                    <tr style="font-size:0.8rem; color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F; background:#c6fabf">
                                @else
                                    <tr style="font-size:0.8rem; color:black; height:35px; line-height:30px; border-bottom:solid 1px #99F;">
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
                                    <td align="center" style="text-align:left; word-break: break-word;">
                                        {{ $rezervare->nume }}
                                    </td>
                                    <td align="center" style="text-align:left; word-break: break-word;">
                                        {{ $rezervare->telefon }}
                                    </td>
                                    <td align="center">
                                        @if (!empty($cursa_ora->cursa->oras_plecare))
                                            {{ $cursa_ora->cursa->oras_plecare->nume }}
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if (!empty($cursa_ora->cursa->oras_sosire))
                                            {{ $cursa_ora->cursa->oras_sosire->nume }}
                                        @endif
                                    </td>
                                    <td align="center">
                                        {{ $rezervare->data_cursa }}
                                    </td>
                                    <td class="px-0" align="center">
                                        @if(!empty($cursa_ora->ora))
                                            {{ \Carbon\Carbon::parse($cursa_ora->ora)->format('H:i') }}
                                        @endif
                                    </td>
                                    <td class="px-0" align="center">
                                        {{-- @if(!empty($cursa_ora->ora))
                                            {{ \Carbon\Carbon::parse($cursa_ora->ora)
                                                ->addHours(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->hour)
                                                ->addMinutes(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->minute)
                                                ->format('H:i') }}
                                        @endif --}}
                                    {{ $rezervare->zbor_ora_aterizare }}
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
                                    <td align="center" style="word-break: break-word;">
                                        @if(!empty($rezervare->statie_imbarcare))
                                            {{ $rezervare->statie_imbarcare }}
                                        @elseif(!empty($rezervare->statie))
                                            {{ $rezervare->statie->nume }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-0" align="center" style="border-right:#333 1px solid;">
                                        <div style="min-width:90px;">
                                            <div style="float:right; ">
                                                {{-- <form
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

                                                </form>  --}}
                                            @if ($rezervare->activa == 1)
                                                <a class="btn btn-dark btn-sm"
                                                    href="#"
                                                    role="button"
                                                    data-toggle="modal"
                                                    data-target="#activeazaAnuleazaRezervare{{ $rezervare->id }}"
                                                    title="Anulează Rezervarea"
                                                    >
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-success btn-sm"
                                                    href="#"
                                                    role="button"
                                                    data-toggle="modal"
                                                    data-target="#activeazaAnuleazaRezervare{{ $rezervare->id }}"
                                                    title="Activează Rezervarea"
                                                    >
                                                    <i class="fas fa-check-circle"></i>
                                                </a>
                                            @endif

                                                <div class="modal fade text-dark" id="activeazaAnuleazaRezervare{{ $rezervare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-warning">
                                                            <h5 class="modal-title" id="exampleModalLabel">Client: <b>{{ $rezervare->nume }}</b></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            @if ($rezervare->activa == 1)
                                                                Ești sigur ca vrei să anulezi rezervarea?
                                                            @else
                                                                Ești sigur ca vrei să activezi rezervarea?
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST" action="{{ url('rezervari/activa', $rezervare->id) }}">
                                                                @method('PATCH')
                                                                @csrf
                                                                    @if ($rezervare->activa == 1)
                                                                        <button type="submit" class="btn btn-warning">
                                                                            Anulează Rezervare
                                                                        </button>
                                                                    @else
                                                                        <button type="submit" class="btn btn-success">
                                                                            Activează Rezervare
                                                                        </button>
                                                                    @endif
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                    title="Editează Rezervarea"
                                                    >
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
                        @empty
                        @endforelse
                        </tbody>
                    </table>

                    <p class="text-center">
                        <b>TOTAL PERSOANE: {{ $total_persoane }}</b>
                    </p>

                    <div class="d-flex justify-content-around">
                        {{-- <a href="/trasee/toate_orele/{{ $trasee_nume->id }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}/export/traseu-pdf-toate-orele"
                            class="btn btn-success"
                            role="button"
                            target="_blank"
                            >
                            <i class="fas fa-file-pdf"></i> Raport cumulat
                        </a> --}}
                        <a href="/trasee/toate_orele/{{ $traseu_nume->id }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}/export/traseu-pdf-toate-orele-per-ora"
                            class="btn btn-success"
                            role="button"
                            target="_blank"
                            >
                            <i class="fas fa-file-pdf"></i> Raport complet {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d.m.Y') }}
                        </a>

                        @if ($traseu_nume->id == 3)
                            <a href="/trasee/toate_orele/{{ $traseu_nume->id }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}/export/traseu-pdf-toate-orele"
                                class="btn btn-secondary"
                                role="button"
                                target="_blank"
                                >
                                <i class="fas fa-file-pdf"></i> Raport compact {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d.m.Y') }}
                            </a>
                        @endif
                    </div>

    </div>
@endsection
