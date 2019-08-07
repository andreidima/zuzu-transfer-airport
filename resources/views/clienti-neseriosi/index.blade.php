@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Clienți neserioși</a></h4>
            </div> 
                <div class="w-50">             
                    <form class="needs-validation" novalidate method="GET" action="/rezervari">
                        @csrf                    
                        <div class="input-group custom-search-form">
                            <div class="w-50">
                                <input type="text" class="form-control" name="search_client_neserios_telefon" placeholder="Caută telefon...">
                            </div>
                            <div class="mx-4">
                                <span class="input-group-btn">
                                    <button class="btn btn-default-sm bg-primary" type="submit">
                                        <i class="fas fa-search text-white"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            <div>
                <a class="btn btn-primary" href="/rezervari/adauga" role="button">Adaugă client neserios</a>
            </div>
        </div>
    </div>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <div class="container-fluid px-0 table-responsive-lg">
        <table class="table table-sm" style="border:1px solid #333; width:100%;"> 
            <thead>
                <tr style="height:35px; background-color:#336699; text-align:center; color:white; font-size:0.7rem">
                    <th>Nr. Crt.</th>
                    <th>Nume client</th>
                    <th>Telefon</th>
                    <th>Observații</th>
                    <th class="mx-0 px-0">Diverse</th>
                </tr>
            </thead>
            <tbody>               
                @forelse ($clienti_neseriosi as $client_neserios)                      
                        <td align="center" class="px-0">
                            {{ $loop->iteration }}
                        </td>                        
                        <td align="" style="text-align:left; word-break: break-word;">
                            {{ $client_neserios->nume }}
                        </td>
                        <td align="" style="text-align:left; word-break: break-word;">
                            {{ $client_neserios->telefon }}
                        </td>
                        <td align="">
                            {{ $client_neserios->observatii }}
                        </td>
                        <td align="center" style="border-right:#333 1px solid;" class="px-0">   
                                <div style="min-width:30px;">
                                    <div style="float:right;" class="">
                                        <a class="btn btn-danger btn-sm" 
                                            href="#" 
                                            role="button"
                                            data-toggle="modal" 
                                            data-target="#stergeClientNeserios{{ $client_neserios->id }}"
                                            title="Șterge Client Neserios"
                                            >
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                            <div class="modal fade text-dark" id="stergeClientNeserios{{ $client_neserios->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Client: <b>{{ $client_neserios->nume }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi Clientul Neserios?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form method="POST" action="{{ $client_neserios->path() }}">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Client Neserios
                                                            </button>                    
                                                        </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div> 

                                    <div style="float:right;" class="">
                                        <a href="{{ $client_neserios->path() }}/modifica"
                                            title="Editează Client Neserios">
                                            <img src="{{ asset('images/icon-edit.jpg') }}" height="26px">
                                        </a>
                                    </div>
                                </div>
                        </td>
                    </tr>                                          
                @empty
                    <div>Nu s-au gasit clienti neseriosi în baza de date. Încearcă alte date de căutare</div>
                @endforelse
                </tbody>
        </table>
    </div>
@endsection