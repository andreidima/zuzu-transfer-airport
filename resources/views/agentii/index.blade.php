@extends ('layouts.app')

@section('content')
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mb-0"><a href="/agentii"><i class="fas fa-handshake mr-1"></i>Agenții</a></h4>
            </div>
            <div class="col-lg-3 text-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('agentii.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă agenție
                </a>
            </div>
        </div>

        @include ('errors')

        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-12 container-fluid px-0 table-responsive-lg">
                    <table class="table table-sm table-striped mb-2" style="font-size:0.8rem">
                        <tr style="height:35px; background-color:#336699; text-align:center; color:white;">
                            <th>
                                #
                            </th>
                            <th>
                                Firma
                            </th>
                            <th colspan="1">
                                Conturi
                            </th>
                            <th>
                                Sediu
                            </th>
                            <th>
                                Persoana<br>contact
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Telefon
                            </th>
                            <th>
                                Acțiuni
                            </th>
                        </tr>
                        @forelse ($agentii as $agentie)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}.
                                </td>
                                <td>
                                    <a href="{{ $agentie->path() }}/rezervari" title="Vezi Rezervările Agenției" class="text-dark">
                                        {{ $agentie->nume }}
                                    </a>
                                </td>
                                {{-- <td>
                                    @foreach ($agentie->useri as $user)
                                        {{ $user->nume }}
                                        <hr class="m-0">
                                    @endforeach
                                </td> --}}
                                <td>
                                    @foreach ($agentie->useri as $user)
                                        <div class="d-flex border-bottom border-dark justify-content-between mx-4 px-1" style="background-color:#ffdca8">
                                            <div style="word-break: break-all;">
                                                {{ $user->username }}
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ $user->path() }}/modifica" class="flex">
                                                    <span class="badge bg-primary">Modifică</span>
                                                </a>
                                                <a
                                                    href="#"
                                                    class=""
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#stergeUser{{ $user->id }}"
                                                    title="Șterge Utilizatorul"
                                                    >
                                                    <span class="badge bg-danger">Sterge</span>
                                                </a>
                                            </div>
                                        </div>
                                        {{-- @if (!$loop->last)
                                            <hr class="m-0">
                                        @endif --}}
                                    @endforeach
                                    <div class="text-center pb-4">
                                        <a href="agentii/{{ $agentie->id }}/useri/adauga" class="flex">
                                            <span class="badge bg-success">Adaugă</span>
                                        </a>
                                    </div>
                                </td>
                                {{-- <td>
                                    @foreach ($agentie->useri as $user)
                                        Sterge
                                        @if (!$loop->last)
                                            <hr class="m-0">
                                        @endif
                                    @endforeach
                                </td> --}}
                                <td>
                                    {{ $agentie->punct_lucru }}
                                </td>
                                <td>
                                    {{ $agentie->persoana_contact }}
                                </td>
                                <td style="width:200px; word-break: break-all;">
                                    {{ $agentie->email }}
                                </td>
                                <td class="text-center">
                                    {{ $agentie->telefon }}
                                </td>
                                <td style="min-width:105px;">
                                    <div class="d-flex justify-content-end">
                                        <div class="flex me-1">
                                            <a href="{{ $agentie->path() }}/rezervari"
                                            class="btn btn-success text-white btn-sm"
                                            title="Vezi Bilete"
                                                >
                                                <i class="fas fa-ticket-alt"></i>
                                            </a>
                                        </div>
                                        <div class="flex me-1">
                                            <a href="{{ $agentie->path() }}"
                                            title="Detalii Agenție"
                                                >
                                                <img src="{{ asset('images/icon-details.png') }}">
                                            </a>
                                        </div>
                                        <div class="flex me-1">
                                            <a href="{{ $agentie->path() }}/modifica" title="Modifică Agenția">
                                                <img src="{{ asset('images/icon-edit.jpg') }}" height="26px">
                                            </a>
                                        </div>
                                        <div class="flex">
                                            <a
                                                href="#"
                                                class="bg-danger text-white px-2 py-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#stergeAgentia{{ $agentie->id }}"
                                                title="Șterge Agenția"
                                                >
                                                <i class="far fa-trash-alt my-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            {{-- <tr>
                            </tr>
                            <tr>
                                <td colspan="7" class="p-0">
                                    @forelse ($agentie->useri as $user)
                                        Conturi:
                                    @empty
                                    @endforelse
                                    <hr class="m-0" style="height:5px; width:100%">
                                </td>
                            </tr> --}}
                            {{-- <tr>
                            </tr> --}}
                        @empty
                            Nu sunt agenții în baza de date de afișat
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>



    {{-- Modalele pentru stergere conturi --}}
    @foreach ($agentii as $agentie)
        @foreach ($agentie->useri as $user)
            <div class="modal fade text-dark" id="stergeUser{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Utilizator: <b>{{ $user->username }}</b></h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="text-align:left;">
                        Ești sigur ca vrei să ștergi Utilizatorul?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                        <form method="POST" action="{{ $user->path() }}">
                            @method('DELETE')
                            @csrf
                            <button
                                type="submit"
                                class="btn btn-danger text-white"
                                >
                                Șterge Utilizatorul
                            </button>
                        </form>

                    </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach

    {{-- Modalele pentru stergere agentie --}}
    @foreach ($agentii as $agentie)
        <div class="modal fade text-dark" id="stergeAgentia{{ $agentie->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Agenția: <b>{{ $agentie->nume }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Agenția?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $agentie->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge Agenția
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
