@extends('layouts.app')

@section('content')
<div class="container p-0">
    <div class="card p-0 mb-4" id="orase-ore-plecare"> 
        <div class="d-flex justify-content-between card-header mb-1">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2">
                    {{-- <a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a> - Adaugă o rezervare nouă --}}
                    Rezervare cursă
                </h4>
            </div>
            <div>
                {{-- <a class="btn btn-secondary" href="/rezervari" role="button">Renunță</a> --}}
                <h4 class="mt-2">                    
                    Zuzu Transfer Aeroport
                </h4>
            </div>
        </div>

        @include ('errors')
        
        <div class="card-body">
            <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-1" style="font-size:0.8rem">
                @csrf

                <div class="form-row mb-0 d-flex justify-content-center">
                    <div class="form-group col-lg-6 card bg-warning text-dark shadow-sm px-2 mb-0">
                        <div class="form-row mb-2 d-flex justify-content-between">
                            <div class="form-group col-lg-5 m-0">
                                <script type="application/javascript"> 
                                    orasPlecareVechi={!! json_encode(old('oras_plecare', "0")) !!}
                                    statieImbarcareVeche = 0
                                    nrAdultiVechi = 0
                                    nrCopiiVechi = 0
                                    returOraPlecareVeche = 0
                                    pretTotal = 0
                                </script>       
                                <label for="oras_plecare" class="mb-0">Plecare din:<span class="text-danger">*</span></label>
                                    <select class="custom-select-sm custom-select {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}"
                                        name="oras_plecare"
                                        v-model="oras_plecare"
                                        v-if="oras_plecare.id = 8"
                                    @change='getOraseSosire()'>
                                            <optgroup label="Oraș">
                                                <option v-for='oras_plecare in orase_plecare'
                                                :value='oras_plecare.id'                  
                                                >@{{oras_plecare.nume}}</option>
                                            </optgroup>
                                            <optgroup label="Aeroport">
                                                <option :value='8'>Otopeni</option>
                                            </optgroup>
                                    </select>
                            </div>
                            <div class="form-group col-lg-5 m-0">
                                <script type="application/javascript"> 
                                    orasSosireVechi={!! json_encode(old('oras_sosire', "0")) !!}
                                </script>        
                                <label for="oras_sosire" class="mb-0">Sosire la:<span class="text-danger">*</span></label>
                                    <select class="custom-select-sm custom-select {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}"
                                        name="oras_sosire"
                                        v-model="oras_sosire"
                                    @change='getOrePlecare();getReturOrePlecare();'>
                                            <option v-for='oras_sosire in orase_sosire'                                
                                            :value='oras_sosire.id'                                       
                                            >@{{oras_sosire.nume}}</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-row mb-0 d-flex justify-content-between">
                            <div class="form-group col-lg-5 m-0 d-flex">
                                <label for="pret_adult" class="col-form-label mb-0 mr-2">Preț adult:</label>
                                <div class="px-0" style="width:50px">
                                    <input 
                                        type="text" 
                                        class="form-control form-control-sm {{ $errors->has('pret_adult') ? 'is-invalid' : '' }}" 
                                        name="pret_adult"
                                        v-model="pret_adult" 
                                        value="{{ old('pret_adult') }}"
                                        required
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group col-lg-5 m-0 d-flex">
                                <label for="pret_copil" class="col-form-label mb-0 mr-2">Preț copil:</label>
                                <div class="px-0" style="width:50px">
                                    <input 
                                        type="text" 
                                        class="form-control form-control-sm {{ $errors->has('pret_copil') ? 'is-invalid' : '' }}" 
                                        name="pret_copil" 
                                        v-model="pret_copil"
                                        value="{{ old('pret_copil') }}"
                                        required
                                        disabled> 
                                </div>
                                <label id="" class="col-form-label pl-1 align-bottom">
                                    2-7 ani
                                </label>
                            </div>
                        </div>

                        <div class="form-row mb-0 d-flex justify-content-between">
                            <div class="form-group col-lg-5 m-0">
                                <script type="application/javascript"> 
                                    oraPlecareVeche={!! json_encode(old('ora_id', "0")) !!}
                                </script>        
                                <label for="ora_id" class="mb-0">Ora de plecare:<span class="text-danger">*</span></label>
                                    <select class="custom-select custom-select-sm {{ $errors->has('ora_id') ? 'is-invalid' : '' }}"
                                        name="ora_id"
                                        v-model="ora_plecare"
                                    @change='getOraSosire()'>
                                        <option v-for='ora_plecare in ore_plecare'                                
                                            :value='ora_plecare.id'                                       
                                            >
                                            @{{ora_plecare.ora}}
                                        </option>
                                    </select>
                            </div>
                            <div class="form-group col-lg-5 m-0">
                                <label for="ora_sosire" class="mb-0">Ora sosire:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('ora_sosire') ? 'is-invalid' : '' }}" 
                                    name="ora_sosire" 
                                    placeholder="" 
                                        v-model="ora_sosire"
                                    required
                                    disabled
                                    >  
                            </div>
                        </div>

                        <div class="form-row mb-2">
                            <div class="form-group col-lg-5 mb-0">
                                <script type="application/javascript"> 
                                    statieImbarcareVeche={!! json_encode(old('statie_id', "0")) !!}
                                </script>        
                                <label for="statie_id" class="mb-0">Stația de îmbarcare:</label>
                                    <select class="custom-select custom-select-sm {{ $errors->has('statie_id') ? 'is-invalid' : '' }}"
                                        name="statie_id"
                                        v-model="statie_id"
                                    >
                                        <option v-for='statie_id in statii_imbarcare'                                
                                            :value='statie_id.id'                                       
                                            >
                                            @{{statie_id.nume}}
                                        </option>
                                    </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row mb-0 d-flex justify-content-center">
                    <div class="form-group col-lg-6 border card bg-primary text-white shadow-sm px-2 mb-0">
                        <div class="form-row mb-0 d-flex justify-content-between">
                            <div class="form-group col-lg-5 mb-0 ">
                                <label for="data_cursa" class="mb-0">Data plecării:<span class="text-danger">*</span></label>
                                <vue2-datepicker
                                    data-veche="{{ old('data_cursa') == '' ? '' : old('data_cursa') }}"
                                    nume-camp-db="data_cursa"
                                    tip="date"
                                    latime="150"
                                    not-before="{{ \Carbon\Carbon::today() }}"
                                ></vue2-datepicker> 
                            </div>
                            <div class="form-group col-lg-5 m-0">
                                <label for="zbor_ora_decolare" class="mb-0">Oră decolare:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('zbor_ora_decolare') ? 'is-invalid' : '' }}" 
                                    name="zbor_ora_decolare" 
                                    placeholder="00:00" 
                                    value="{{ old('zbor_ora_decolare') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-row mb-2 d-flex justify-content-between">
                            <div class="form-group col-lg-5 m-0">
                                <label for="zbor_oras_decolare" class="mb-0">Oraș decolare avion:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('zbor_oras_decolare') ? 'is-invalid' : '' }}" 
                                    name="zbor_oras_decolare" 
                                    placeholder="" 
                                    value="{{ old('zbor_oras_decolare') }}"
                                    style="text-transform:uppercase"
                                    required>  
                            </div>
                            <div class="form-group col-lg-5 m-0">
                                <label for="zbor_ora_aterizare" class="mb-0">Ora aterizare:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('zbor_ora_aterizare') ? 'is-invalid' : '' }}" 
                                    name="zbor_ora_aterizare" 
                                    placeholder="00:00" 
                                    value="{{ old('zbor_ora_aterizare') }}"
                                    required>  
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-row mb-2 d-flex justify-content-center">   
                    <div class="form-group col-lg-6 card bg-success text-white shadow-sm px-2 mb-0"> 
                        <div class="form-group row mb-0">
                            <div class="form-group col-lg-12 my-2">
                                {{-- <label for="nume" class="mb-0">Nume client:<span class="text-danger">*</span></label> --}}
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                    name="nume" 
                                    placeholder="Nume Client" 
                                    value="{{ old('nume') }}"
                                    style="text-transform:uppercase"
                                    required> 
                            </div>
                            <div class="form-group col-lg-12 mb-2">
                                {{-- <label for="telefon" class="mb-0">Telefon:<span class="text-danger">*</span></label> --}}
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                                    name="telefon" 
                                    placeholder="Telefon" 
                                    value="{{ old('telefon') }}"
                                    required> 
                            </div>  
                            <div class="form-group col-lg-12 mb-1">
                                {{-- <label for="email" class="mb-0">E-mail:</label> --}}
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                    name="email" 
                                    placeholder="E-mail" 
                                    value="{{ old('email') }}"
                                    > 
                            </div> 
                            <div class="form-group col-lg-12 mb-0 pt-1 border-top border-bottom">
                                    {{-- <label for="nume" class="mb-0">Număr de locuri rezervate:</label>  --}}
                                <div class="form-group row mb-0">                                
                                        <div class="form-group col-lg-7 mb-0 d-flex">
                                            {{-- <label for="nume" class="mb-0">Număr de locuri:</label> --}}
                                                <script type="application/javascript"> 
                                                    nrAdultiVechi={!! json_encode(old('nr_adulti', " ")) !!}
                                                </script>  
                                                <label for="nr_adulti" class="col-form-label pr-0">Număr de locuri:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adulți:<span class="text-danger">*</span></label>
                                                    <div class="pl-0" style="width:80px">
                                                    {{-- <input 
                                                        type="number"
                                                        min="0"
                                                        max="20" 
                                                        class="form-control form-control-sm {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}" 
                                                        name="nr_adulti" 
                                                        v-model="nr_adulti" 
                                                        value="{{ old('nr_adulti') }}"
                                                        required
                                                        v-on:input='getPretTotal()'
                                                        >  --}}
                                                    <select class="custom-select custom-select-sm {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}"
                                                        name="nr_adulti"
                                                        v-model="nr_adulti"
                                                    @change='getPretTotal()'>
                                                        @for ($i = 1; $i < 16; $i++)
                                                            <option>{{ $i }}</option>
                                                        @endfor                                                       
                                                    </select>
                                                    </div>                                       
                                        </div>  
                                        <div class="form-group col-lg-5 mb-0 d-flex">
                                            <script type="application/javascript"> 
                                                nrCopiiVechi={!! json_encode(old('nr_copii', " ")) !!}
                                            </script>  
                                            <label for="nr_copii" class="col-form-label pr-0">Copii:</label>
                                                <div class="px-0" style="width:80px">
                                                {{-- <input 
                                                    type="number"
                                                    min="0"
                                                    max="10" 
                                                    class="form-control form-control-sm {{ $errors->has('nr_copii') ? 'is-invalid' : '' }}" 
                                                    name="nr_copii" 
                                                    v-model="nr_copii" 
                                                    value="{{ old('nr_copii') }}"
                                                    required
                                                    v-on:input='getPretTotal()'
                                                    > --}}
                                                    <select class="custom-select custom-select-sm {{ $errors->has('nr_copii') ? 'is-invalid' : '' }}"
                                                        name="nr_copii"
                                                        v-model="nr_copii"
                                                    @change='getPretTotal()'>
                                                        @for ($i = 1; $i < 11; $i++)
                                                            <option>{{ $i }}</option>
                                                        @endfor                                                        
                                                    </select>
                                                </div>
                                            <label id="" class="col-form-label pl-1 text-white align-bottom">
                                                2-7 ani
                                            </label>
                                        </div>
                                </div>
                            </div>                        
                            <div class="form-group col-lg-12 mb-0 mt-1 d-flex  border-bottom"> 
                                <script type="application/javascript"> 
                                    pretTotal={!! json_encode(old('pret_total', 0)) !!}
                                </script>  
                                <label for="pret_total" class="mb-0 col-form-label mr-2">Preț total:</label>
                                <div class="px-0" style="width:80px">
                                    <input 
                                        type="text" 
                                        class="form-control form-control-sm {{ $errors->has('pret_total') ? 'is-invalid' : '' }}" 
                                        name="pret_total"
                                        v-model="pret_total" 
                                        placeholder="0" 
                                        value="{{ old('pret_total') }}"
                                        required
                                        readonly> 
                                </div>
                            </div> 
                            
                                                            
                                 <script type="application/javascript"> 
                                    plataOnlineVeche={!! json_encode(old('plata_online') == "true" ? true : false) !!}
                                </script>

                                {{--
                            @guest   
                            @else    
                            
                                @if (Auth::user()->id == 355)

                                    <h1 :plata-online="true"></h1>

                                    <div class="form-group col-lg-12 mb-0 mt-1 pb-1 border-bottom"> 
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-light btn-sm mr-2" v-on:click="plata_online = !plata_online">PLATA CU CARD</button>                           
                                            <input
                                                type="hidden"
                                                name="plata_online"
                                                v-model="plata_online">
                                            <img src="{{ asset('images/footer-icons-pay.png') }}" width="90px">
                                        </div>

                                        <div v-show="plata_online" class="form-group col-lg-12 mb-1 mt-1">
                                            <div class="row d-flex">
                                                    <label for="adresa" class="mb-0 col-form-label mr-2">Adresa:<span class="text-danger">*</span></label>
                                                <div class="form-group col-lg-10 mb-1">
                                                    <textarea
                                                        type="text" 
                                                        rows="2"
                                                        class="form-control form-control-sm {{ $errors->has('adresa') ? 'is-invalid' : '' }}" 
                                                        name="adresa" 
                                                        placeholder="Adresa postală"
                                                        >{{ old('adresa') }}</textarea>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                @endif
                                
                            @endguest --}}

                                    {{-- temporar pana e gata plata online --}}
                                        {{-- <input type="hidden" name="plata_online" value="0" /> --}}
                            
                            {{-- @guest   
                            @else 
                                @if (Auth::user()->id == 355) --}}
                                    <div class="form-group col-lg-12 mb-0 mt-1 d-flex justify-content-center border-bottom">
                                        <label for="" class="pr-2">Plata cu card:</label>
                                        <input type="hidden" name="plata_online" value="0" />
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input px-2" name="plata_online" value="1" required
                                            {{ old('plata_online') == '1' ? 'checked' : '' }}>
                                            <img src="{{ asset('images/footer-icons-pay.png') }}" width="90px">
                                        </div>
                                    </div> 
                                    {{-- <div class="form-group col-lg-12 mb-0 mt-1 d-flex justify-content-center border-bottom">
                                        <label for="" class="pr-2">Modalitate de plată:</label>

                                        <div class="form-check row">
                                            <input type="radio" class="form-check-input" name="plata_online" value="0"
                                            {{ old('plata_online') == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="">
                                                La șofer
                                            </label>

                                            <input type="radio" class="form-check-input" name="plata_online" value="1"
                                            {{ old('plata_online') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="">
                                                Card de credit sau de debit
                                            </label>

                                            <img src="{{ asset('images/footer-icons-pay.png') }}" width="90px">
                                        </div>
                                    </div>  --}}

                                {{-- @endif
                            @endguest --}}

                            <div class="form-group col-lg-12 mb-0 mt-1 d-flex">
                                <label for="" class="mr-4">Acord de confidențialitate:</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="acord_de_confidentialitate" value="1" required
                                    {{ old('acord_de_confidentialitate') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="acord_de_confidentialitate">prin utilizarea acestui formular sunteți de acord cu stocarea și procesarea datelor dvs. pe acest site web</label> 
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-lg-12 d-flex justify-content-center">  
                        <button type="submit" class="btn btn-primary mr-4">Verifică Rezervare</button>  
                    </div>
                </div>
                    
            </form>


        </div>
    </div>

    <div class="justify-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <img src="{{ asset('images/grile-ore/Galati - Otopeni.jpg') }}" width="245px">
                <img src="{{ asset('images/grile-ore/Otopeni - Galati.jpg') }}" width="237px">
                <img src="{{ asset('images/grile-ore/Tecuci - Otopeni.jpg') }}" width="277px">
                <img src="{{ asset('images/grile-ore/Otopeni - Tecuci.jpg') }}" width="275px">
            </div>
        </div>
    </div>
</div>
@endsection