@extends('layouts.app')

@section('content')
<div>
    <div class="container card px-0" id="orase-ore-plecare"> 
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
        
        {{-- <div>
            @php
                dd( $rezervare);
            @endphp
        </div> --}}

        <div class="card-body">
            <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-1">
                @csrf      

                <div class="form-row mb-4">
                    <div class="col-lg-4">
                        <div class="card text-white bg-primary">
                            <div class="card-header text-center h4"> Informații cursă </div>
                            <div class="card-body">    
                                <div class="form-row mb-2">
                                    <div class="form-group col-lg-6">

                                        @if(!empty($rezervare->cursa->plecare_id))
                                            <script type="application/javascript"> 
                                                orasPlecareVechi={!! json_encode(old('oras_plecare', $rezervare->cursa->plecare_id)) !!}                                          
                                            </script> 
                                        @else
                                            <script type="application/javascript"> 
                                                orasPlecareVechi={!! json_encode(old('oras_plecare', "0")) !!}                                      
                                            </script> 
                                        @endif

                                        <label for="oras_plecare" class="mb-0">Plecare din:</label>
                                            <select class="custom-select-sm custom-select {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}"
                                                name="oras_plecare"
                                                v-model="oras_plecare"
                                                v-if="oras_plecare.id = 8"
                                            @change='getOraseSosire()'>
                                                {{-- <option value="0">Selectează Oras plecare</option> --}}
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
                                    <div class="form-group col-lg-6">
                                        
                                        @if(!empty($rezervare->cursa->plecare_id))
                                            <script type="application/javascript"> 
                                                orasSosireVechi={!! json_encode(old('oras_sosire', $rezervare->cursa->sosire_id)) !!}                                          
                                            </script> 
                                        @else
                                            <script type="application/javascript"> 
                                                orasSosireVechi={!! json_encode(old('oras_sosire', "0")) !!}                                      
                                            </script> 
                                        @endif
    
                                        <label for="oras_sosire" class="mb-0">Sosire la:</label>
                                            <select class="custom-select-sm custom-select {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}"
                                                name="oras_sosire"
                                                v-model="oras_sosire"
                                            @change='getOrePlecare()'>
                                                {{-- <option value="0">Selectează Oras sosire</option> --}}
                                                    <option v-for='oras_sosire in orase_sosire'                                
                                                    :value='oras_sosire.id'                                       
                                                    >@{{oras_sosire.nume}}</option>
                                            </select>
                                    </div>
                                </div> 
                                <div class="form-row mb-2">
                                    <div class="form-group col-lg-6">
                                        
                                        @if(!empty($rezervare->cursa->plecare_id))
                                            <script type="application/javascript"> 
                                                oraPlecareVeche={!! json_encode(old('ora_plecare', $rezervare->ora->id)) !!}                                          
                                            </script> 
                                        @else
                                            <script type="application/javascript"> 
                                                oraPlecareVeche={!! json_encode(old('ora_plecare', "0")) !!}                                      
                                            </script> 
                                        @endif

                                        <label for="ora_id" class="mb-0">Ora de plecare:</label>
                                            <select class="custom-select custom-select-sm {{ $errors->has('ora_plecare') ? 'is-invalid' : '' }}"
                                                name="ora_id"
                                                v-model="ora_plecare"
                                            @change='getOraSosire()'>
                                                {{-- <option value="0">Selectează Oras sosire</option> --}}
                                                <option v-for='ora_plecare in ore_plecare'                                
                                                    :value='ora_plecare.id'                                       
                                                    >
                                                    @{{ora_plecare.ora}}
                                                </option>
                                            </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="ora_sosire" class="mb-0">Ora sosire:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('ora_sosire') ? 'is-invalid' : '' }}" 
                                            name="ora_sosire" 
                                            placeholder="" 
                                                v-model="ora_sosire"
                                            {{-- value="{{ old('nume') }}" --}}
                                            required
                                            disabled
                                            >  
                                    </div>
                                </div>
                                <div class="form-row mb-0">
                                    <div class="form-group col-lg-6">
                                        
                                        @if(!empty($rezervare->cursa->plecare_id))
                                            <script type="application/javascript"> 
                                                statieImbarcareVeche={!! json_encode(old('statie_id', $rezervare->statie_id)) !!}                                          
                                            </script> 
                                        @else
                                            <script type="application/javascript"> 
                                                statieImbarcareVeche={!! json_encode(old('statie_id', "0")) !!}                                      
                                            </script> 
                                        @endif
                                                      
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
                                {{-- <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label for="data_cursa" class="mb-0">Data plecării:</label>
                                        <vue2-datepicker
                                            data-veche="{{ old('data_cursa') }}"
                                            nume-camp-db="data_cursa"
                                            tip="date"
                                            latime="150"
                                        ></vue2-datepicker>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="card-footer d-flex" style="height:116px">
                                <div class="form-row mb-0 justify-content-center align-self-center">
                                    <div class="form-group col-lg-12 mb-2">
                                        <label for="data_cursa" class="mb-0">Data plecării:</label>
                                        <vue2-datepicker                                        
                                        
                                                @if(!empty($rezervare->data_cursa))
                                                    data-veche="{{ old('data_cursa') == '' ? $rezervare->data_cursa : old('data_cursa') }}"
                                                @else
                                                    data-veche="{{ old('data_cursa') }}"
                                                @endif
                                               
                                            nume-camp-db="data_cursa"
                                            tip="date"
                                            latime="150"
                                        ></vue2-datepicker> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card text-white bg-success">
                            <div class="card-header text-center h4"> Informații personale </div>
                            <div class="card-body">    
                                <div class="form-row mb-2">
                                    <div class="form-group col-lg-12">
                                        <label for="nume" class="mb-0">Nume client:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                            name="nume" 
                                            placeholder="Nume" 
                                                @if(!empty($rezervare->nume))
                                                    value="{{ old('nume') == '' ? $rezervare->nume : old('nume') }}"
                                                @else
                                                    value="{{ old('nume') }}"
                                                @endif
                                            required> 
                                    </div>  
                                </div>  
                                <div class="form-row mb-2">
                                    <div class="form-group col-lg-6">
                                        <label for="telefon" class="mb-0">Telefon:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                                            name="telefon" 
                                            placeholder="Telefon"
                                                @if(!empty($rezervare->telefon))
                                                    value="{{ old('telefon') == '' ? $rezervare->telefon : old('telefon') }}"
                                                @else
                                                    value="{{ old('telefon') }}"
                                                @endif
                                            required> 
                                    </div>  
                                    <div class="form-group col-lg-6">
                                        <label for="email" class="mb-0">E-mail:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                            name="email" 
                                            placeholder="E-mail" 
                                                @if(!empty($rezervare->email))
                                                    value="{{ old('email') == '' ? $rezervare->email : old('email') }}"
                                                @else
                                                    value="{{ old('email') }}"
                                                @endif
                                            required> 
                                    </div> 
                                </div> 
                                <div class="form-row">                                    
                                    <div class="form-group col-lg-12 mb-0">
                                        <label for="" class="mb-0">Număr de locuri rezervate:</label>
                                    </div>  
                                </div>
                                <div class="form-row mb-2">                                    
                                    <div class="form-group col-lg-6 mb-0">
                                        <div class="form-group row mb-0">
                                            <script type="application/javascript"> 
                                                nrAdultiVechi={!! json_encode(old('nr_adulti', "0")) !!}
                                            </script>  
                                            <label for="nr_adulti" class="col-lg-5 col-form-label pr-1">Adulți:</label>
                                                <div class="col-lg-7">
                                                <input 
                                                    type="number"
                                                    min="0"
                                                    max="99" 
                                                    class="form-control form-control-sm {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}" 
                                                    name="nr_adulti" 
                                                    v-model="nr_adulti" 
                                                    value="{{ old('nr_adulti') }}"
                                                    required
                                                    {{-- @keyup='getPretTotal()'
                                                    @change='getPretTotal()' --}}
                                                    v-on:input='getPretTotal()'
                                                    > 
                                                </div>
                                        </div>                                        
                                    </div>  
                                    <div class="form-group col-lg-6 mb-0">
                                        <div class="form-group row mb-0">
                                            <script type="application/javascript"> 
                                                nrCopiiVechi={!! json_encode(old('nr_copii', "0")) !!}
                                            </script>  
                                            <label for="nr_copii" class="col-lg-5 col-form-label pr-1">Copii:</label>
                                                <div class="col-lg-7">
                                                <input 
                                                    type="number"
                                                    min="0"
                                                    max="99" 
                                                    class="form-control form-control-sm {{ $errors->has('nr_copii') ? 'is-invalid' : '' }}" 
                                                    name="nr_copii" 
                                                    v-model="nr_copii" 
                                                    value="{{ old('nr_copii') }}"
                                                    required
                                                    v-on:input='getPretTotal()'
                                                    >
                                                </div>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="card-footer d-flex" style="height:116px">
                                <div class="form-row mb-0 justify-content-center align-self-center">
                                    <div class="form-group col-lg-12 mb-0">
                                        {{-- <label for="ora_zbor" class="mb-0">Acord de confidențialitate:</label> --}}
                                        <label class="mb-0" style="justify-content-center align-self-center">
                                            <span class="text-center">
                                                Acord de confidențialitate:
                                            </span>
                                            <br>
                                                Prin utilizarea acestui formular sunteți de acord cu stocarea și procesarea datelor dvs. pe acest site web.
                                        </label>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card text-white bg-primary">
                            <div class="card-header text-center h4"> Informații finale </div>
                            <div class="card-body"> 
                                <div class="form-row mb-2">
                                    <div class="form-group col-lg-12">
                                        <label for="zbor_oras_decolare" class="mb-0">De unde decolează avionul:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('zbor_oras_decolare') ? 'is-invalid' : '' }}" 
                                            name="zbor_oras_decolare" 
                                            placeholder="Oraș decolare avion" 
                                            value="{{ old('zbor_oras_decolare') }}"
                                            required>  
                                    </div>
                                </div>
                                <div class="form-row mb-2">
                                    <div class="form-group col-lg-6">
                                        <label for="zbor_ora_decolare" class="mb-0">Oră decolare:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('zbor_ora_decolare') ? 'is-invalid' : '' }}" 
                                            name="zbor_ora_decolare" 
                                            placeholder="00:00" 
                                            value="{{ old('zbor_ora_decolare') }}"
                                            required>
                                    </div>
                                    <div class="form-group col-lg-6">
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
                                {{-- <div class="form-row mb-2">
                                    <div class="form-group col-lg-6">
                                        <label for="pret_adult" class="mb-0">Preț adult:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('pret_adult') ? 'is-invalid' : '' }}" 
                                            name="pret_adult"
                                            v-model="pret_adult" 
                                            value="{{ old('pret_adult') }}"
                                            required
                                            disabled> 
                                    </div>  
                                    <div class="form-group col-lg-6">
                                        <label for="pret_copil" class="mb-0">Preț copil:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('pret_copil') ? 'is-invalid' : '' }}" 
                                            name="pret_copil" 
                                            v-model="pret_copil"
                                            value="{{ old('pret_copil') }}"
                                            required
                                            disabled> 
                                    </div> 
                                </div>   --}}
                                <div class="form-row mb-0">
                                    <div class="form-group col-lg-6">
                                        <label for="pret_total" class="mb-0">Preț total:</label>
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
                                    <div class="form-group col-lg-6">
                                        <label for="comision_agentie" class="mb-0">Comision agenție:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('comision_agentie') ? 'is-invalid' : '' }}" 
                                            name="comision_agentie"
                                            placeholder="0" 
                                            value="{{ old('comision_agentie') }}"
                                            required> 
                                    </div> 
                                </div> 
                            </div>
                            <div class="card-footer">
                                <div class="form-row mb-0">
                                    <div class="form-group col-lg-12 mb-2">      
                                        <label for="observatii" class="mb-0">Observații:</label>
                                        <textarea 
                                            name="observatii" 
                                            rows="2"
                                            class="form-control {{ $errors->has('observatii') ? 'is-danger' : '' }}"
                                        >{{ old('observatii') }}</textarea> 
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                 

                <div class="form-row">
                    <div class="col-lg-12 align-self-end" style="height:60px;">                        
                        <button type="submit" class="btn btn-primary float-right" style="width: 100%; height:100%; white-space: normal;">Adaugă Rezervare</button> 
                    </div>
                </div>                 
            </form>
        </div>  
    </div>

   
@endsection