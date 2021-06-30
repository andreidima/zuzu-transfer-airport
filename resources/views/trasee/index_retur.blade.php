@extends ('layouts.app')

@section('content')
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/trasee/retur"><i class="fas fa-route mr-1"></i>Traseu RETUR</a></h4>
            </div>
                <div class="">
                    <form class="needs-validation" novalidate method="GET" action="/trasee/retur">
                        @csrf
                        <div class="input-group custom-search-form" id="app1">
                            {{-- <input type="text" class="form-control" name="search" placeholder="Caută..."> --}}
                                        <vue2-datepicker
                                            data-veche="{{ $search }}"
                                            nume-camp-db="search"
                                            tip="date"
                                            latime="150"
                                            {{-- data-veche="{{\Carbon\Carbon::today()}}" --}}

                                            {{-- Submiterea automata a formei la updatarea calendarului --}}
                                            @updated="submit_form"
                                        ></vue2-datepicker>
                            <span class="input-group-btn">
                                <button class="btn btn-default-sm bg-primary" style="height: 34px;" type="submit"
                                    {{-- Referinta pentru trimiterea automata a comenzii de submit  --}}
                                    ref="submitBtn"
                                >
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
                <div class="col-lg-2 container-fluid px-0 table-responsive-lg border">
                    <h5 class="p-2 bg-secondary text-white mb-0 text-center">Otopeni</h5>
                        <table class="table table-sm table-striped text-center mb-2">
                            @php
                                $nr_rezervari[] = array();
                            @endphp
                            @forelse ($trasee_nume_otopeni as $traseu_nume)
                                {{-- @if ($loop->first)
                                    @forelse ($traseu_nume->trasee as $traseu)
                                        @php
                                            $nr_rezervari[$loop->index] =
                                                $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                +
                                                $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii')
                                        @endphp
                                    @empty
                                    @endforelse
                                @elseif ($loop->last) --}}
                                    @forelse ($traseu_nume->trasee as $traseu)
                                        {{-- @php
                                            dd($loop->index);
                                            $nr_rezervari[$loop->index] +=
                                                $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                +
                                                $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii')
                                        @endphp  --}}
                                        <tr>
                                            <td class="" style="line-height:1;">
                                                <a href="{{ $traseu->path() }}/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                                    class="text-dark"
                                                    role="button"
                                                    style="line-height:1;"
                                                    >
                                                    <div class="row align-items-center">
                                                        <div class="col-5">
                                                            {{ \Carbon\Carbon::parse($traseu->curse_ore->first()->ora)->format('H:i') }}
                                                        </div>
                                                        <div class="col-4">
                                                            @php
                                                                $nr_persoane =
                                                                    $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                                    +
                                                                    $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii')
                                                            @endphp
                                                            <span title="Total pasageri" class={{ $nr_persoane > 0 ? "text-danger" : '' }}>
                                                                {{ $nr_persoane }}
                                                            </span>
                                                        </div>
                                                        <div class="col-3">
                                                            <i class="fas fa-file-pdf fa-2x text-primary bg-white"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                {{-- @else
                                    @forelse ($traseu_nume->trasee as $traseu)
                                        @php
                                            $nr_rezervari[$loop->index] =
                                                $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_adulti')
                                                +
                                                $traseu->rezervari->where('data_cursa', $search)->where('activa', 1)->sum('nr_copii')
                                        @endphp
                                    @empty
                                    @endforelse
                                @endif --}}
                            @empty
                            @endforelse
                        </table>
                    <div class="d-flex justify-content-between">
                        <div class="flex flex-vertical-center mx-auto">
                                    <a href="/trasee/toate_orele/3/{{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d-m-Y') }}"
                                        class="btn btn-success"
                                        role="button"
                                        >
                                        Raport complet {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d.m.Y') }}
                                    </a>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Afisarea initiala pentru Otopeni-Tecuci --}}
            {{-- <div class="row justify-content-center mb-4">
                <div class="col-12 mb-4">
                    @forelse ($trasee_nume_otopeni_tecuci as $traseu_nume)
                    <div class="d-flex justify-content-between bg-secondary text-white">
                        <div class="flex flex-vertical-center">
                            <h5 class="p-3 mb-0">Traseu: {{$traseu_nume->nume}}</h5>
                        </div>
                        <div>
                            <h5 class="p-3 mb-0">Data: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d.m.Y') }}</h5>
                        </div>
                    </div>
                    <table class="table table-sm table-striped text-center">
                        @forelse ($traseu_nume->trasee as $traseu)
                            @if ($loop->first)
                                <tr>
                                        @forelse ($traseu->curse_ore as $cursa_ora)
                                            @if ($loop->first)
                                                <td>
                                                    {{$cursa_ora->cursa->oras_plecare->nume}}
                                                </td>
                                                <td>
                                                    {{$cursa_ora->cursa->oras_sosire->nume}}
                                                </td>
                                            @else
                                                <td>
                                                    {{$cursa_ora->cursa->oras_sosire->nume}}
                                                </td>
                                            @endif
                                        @empty
                                        @endforelse
                                </tr>
                            @endif

                            <tr>
                            @forelse ($traseu->curse_ore as $cursa_ora)
                                @if ($loop->first)
                                    <td>
                                        {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($cursa_ora->ora)
                                            ->addHours(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->minute)
                                            ->format('H:i') }}
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
                                @else
                                    <td>
                                        {{ \Carbon\Carbon::parse($cursa_ora->ora)
                                            ->addHours(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->minute)
                                            ->format('H:i') }}
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
                                @endif
                            @empty
                            @endforelse
                            </tr>
                        @empty
                        @endforelse
                    </table>
                    @empty
                        <div>Nu există trasee în baza de date. Încearcă alte date de căutare.</div>
                    @endforelse
                </div>
            </div>     --}}


            {{-- Afisarea initiala pentru Otopeni-Galati --}}
            {{-- <div class="row justify-content-center mb-4">
                <div class="col-12 mb-4">
                    @forelse ($trasee_nume_otopeni_galati as $traseu_nume)
                    <div class="d-flex justify-content-between bg-secondary text-white">
                        <div class="flex flex-vertical-center">
                            <h5 class="p-3 mb-0">Traseu: {{$traseu_nume->nume}}</h5>
                        </div>
                        <div>
                            <h5 class="p-3 mb-0">Data: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $search)->format('d.m.Y') }}</h5>
                        </div>
                    </div>
                    <table class="table table-sm table-striped text-center">
                        @forelse ($traseu_nume->trasee as $traseu)
                            @if ($loop->first)
                                <tr>
                                        @forelse ($traseu->curse_ore as $cursa_ora)
                                            @if ($loop->first)
                                                <td>
                                                    {{$cursa_ora->cursa->oras_plecare->nume}}
                                                </td>
                                                <td>
                                                    {{$cursa_ora->cursa->oras_sosire->nume}}
                                                </td>
                                            @else
                                                <td>
                                                    {{$cursa_ora->cursa->oras_sosire->nume}}
                                                </td>
                                            @endif
                                        @empty
                                        @endforelse
                                </tr>
                            @endif

                            <tr>
                            @forelse ($traseu->curse_ore as $cursa_ora)
                                @if ($loop->first)
                                    <td>
                                        {{\Carbon\Carbon::parse($cursa_ora->ora)->format('H:i')}}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($cursa_ora->ora)
                                            ->addHours(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->minute)
                                            ->format('H:i') }}
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
                                @else
                                    <td>
                                        {{ \Carbon\Carbon::parse($cursa_ora->ora)
                                            ->addHours(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->hour)
                                            ->addMinutes(\Carbon\Carbon::parse($cursa_ora->cursa->durata)->minute)
                                            ->format('H:i') }}
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
                                @endif
                            @empty
                            @endforelse
                            </tr>
                        @empty
                        @endforelse
                    </table>
                    @empty
                        <div>Nu există trasee în baza de date. Încearcă alte date de căutare.</div>
                    @endforelse
                </div>
            </div> --}}
        </div>
    </div>
@endsection
