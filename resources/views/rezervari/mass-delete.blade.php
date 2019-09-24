@extends ('layouts.app')

@section('content')   
    <div class="container card text-white bg-danger px-0">
        <div class="card-header">
            <div class="">
                <h4 class="mt-2"><i class="fas fa-file-alt mr-1"></i>Rezervări - ștergere în masă</h4>
            </div> 
        </div>
        <div class="card-body">
            <div class="" id="app1">
                <form class="needs-validation" novalidate method="GET" action="/rezervari/delete/rezervari-mass-delete">
                    @csrf                    
                    <div class="input-group custom-search-form row d-flex justify-content-center m-0">
                        <div class="form-group d-flex col-8 justify-content-center">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="search_data_inceput" class="mb-0">Data sfârșit</label>
                                <vue2-datepicker
                                    data-veche="{{ $search_data_sfarsit }}"
                                    nume-camp-db="search_data_sfarsit"
                                    tip="date"
                                    latime="150"
                                ></vue2-datepicker>
                            </div>
                        </div>
                        </div>
                        <div class="form-group d-flex align-self-end col-12 justify-content-center"> 
                            <button class="btn bg-primary text-white mr-4" type="submit">
                                <i class="fas fa-search"></i>Caută rezervări
                            </button>
                            <a class="btn bg-secondary text-white" href="/rezervari-raport-zi" role="button">
                                Resetează
                            </a>
                        </div>                  
                    </div>
                </form>



                        <div class="form-group d-flex align-self-end col-12 justify-content-center"> 
                                        <a class="btn btn-danger btn-sm" 
                                            href="#" 
                                            role="button"
                                            data-toggle="modal" 
                                            data-target="#stergeRezervari"
                                            title="Șterge Rezervari"
                                            >
                                            Șterge rezervări
                                        </a>
                                            <div class="modal fade text-dark" id="stergeRezervari" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Sterge rezervari pana la {{ $search_data_sfarsit }}</b></h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="text-align:left;">
                                                        Ești sigur ca vrei să ștergi rezervarile?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Renunță</button>
                                                        
                                                        <form class="needs-validation" novalidate method="POST" action="/rezervari/delete/rezervari-mass-delete">
                                                            @method('DELETE')  
                                                            @csrf   
                                                            <button 
                                                                type="submit" 
                                                                class="btn btn-danger"  
                                                                >
                                                                Șterge Rezervări
                                                            </button>                    
                                                        </form>
                                                    
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                            
                       
                    
                        </div>                  
                    </div>

                    <div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection