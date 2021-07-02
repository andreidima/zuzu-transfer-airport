@extends ('layouts.app')

@section('content')
    <div class="container card">
        <div class="row card-header px-0">
            <div class="col-lg-2">
                <h4 class="mt-2"><a href="/rezervari"
                    {{-- style="color:#408080" --}}
                >
                    <i class="fas fa-file-alt mr-1"></i>Rezervări</a>
                </h4>
            </div>
            <div class="col-lg-8 mb-2">
                <form class="needs-validation" novalidate method="GET" action="/rezervari">
                    @csrf
                    <div class="input-group custom-search-form">
                        <div class="w-50">
                            <input type="text" class="form-control" name="search_nume_telefon" placeholder="Caută nume sau telefon...">
                        </div>
                        <div class="mx-4">
                            <span class="input-group-btn">
                                <button class="btn btn-default-sm btn-primary" type="submit"
                                    {{-- style="background-color:#408080" --}}
                                >
                                    <i class="fas fa-search text-white"></i>
                                </button>
                            </span>
                        </div>
                        <div class="w-25">
                            <input type="text" class="form-control" name="search_cod_bilet" placeholder="Caută cod bilet...">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-2">
                <a class="btn btn-success text-white" href="/rezervari/adauga" role="button"
                    {{-- style="background-color:#408080" --}}
                >
                    Adaugă Rezervare
                </a>
            </div>
        </div>
    </div>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <div class="py-3">
        @if (!auth()->user()->isDispecer())
            <span class="mx-3">
                *Rezervările pot fi modificate integral timp de 30 de minute de la adăugare!
            </span>
        @endif
        <table class="table table-sm" style="border:1px solid #333; width:100%;">
            <thead>
                <tr style="height:35px; background-color:#EF9A3E; text-align:center; color:white; font-size:0.7rem">
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
                <th class="px-0">Bilet</th>
                @if (auth()->user()->isDispecer())
                    <th class="px-0" colspan="3">Diverse</th>
                @else
                    <th class="px-0">Editare</th>
                @endif
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
                                <span title="Cod bilet: RO{{ $rezervare->id }}">
                                        {{ $rezervare->nume }}
                                </span>
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
                            <div style="width:25px; height:25px;" class="bg-success mt-1">
                                <a href="{{ $rezervare->path() }}/export/rezervare-pdf"
                                    role="button"
                                    target="_blank"
                                    title="Descarcă bilet"
                                    >
                                    <i class="fas fa-download text-white"></i>
                                </a>
                            </div>
                        </td>
                        <td align="center" style="border-right:#333 1px solid;" class="px-0">
                            @if (auth()->user()->isDispecer())
                                <div style="min-width:90px;">
                                    <div style="float:right; ">
                                        @if ($rezervare->activa == 1)
                                            <a class="btn btn-dark btn-sm"
                                                href="#"
                                                role="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#activeazaAnuleazaRezervare{{ $rezervare->id }}"
                                                title="Anulează Rezervarea"
                                                >
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-success btn-sm"
                                                href="#"
                                                role="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#activeazaAnuleazaRezervare{{ $rezervare->id }}"
                                                title="Activează Rezervarea"
                                                >
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                        @endif

                                            <div class="modal fade text-dark" id="activeazaAnuleazaRezervare{{ $rezervare->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title" id="exampleModalLabel">Client: <b>{{ $rezervare->nume }}</b></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        @if ($rezervare->activa == 1)
                                                            Ești sigur ca vrei să anulezi rezervarea?
                                                        @else
                                                            Ești sigur ca vrei să activezi rezervarea?
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

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
                                        <a class="btn btn-danger btn-sm text-white"
                                            href="#"
                                            role="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#stergeRezervare{{ $rezervare->id }}"
                                            title="Șterge Rezervarea"
                                            >
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeRezervare{{ $rezervare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Client: <b>{{ $rezervare->nume }}</b></h5>
                                                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi rezervarea?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                                                        <form method="POST" action="{{ $rezervare->path() }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger text-white"
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
                            @else
                                        <a href="{{ $rezervare->path() }}/modifica"
                                            title="Editează Rezervarea"
                                            >
                                            <img src="{{ asset('images/icon-edit.jpg') }}" height="26px">
                                        </a>
                            @endif
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
