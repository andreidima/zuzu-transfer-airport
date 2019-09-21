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
                <div class="col-sm-2">
                </div>
                <div class="col-sm-8 text-center p-0" style="border:5px solid #efe3b1;">
                    <h4 style="background-color:#e7d790; color:black; padding:2px 0px;">
                    Rezervarea a fost înregistrată cu codul RO{{ $rezervare->id }}
                    </h4>
                    @isset($plata_online)
                        <br>
                        @if ($plata_online->error_code == 0 )
                            Plata rezervării s-a efectuat cu succes!
                        @else                            
                            Plata rezervării nu s-a efectuat cu succes!
                            <br>
                            Aveți posibilitatea să faceți plata la șofer.
                        @endif
                        <br>
                        {{-- <br>
                        Starea plății pentru această rezervare este: {{ $plata_online->error_message }}
                        <br> --}}
                    @endisset
                    <br>
                    Biletul de rezervare v-a fost trimis pe email, dar îl puteți salva și tipări și de aici                     
                    <div class="form-row">
                        <div class="col-sm-12 text-center"> 
                            <a href="/bilet-rezervat"
                                class="btn btn-success"
                                role="button"
                                target="_blank"
                                title="Descarcă bilet"
                                >
                                <h5 class="p-0 m-0">Descarcă Biletul</h5>
                            </a>
                        </div>
                    </div>
                    
                    <br>
                    <br>
                    
                    <a href="https://search.google.com/local/writereview?placeid=ChIJpewnP6UYtEARTNdthvoB5vk" target="_blank">
                        Ești mulțumit de serviciile noastre? Lasă-ne te rog un review!
                        <br>
                        <img src="{{ asset('images/review-stars.png') }}" width="50px">
                    </a>

                    <hr>
                    <a href="https://www.zuzu-transfer-aeroport.ro/">INAPOI LA PAGINA PRINCIPALĂ</a>
                </div>
                <div class="col-sm-2">
                </div>
            </div>
        </div>
    </div>

@endsection