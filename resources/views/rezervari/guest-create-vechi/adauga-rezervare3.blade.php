@extends('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header mb-4">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2">
                    Rezervare cursă
                </h4>
            </div>
            <div>
                <h4 class="mt-2">                    
                    Zuzu Transfer Aeroport
                </h4>

            </div>
        </div>    
{{-- 
        <div>
            @php
                dd( $rezervare->statie_id);
            @endphp
        </div> --}}

        <div class="card-body">
            <div class="form-row">
                <div class="col-sm-12">
                    Rezervarea a fost adaugată cu succes
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-12 text-center"> 
                    <a href="/bilet-rezervat"
                        class="btn btn-success"
                        role="button"
                        target="_blank"
                        title="Descarcă bilet"
                        >
                        <i class="fas fa-ticket-alt">Descarcă Bilet</i>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection