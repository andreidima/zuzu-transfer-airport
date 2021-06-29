@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('notificari.index') }}"><i class="fas fa-hand-holding-usd mr-1"></i></i>Notificări</a>
                </h4>
            </div>
            <div class="col-lg-6" id="">
                <form class="needs-validation" novalidate method="GET" action="{{ route('notificari.index') }}">
                    @csrf
                    <div class="row input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 border rounded-pill mb-1 py-0"
                        id="search_text" name="search_text" placeholder="Text" autofocus
                                value="{{ $search_text }}">
                        <div class="col-md-4 px-1">
                            <button class="btn btn-sm btn-primary text-white col-md-12 border border-dark rounded-pill" type="submit">
                                <i class="fas fa-search text-white mr-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-4 px-1">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-pill" href="{{ route('notificari.index') }}" role="button">
                                <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-right">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('notificari.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă notificare
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>Nr.</th>
                            <th>Text</th>
                            <th class="text-center">Stare</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notificari as $notificare)
                            <tr>
                                <td align="">
                                    {{ ($notificari ->currentpage()-1) * $notificari ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{-- <a href="{{ $notificare->path() }}"> --}}
                                        {{ $notificare->text ?? '' }}
                                    {{-- </a> --}}
                                </td>
                                <td class="text-center">
                                    @if ($notificare->stare === 1)
                                        <a class=""
                                            href="#"
                                            role="button"
                                            data-toggle="modal"
                                            data-target="#activeazaAnuleazaNotificare{{ $notificare->id }}"
                                            title=""
                                            >
                                            <span class="badge badge-success">Activă</span>
                                        </a>
                                    @else
                                        <a class=""
                                            href="#"
                                            role="button"
                                            data-toggle="modal"
                                            data-target="#activeazaAnuleazaNotificare{{ $notificare->id }}"
                                            title=""
                                            >
                                            <span class="badge badge-dark">Inactivă</span>
                                        </a>
                                    @endif

                                        <div class="modal fade text-dark" id="activeazaAnuleazaNotificare{{ $notificare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title" id="exampleModalLabel">Notificare: <b>{{ $notificare->text }}</b></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="text-align:left;">
                                                    @if ($notificare->stare === 1)
                                                        Ești sigur ca vrei să dezactivezi notificarea?
                                                    @else
                                                        Ești sigur ca vrei să activezi notificarea?
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                    <form method="POST" action="{{ url('notificari/activeaza-dezactiveaza', $notificare->id) }}">
                                                        @method('PATCH')
                                                        @csrf
                                                            @if ($notificare->stare === 1)
                                                                <button type="submit" class="btn btn-warning">
                                                                    Dezactivează notificarea
                                                                </button>
                                                            @else
                                                                <button type="submit" class="btn btn-success">
                                                                    Activează notificarea
                                                                </button>
                                                            @endif
                                                    </form>

                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ $notificare->path() }}/modifica"
                                            class="flex"
                                        >
                                            <span class="badge bg-primary mx-1">Modifică</span>
                                        </a>
                                        <div style="flex" class="">
                                            <a
                                                {{-- class="btn btn-danger btn-sm"  --}}
                                                href="#"
                                                {{-- role="button" --}}
                                                data-toggle="modal"
                                                data-target="#stergeNotificare{{ $notificare->id }}"
                                                title="Șterge Notificare"
                                                >
                                                {{-- <i class="far fa-trash-alt"></i> --}}
                                                <span class="badge bg-danger">Șterge</span>
                                            </a>
                                                <div class="modal fade text-dark" id="stergeNotificare{{ $notificare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Notificare: <b>{{ $notificare->text }}</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="text-align:left;">
                                                            Ești sigur ca vrei să ștergi Notificarea?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>

                                                            <form method="POST" action="{{ $notificare->path() }}">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-danger"
                                                                    >
                                                                    Șterge Notificarea
                                                                </button>
                                                            </form>

                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <div>Nu s-au gasit notificări în baza de date. Încearcă alte date de căutare</div>
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{-- {{$produse_vandute->links()}} --}}
                        {{$notificari->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
