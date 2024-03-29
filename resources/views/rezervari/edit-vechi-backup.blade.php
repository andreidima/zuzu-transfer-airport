@extends('layouts.app')

@section('content')
<div>
    <div class="container card px-0" id="orase-ore-plecare"> 
        <div class="d-flex justify-content-between card-header mb-1">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a> - Modifică rezervarea</h4>
            </div>
            <div>
                <a class="btn btn-secondary" href="/rezervari" role="button">Renunță</a>
            </div>
        </div>

        @include ('errors')
        
        <div class="card-body">
            <form  class="needs-validation" novalidate method="POST" action="{{ $rezervari->path() }}">
                @method('PATCH')
                @csrf     

                <div class="form-row mb-4">
                    <div class="col-lg-4">
                        <div class="card text-white bg-primary">
                            <div class="card-header text-center h4"> Informații cursă </div>
                            <div class="card-body">
                                <div class="form-row mb-2">
                                    <div class="form-group col-lg-6">
                                        <script type="application/javascript">
                                            orasPlecareVechi={!! json_encode(old('oras_plecare', $rezervari->cursa->plecare_id)) !!}
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
                                            orasSosireVechi={!! json_encode(old('oras_sosire', $rezervari->cursa->sosire_id)) !!}
                                        </script>        
                                        <label for="oras_sosire" class="mb-0">Sosire la:</label>
                                            <select class="custom-select-sm custom-select {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}"
                                                name="oras_sosire"
                                                v-model="oras_sosire"
                                            @change='getOrePlecare()'>
                                                    <option v-for='oras_sosire in orase_sosire'                                
                                                    :value='oras_sosire.id'                                       
                                                    >@{{oras_sosire.nume}}</option>
                                            </select>
                                    </div>
                                </div> 
                                <div class="form-row mb-2">
                                    <div class="form-group col-lg-6">
                                        <script type="application/javascript"> 
                                            oraPlecareVeche={!! json_encode(old('ora_plecare', $rezervari->ora->id)) !!}
                                        </script>        
                                        <label for="ora_id" class="mb-0">Ora de plecare</label>
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
                                <div class="form-row mb-0">
                                    <div class="form-group col-lg-6">
                                        <script type="application/javascript"> 
                                            statieImbarcareVeche={!! json_encode(old('statie_id', $rezervari->statie_id)) !!}
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
                            <div class="card-footer d-flex" style="height:116px">
                                <div class="form-row mb-0 justify-content-center align-self-center">
                                    <div class="form-group col-lg-12 mb-2">
                                        <label for="data_cursa" class="mb-0">Data plecării:</label>
                                        <vue2-datepicker
                                            data-veche="{{ old('data_cursa') == '' ? $rezervari->data_cursa : old('data_cursa') }}"
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
                                            value="{{ old('nume') == '' ? $rezervari->nume : old('nume') }}"
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
                                            value="{{ old('telefon') == '' ? $rezervari->telefon : old('telefon') }}"
                                            required> 
                                    </div>  
                                    <div class="form-group col-lg-6">
                                        <label for="email" class="mb-0">E-mail:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                            name="email" 
                                            placeholder="E-mail" 
                                            value="{{ old('email') == '' ? $rezervari->email : old('email') }}"
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
                                                nrAdultiVechi={!! json_encode(old('nr_adulti', $rezervari->nr_adulti)) !!}
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
                                                    v-on:input='getPretTotal()'
                                                    > 
                                                </div>
                                        </div>                                        
                                    </div>  
                                    <div class="form-group col-lg-6 mb-0">
                                        <div class="form-group row mb-0">
                                            <script type="application/javascript"> 
                                                nrCopiiVechi={!! json_encode(old('nr_copii', $rezervari->nr_copii)) !!}
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
                                        <label class="mb-0">
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
                                            value="{{ old('zbor_oras_decolare') == '' ? $rezervari->zbor_oras_decolare : old('zbor_oras_decolare') }}"
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
                                            value="{{ old('zbor_ora_decolare') == '' ? $rezervari->zbor_ora_decolare : old('zbor_ora_decolare') }}"
                                            required>
                                        {{-- <small id="zbor_ora_decolare" class="form-text">Ex: [ora : min]</small>  --}}
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="zbor_ora_aterizare" class="mb-0">Ora aterizare:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('zbor_ora_aterizare') ? 'is-invalid' : '' }}" 
                                            name="zbor_ora_aterizare" 
                                            placeholder="00:00" 
                                            value="{{ old('zbor_ora_aterizare') == '' ? $rezervari->zbor_ora_aterizare : old('zbor_ora_aterizare') }}"
                                            required>  
                                        {{-- <small id="zbor_ora_decolare" class="form-text">Ex: [ora : min]</small>  --}}
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
                                        {{ $rezervari->pret_total }}
                                        <script type="application/javascript"> 
                                            pretTotal={!! json_encode(old('pret_total', $rezervari->pret_total)) !!}
                                        </script>  
                                        <label for="pret_total" class="mb-0">Preț total:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('pret_total') ? 'is-invalid' : '' }}" 
                                            name="pret_total"
                                            v-model="pret_total" 
                                            placeholder="0" 
                                            value="{{ old('pret_total') == '' ? $rezervari->pret_total : old('pret_total') }}"
                                            required> 
                                    </div>  
                                    <div class="form-group col-lg-6">
                                        <label for="comision_agentie" class="mb-0">Comision agenție:</label>
                                        <input 
                                            type="text" 
                                            class="form-control form-control-sm {{ $errors->has('comision_agentie') ? 'is-invalid' : '' }}" 
                                            name="comision_agentie"
                                            placeholder="0" 
                                            value="{{ old('comision_agentie') == '' ? $rezervari->comision_agentie : old('comision_agentie') }}"
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
                                        >{{ old('observatii') == '' ? $rezervari->observatii : old('observatii') }}</textarea> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-lg-12 align-self-end" style="height:60px;">                        
                        <button type="submit" class="btn btn-primary float-right" style="width: 100%; height:100%; white-space: normal;">Modifică Rezervarea</button> 
                    </div>
                </div>                 
            </form>
        </div>  
    </div>
  
                                        <script type="application/javascript"> 
                                            returOraPlecareVeche={!! json_encode(old('ora_id', "0")) !!}
                                        </script>  
                                        <script type="application/javascript"> 
                                            returVechi=false
                                        </script>    
   
@endsection