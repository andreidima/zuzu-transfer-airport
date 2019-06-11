@extends('layouts.app')

@section('content')
<div>
    <div class="container card px-0" id="orase-ore-plecare"> 
        <div class="d-flex justify-content-between card-header mb-1">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a> - Adaugă o rezervare nouă</h4>
            </div>
            <div>
                <a class="btn btn-secondary" href="/rezervari" role="button">Renunță</a>
            </div>
        </div>

        @include ('errors')
        
        <div class="card-body">
            <form  class="needs-validation" novalidate method="POST" action="/rezervari">
                @csrf      

                <div class="form-row mb-2 d-flex justify-content-center">   
                    <div class="form-group col-lg-4 card bg-primary text-white shadow-sm px-2 mr-4">
                        <div class="form-row mb-0 d-flex justify-content-center">
                            <div class="form-group col-lg-6">
                                <script type="application/javascript"> 
                                    orasPlecareVechi={!! json_encode(old('oras_plecare', "0")) !!}
                                    statieImbarcareVeche = 0
                                    nrAdultiVechi = 0
                                    nrCopiiVechi = 0
                                </script>       
                                <label for="oras_plecare" class="mb-0">Plecare din:</label>
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
                            <div class="form-group col-lg-6">
                                <script type="application/javascript"> 
                                    orasSosireVechi={!! json_encode(old('oras_sosire', "0")) !!}
                                </script>        
                                <label for="oras_sosire" class="mb-0">Sosire la:</label>
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
                        <div class="form-row mb-0 d-flex justify-content-center">
                            <div class="form-group col-lg-6">
                                <script type="application/javascript"> 
                                    oraPlecareVeche={!! json_encode(old('ora_plecare', "0")) !!}
                                </script>        
                                <label for="ora_id" class="mb-0">Ora de plecare:</label>
                                    <select class="custom-select custom-select-sm {{ $errors->has('ora_plecare') ? 'is-invalid' : '' }}"
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
                            <div class="form-group col-lg-6">
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
                    </div>

                    <div class="form-group col-lg-4 border card bg-warning text-dark shadow-sm px-2">
                        <div class="form-row mb-0 d-flex justify-content-center">
                            <div class="form-group col-lg-6 mb-0 ">
                                <label for="data_cursa" class="mb-0">Data plecării:</label>
                                <vue2-datepicker
                                    data-veche="{{ old('data_cursa') }}"
                                    nume-camp-db="data_cursa"
                                    tip="date"
                                    latime="150"
                                ></vue2-datepicker> 
                            </div>
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
                        </div>
                        <div class="form-row mb-0 d-flex justify-content-center">
                            <div class="form-group col-lg-6">
                                <label for="zbor_oras_decolare" class="mb-0">Oraș decolare avion:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('zbor_oras_decolare') ? 'is-invalid' : '' }}" 
                                    name="zbor_oras_decolare" 
                                    placeholder="" 
                                    value="{{ old('zbor_oras_decolare') }}"
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
                    </div>
                </div>


                <div class="form-row mb-2 d-flex justify-content-center">   
                    <div class="form-group col-lg-10 card bg-success text-white shadow-sm px-3"> 
                        <div class="form-group row mb-0">
                            <div class="form-group col-lg-6">
                                <label for="nume" class="mb-0">Nume client:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                    name="nume" 
                                    placeholder="Nume" 
                                    value="{{ old('nume') }}"
                                    required> 
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="telefon" class="mb-0">Telefon:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                                    name="telefon" 
                                    placeholder="Telefon" 
                                    value="{{ old('telefon') }}"
                                    required> 
                            </div>  
                            <div class="form-group col-lg-3">
                                <label for="email" class="mb-0">E-mail:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                    name="email" 
                                    placeholder="E-mail" 
                                    value="{{ old('email') }}"
                                    required> 
                            </div> 
                        </div>
                        <div class="form-group row mb-0 border-top"> 
                            <div class="form-group col-lg-5 mb-0 border-top border-right">
                                <label for="nume" class="mb-0">Statie îmbarcare:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('statie_imbarcare') ? 'is-invalid' : '' }}" 
                                    name="statie_imbarcare" 
                                    placeholder="Nume" 
                                    value="{{ old('statie_imbarcare') }}"
                                    required> 
                            </div>
                            <div class="form-group col-lg-5 mb-0 border border-bottom-0">
                                    <label for="nume" class="mb-0">Număr de locuri rezervate:</label> 
                                <div class="form-group row mb-0">                                
                                        <div class="form-group col-lg-5 mb-0 d-flex">
                                                <script type="application/javascript"> 
                                                    nrAdultiVechi={!! json_encode(old('nr_adulti', "0")) !!}
                                                </script>  
                                                <label for="nr_adulti" class="col-form-label pr-0">Adulți:</label>
                                                    <div class="pl-0">
                                                    <input 
                                                        type="number"
                                                        min="0"
                                                        max="99" 
                                                        class="form-control form-control-sm {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}" 
                                                        name="nr_adulti" 
                                                        v-model="nr_adulti" 
                                                        value="{{ old('nr_adulti') }}"
                                                        required
                                                        v-on:input='getPretTotal()'
                                                        > 
                                                    </div>                                       
                                        </div>  
                                        <div class="form-group col-lg-7 mb-0 d-flex">
                                            <script type="application/javascript"> 
                                                nrCopiiVechi={!! json_encode(old('nr_copii', "0")) !!}
                                            </script>  
                                            <label for="nr_copii" class="col-form-label pr-0">Copii:</label>
                                                <div class="px-0">
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
                                            <label id="" class="col-form-label pl-1 text-white align-bottom">
                                                2-7 ani
                                            </label>
                                        </div>
                                </div>
                            </div>                      
                            <div class="form-group col-lg-2 mb-0 border-top border-left">
                                <label for="pret_total" class="mb-0">Preț total:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('pret_total') ? 'is-invalid' : '' }}" 
                                    name="pret_total"
                                    v-model="pret_total" 
                                    placeholder="0" 
                                    value="{{ old('pret_total') }}"
                                    required> 
                            </div> 
                                       
                    
                        </div>
                    </div>
                </div>
                

                

                        
                <div v-show="retur" class="form-row mb-0 justify-content-center"> 
                    <div class="form-group col-lg-8"> 
                        <div class="form-row">
                            <div class="form-group col-lg-12"> 
                                <h2>Retur</h2>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6 border card shadow-sm px-0"> 
                                <div class="form-group row mb-0 bg-primary text-white mx-0">
                                    <div class="form-group col-lg-6">      
                                        <label for="ora_id" class="mb-0">Ora îmbarcare:</label>
                                            <select class="custom-select custom-select-sm {{ $errors->has('retur_ora_plecare') ? 'is-invalid' : '' }}"
                                                name="retur_ora_id"
                                                v-model="retur_ora_plecare"
                                            @change='getReturOraSosire()'>
                                                <option v-for='retur_ora_plecare in retur_ore_plecare'                                
                                                    :value='retur_ora_plecare.id'                                       
                                                    >
                                                    @{{retur_ora_plecare.ora}}
                                                </option>
                                            </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="retur_ora_sosire" class="mb-0">Ora debarcare:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('retur_ora_sosire') ? 'is-invalid' : '' }}" 
                                            name="retur_ora_sosire" 
                                            placeholder="" 
                                                v-model="retur_ora_sosire"
                                            required
                                            disabled
                                            >  
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mb-0 bg-success text-white mx-0">
                                    <div class="form-group col-lg-12">
                                        <label for="nume" class="mb-0">Statie îmbarcare retur:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('retur_statie_imbarcare') ? 'is-invalid' : '' }}" 
                                            name="retur_statie_imbarcare" 
                                            placeholder="Statie imbarcare retur" 
                                            value="{{ old('retur_statie_imbarcare') }}"
                                            required> 
                                    </div>
                                </div>
                            </div>                    

                            <div class="form-group col-lg-6 border card bg-warning text-dark shadow-sm px-2">
                                <div class="form-row mb-0 d-flex justify-content-center">
                                    <div class="form-group col-lg-6 mb-0 ">
                                        <label for="retur_data_cursa" class="mb-0">Data plecării:</label>
                                        <vue2-datepicker
                                            data-veche="{{ old('retur_data_cursa') }}"
                                            nume-camp-db="retur_data_cursa"
                                            tip="date"
                                            latime="150"
                                        ></vue2-datepicker> 
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="retur_zbor_ora_decolare" class="mb-0">Oră decolare:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('retur_zbor_ora_decolare') ? 'is-invalid' : '' }}" 
                                            name="retur_zbor_ora_decolare" 
                                            placeholder="00:00" 
                                            value="{{ old('retur_zbor_ora_decolare') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-row mb-0 d-flex justify-content-center">
                                    <div class="form-group col-lg-6">
                                        <label for="retur_zbor_oras_decolare" class="mb-0">Oraș decolare avion:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('retur_zbor_oras_decolare') ? 'is-invalid' : '' }}" 
                                            name="retur_zbor_oras_decolare" 
                                            placeholder="" 
                                            value="{{ old('retur_zbor_oras_decolare') }}"
                                            required>  
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="retur_zbor_ora_aterizare" class="mb-0">Ora aterizare:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('retur_zbor_ora_aterizare') ? 'is-invalid' : '' }}" 
                                            name="retur_zbor_ora_aterizare" 
                                            placeholder="00:00" 
                                            value="{{ old('retur_zbor_ora_aterizare') }}"
                                            required>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-lg-12 d-flex justify-content-center">                        
                        <button type="submit" class="btn btn-primary mr-4">Adaugă Rezervare</button> 
                        <button type="button" class="btn btn-dark ml-4" v-on:click="retur = !retur">Retur</button> 
                    </div>
                </div> 
                
            </form>
        </div>
    </div>
</div>
@endsection