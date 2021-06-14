@extends('layouts.app')

@section('content')
<div>
    <div class="container p-0 " id="orase-ore-plecare">

        @include ('errors')

        <div class="">
            <form  class="needs-validation" novalidate method="POST" action="/clienti-neseriosi" style="font-size:0.8rem">
                @csrf


                <div class="form-row mb-2 d-flex justify-content-center">
                    <div class="form-group col-lg-6 card text-white shadow-sm px-2 mb-0" style="background-color:#FFDF8E">
                        <div class="form-group row mb-0">
                            <div class="form-group col-lg-12 my-2">
                                {{-- <label for="nume" class="mb-0">Nume client:<span class="text-danger">*</span></label> --}}
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                                    name="nume"
                                    placeholder="Nume Client"
                                    value="{{ old('nume') }}"
                                    style=""
                                    required>
                            </div>
                            <div class="form-group col-lg-12 mb-2">
                                {{-- <label for="telefon" class="mb-0">Telefon:<span class="text-danger">*</span></label> --}}
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                                    name="telefon"
                                    placeholder="Telefon"
                                    value="{{ old('telefon') }}"
                                    required>
                            </div>
                            <div class="form-group col-lg-12 mb-1">
                                {{-- <label for="email" class="mb-0">E-mail:</label> --}}
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    name="observatii"
                                    placeholder="Observartii"
                                    value="{{ old('observatii') }}"
                                    >
                            </div>
                        </div>
                    </div>
                </div>



                <div class="form-row">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary text-white mr-4">Adaugă client neserios</button>
                    </div>
                </div>

            </form>


        </div>
    </div>
</div>
@endsection
