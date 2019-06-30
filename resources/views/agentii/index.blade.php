@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/agentii"><i class="fas fa-handshake mr-1"></i>Agenții</a></h4>
            </div> 
        </div>


        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-12 container-fluid px-0 table-responsive-lg">    
                    <table class="table table-sm table-striped mb-2" style="font-size:0.8rem">
                        <tr style="height:35px; background-color:#336699; text-align:center; color:white;">
                            <th>
                                Nr.<br>Crt.
                            </th>
                            <th>
                                Firma
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
                                    <div style="float:left;">
                                        <a href="{{ $agentie->path() }}/rezervari"
                                        class="btn btn-success btn-sm"
                                        title="Vezi Bilete"
                                            >
                                            <i class="fas fa-ticket-alt"></i>
                                        </a>
                                    </div>
                                    <div style="float:left;" class="mx-1">
                                        <a href="{{ $agentie->path() }}"
                                        title="Detalii Agenție"
                                            >
                                            <img src="{{ asset('images/icon-details.png') }}">
                                        </a>
                                    </div>
                                    <div style="float:left;">
                                        <a class="btn btn-danger btn-sm" 
                                            href="#" 
                                            role="button"
                                            data-toggle="modal" 
                                            data-target="#stergeAgentia{{ $agentie->id }}"
                                            title="Șterge Agenția"
                                            >
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeAgentia{{ $agentie->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Agenție: <b>{{ $agentie->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Agenția?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $agentie->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit"
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Agentie
                                                            </button>                    
                                                        </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            Nu sunt agenții în baza de date de afișat
                        @endforelse 
                    </table>
                </div> 
            </div>   
        </div>
    </div>
@endsection