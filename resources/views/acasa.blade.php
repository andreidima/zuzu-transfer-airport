@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header justify-content-between">
                    <div class="row justify-content-between mx-0 mt-1">
                        <div>
                            <h5 class="m-0">Bine ai venit, <b>{{ Auth::user()->nume }}</b>!</h5>
                        </div>
                        <div>
                            <h5 class="m-0">Panoul principal</h5>              
                        </div>     
                    </div>
                </div>

                <div class="card-body m-4 p-4">
                    {{-- <h5 class="card-title mb-4">Bine ai venit, <b>{{ Auth::user()->nume }}</b>!</h5> --}}
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif --}}

                    
                        <a class="btn btn-light btn-lg btn-block mb-4" role="button" href="/rezervari">
                            <i class="fas fa-address-card mr-1"></i>Rezervări
                        </a>
                        <a class="btn btn-light btn-lg btn-block mb-4" role="button" href="/trasee">
                            <i class="fas fa-route mr-1"></i>Trasee
                        </a>
                        <a class="btn btn-light btn-lg btn-block mb-4 disabled" role="button" href="#">
                            <i class="fas fa-handshake mr-1"></i>Agenții
                        </a>
                        <a class="btn btn-light btn-lg btn-block mb-4 disabled" role="button" href="#">
                            <i class="fas fa-chalkboard-teacher mr-1"></i>Instrucțiuni Rezervări
                        </a>
                        <a class="btn btn-light btn-lg btn-block disabled" role="button" href="#">
                            <i class="fas fa-user-slash mr-1"></i>Clienți neserioși
                        </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection