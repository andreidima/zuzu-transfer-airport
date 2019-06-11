@extends ('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/curse"><i class="fas fa-car-side mr-1"></i>Curse</a></h4>
            </div> 
                {{-- <div class="">             
                    <form class="needs-validation" novalidate method="GET" action="/curse">
                        @csrf                    
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" name="search" placeholder="Caută...">
                            <span class="input-group-btn">
                                <button class="btn btn-default-sm bg-primary" type="submit">
                                    <i class="fas fa-search text-white"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div> --}}
            {{-- <div>
                <a class="btn btn-primary" href="/rezervari/adauga" role="button">Adaugă Rezervare</a>
            </div> --}}
        </div>

        <div class="card-body">
            <div class="row justify-content-center mb-4">
                <div class="col-12 mb-4">               
                    <h5 class="p-3 mb-2 bg-secondary text-white">Curse:</h5>
                    <table class="table table-striped">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @forelse ($curse as $cursa)
                        @forelse ($cursa->ore as $ora)
                        <tr>
                            <td>
                                {{ $cursa->oras_plecare->nume }}
                            </td>
                            <td>
                                {{ $cursa->oras_sosire->nume }}
                            </td>
                            <td>
                                {{ $ora->ora }}
                                {{ $cursa->rezervari->count() }}
                            </td>
                        </tr>     
                        @empty
                        @endforelse 
                    @empty
                        <div>Momentan nu sunt introduse curse în baza de date.</div>
                    @endforelse
                </div>      
            </div>    
        </div>
    </div>
@endsection