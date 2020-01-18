@extends ('layouts.app')

@section('content')   
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header justify-content-between py-1" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 align-self-center">
                <h4 class=" mb-0">
                    <a href="{{ route('sms-trimise.index') }}"><i class="fas fa-sms mr-1"></i>SMS trimise</a>
                </h4>
            </div> 
            <div class="col-lg-8" id="app1">
                <form class="needs-validation" novalidate method="GET" action="{{ route('sms-trimise.index') }}">
                    @csrf                    
                    <div class="row input-group custom-search-form justify-content-end align-self-end">
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm border rounded-pill mb-1 py-0" 
                            id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                    value="{{ $search_nume }}">
                        </div>
                        <div class="col-md-6 d-flex mb-1">
                            <label for="search_date" class="mb-0 align-self-center mr-1">Interval:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data_inceput }}"
                                nume-camp-db="search_data_inceput"
                                tip="date"
                                latime="145"
                            ></vue2-datepicker>
                            <vue2-datepicker
                                data-veche="{{ $search_data_sfarsit }}"
                                nume-camp-db="search_data_sfarsit"
                                tip="date"
                                latime="145"
                            ></vue2-datepicker>
                        </div>
                        <button class="btn btn-sm btn-primary col-md-4 mr-1 border border-dark rounded-pill" type="submit">
                            <i class="fas fa-search text-white mr-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-pill" href="{{ route('sms-trimise.index') }}" role="button">
                            <i class="far fa-trash-alt text-white mr-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            {{-- <div class="col-lg-3 text-right"> --}}
                {{-- <a class="btn btn-sm bg-success text-white border border-dark rounded-pill col-md-8" href="{{ route('clienti.create') }}" role="button">
                    <i class="fas fa-plus-square text-white mr-1"></i>Adaugă client
                </a> --}}
            {{-- </div>  --}}
        </div>

        <div class="card-body px-0 py-3">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded"> 
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th style="font-size:0.8rem">Nr. Crt.</th>
                            <th class="" style="">Rezervare</th>
                            <th style="font-size:0.8rem">Telefon SMS</th>
                            <th class="text-center w-50">Mesaj</th>
                            <th class="text-center">Trimis</th>
                            <th class="text-right">Data trimitere</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($sms_trimise as $sms_trimis) 
                            <tr>                  
                                <td align="">
                                    {{ ($sms_trimise ->currentpage()-1) * $sms_trimise ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <a class="" data-toggle="collapse" href="#collapse{{ $sms_trimis->id }}" role="button" 
                                        aria-expanded="false" aria-controls="collapse{{ $sms_trimis->id }}"
                                        title="RO{{ $sms_trimis->rezervare->id ?? '' }}"
                                    >
                                        <b>{{ $sms_trimis->rezervare->nume ?? '' }}</b>
                                    </a>
                                    {{-- <a href="{{ isset($sms_trimis->client) ? $sms_trimis->client->path() : ''}}">
                                        <b>{{ $sms_trimis->client->nume ?? '' }}</b>
                                    </a> --}}
                                </td>
                                <td class="">
                                    {{ $sms_trimis->telefon }}
                                </td>
                                <td class="">
                                    {{ $sms_trimis->mesaj }}
                                </td>
                                <td class="text-center">
                                    @if ($sms_trimis->trimis === 1)
                                        <span class="text-success">DA</span>
                                    @else
                                        <span class="text-danger">NU</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    {{ \Carbon\Carbon::parse($sms_trimis->created_at)->isoFormat('HH:mm - DD.MM.YYYY') ?? '' }}
                                </td>
                            </tr> 
                            <tr class="collapse bg-white" id="collapse{{ $sms_trimis->id }}" 
                                {{-- style="background-color:cornsilk" --}}
                            >
                                <td colspan="6">
                                    <table class="table table-sm table-striped table-hover col-lg-6 mx-auto border"
                                {{-- style="background-color:#008282" --}}
                                    > 
                                        <tr>
                                            <td>
                                                Confirmare SMS
                                            </td>
                                            <td>
                                                @if ($sms_trimis->trimis === 1)
                                                    <span class="text-success">{{ $sms_trimis->raspuns }}</span>
                                                @else
                                                    <span class="text-danger">{{ $sms_trimis->raspuns }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td>
                                                Nume
                                            </td>
                                            <td>
                                                {{ $sms_trimis->rezervare->nume ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Cod bilet
                                            </td>
                                            <td>
                                                RO{{ $sms_trimis->rezervare->id ?? '' }}
                                            </td>
                                        </tr> --}}
                                    </table>
                                </td>
                            </tr> 
                            <tr class="collapse">
                                <td colspan="6">

                                </td>                                       
                            </tr> 
                        @empty
                            <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div>
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{-- {{$produse_vandute->links()}} --}}
                        {{$sms_trimise->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection