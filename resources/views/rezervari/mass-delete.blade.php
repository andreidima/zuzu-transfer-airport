@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="card-header text-white bg-danger">
            <div class="">
                <h4 class="mt-2"><i class="far fa-trash-alt"></i>Rezervări - șterge toate rezervarile pana la o anumita data</h4>
            </div> 
        </div>
        <div class="card-body">
            <div class="" id="app1">
                @if ($delete_rows_mesaj != '')
                    <div class="text-center my-4">
                        <h5 class="bg-success text-white d-inline-block p-1">
                            {{ $delete_rows_mesaj }}
                        </h5>
                    </div>
                @endif

                <form class="needs-validation mb-4 pb-4" novalidate method="GET" action="/rezervari/delete/mass-select">
                    @csrf                    
                    <div class="input-group custom-search-form row d-flex justify-content-center m-0">
                        <div class="form-group row d-flex col-7 justify-content-center">
                            {{-- <div class="row">
                                <div class="col-lg-12"> --}}
                                    <label for="search_data_inceput" class="mb-0 col-sm-5 col-form-label">Selecteaza rezervări până la data: </label>
                                    <vue2-datepicker
                                        data-veche="{{ $search_data_sfarsit }}"
                                        nume-camp-db="search_data_sfarsit"
                                        tip="date"
                                        latime="150"
                                    ></vue2-datepicker>
                                {{-- </div>
                            </div> --}}
                        </div>
                        <div class="form-group d-flex align-self-end col-12 justify-content-center"> 
                            <button class="btn bg-primary text-white mr-4" type="submit">
                                <i class="fas fa-search"></i>Selectează rezervări
                            </button>
                            <a class="btn bg-secondary text-white" href="/rezervari/delete/mass-select" role="button">
                                Resetează
                            </a>
                        </div>                  
                    </div>
                </form>

                @isset($search_data_sfarsit, $deleted_rows_number)
                    <div class="text-center mb-2">
                        Sunt selectate {{ $deleted_rows_number }} rezervări, până la data de 
                            @isset($search_data_sfarsit)
                                {{ $search_data_sfarsit }}
                            @else
                                „nedefinită”
                            @endif
                    </div>

                    <div class="form-group d-flex align-self-end col-12 justify-content-center"> 
                        <a class="btn btn-danger" 
                            href="#" 
                            role="button"
                            data-toggle="modal" 
                            data-target="#stergeRezervari"
                            title="Șterge Rezervari"
                            >
                            Șterge rezervările
                        </a>
                            <div class="modal fade text-dark" id="stergeRezervari" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">Sterge rezervari pana la data de {{ $search_data_sfarsit }}</b></h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="text-align:left;">
                                        Se vor sterge toate rezervarile pana la data de  {{ $search_data_sfarsit }}
                                        <br>
                                        Ești sigur ca vrei să ștergi {{ $deleted_rows_number }} rezervari?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                        
                                        <form class="needs-validation" novalidate method="POST" action="/rezervari/delete/mass-delete/{{ $search_data_sfarsit }}/{{ $deleted_rows_number }}">
                                            @method('DELETE')  
                                            @csrf   
                                            <button 
                                                type="submit" 
                                                class="btn btn-danger"  
                                                >
                                                Șterge Rezervările
                                            </button>                    
                                        </form>
                                    
                                    </div>
                                    </div>
                                </div>
                            </div> 
                    </div>  
                @endisset
                    
                    
            </div>
        </div>
    </div>

@endsection