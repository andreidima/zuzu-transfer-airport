@extends('layouts.app')

@section('content')
<div>
    <div class="container p-0" id="orase-ore-plecare">

        @include ('errors')
        
        <div class="">
            <form  class="needs-validation" novalidate method="POST" action="{{ $rezervari->path() }}">
                @method('PATCH')
                @csrf     

                <div class="form-row mb-0 d-flex justify-content-center">   
                    <div class="form-group col-lg-6 shadow-sm mb-0">
                        <div class="form-row mb-0 d-flex justify-content-between"> 
                                <h5 class="mb-0">
                                    <span class="badge text-dark" style="background-color:#c3c3c3">
                                        Cod bilet: RO{{ $rezervari->id }}
                                    </span>
                                </h5>
                                <h5 class="mb-0">
                                    <span class="badge text-dark" style="background-color:#c3c3c3">
                                        Emis la data de: {{ $rezervari->created_at }}
                                    </span>
                                </h5>
                        </div>
                    </div>
                </div>
                <div class="form-row mb-0 d-flex justify-content-center"> 
                    <div class="form-group col-lg-6 card text-dark shadow-sm px-2 mb-0" style="background-color:#c3c3c3">
                        <div class="form-row mb-0 d-flex justify-content-between">
                            <div class="form-group col-lg-5 mb-0">
                                <script type="application/javascript"> 
                                    orasPlecareVechi={!! json_encode(old('oras_plecare', $rezervari->cursa->plecare_id)) !!}
                                    statieImbarcareVeche = 0
                                    returOraPlecareVeche = 0                                    
                                    plataOnlineVeche = 0
                                </script>       
                                <label for="oras_plecare" class="mb-0">Plecare din:<span class="text-danger">*</span></label>
                                    <select class="custom-select-sm custom-select {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}"
                                        name="oras_plecare"
                                        v-model="oras_plecare"
                                        v-if="oras_plecare.id = 8"
                                        {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
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
                            <div class="form-group col-lg-5 mb-0">
                                <script type="application/javascript"> 
                                    orasSosireVechi={!! json_encode(old('oras_sosire', $rezervari->cursa->sosire_id)) !!}
                                </script>        
                                <label for="oras_sosire" class="mb-0">Sosire la:<span class="text-danger">*</span></label>
                                    <select class="custom-select-sm custom-select {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}"
                                        name="oras_sosire"
                                        v-model="oras_sosire"
                                        {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                    @change='getOrePlecare();getReturOrePlecare();'>
                                            <option v-for='oras_sosire in orase_sosire'                                
                                            :value='oras_sosire.id'                                       
                                            >@{{oras_sosire.nume}}</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-row mb-2 d-flex justify-content-between">
                            <div class="form-group col-lg-5 mb-0">
                                <script type="application/javascript"> 
                                    oraPlecareVeche={!! json_encode(old('ora_plecare', $rezervari->ora->id)) !!}
                                </script>        
                                <label for="ora_id" class="mb-0">Ora de plecare:<span class="text-danger">*</span></label>
                                    <select class="custom-select custom-select-sm {{ $errors->has('ora_id') ? 'is-invalid' : '' }}"
                                        name="ora_id"
                                        v-model="ora_plecare"
                                        {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                    @change='getOraSosire()'>
                                        <option v-for='ora_plecare in ore_plecare'                                
                                            :value='ora_plecare.id'                                       
                                            >
                                            @{{ora_plecare.ora}}
                                        </option>
                                    </select>
                            </div>
                            <div class="form-group col-lg-5 mb-0">
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
                </div>

                <div class="form-row mb-0 d-flex justify-content-center">
                    <div class="form-group col-lg-6 border card text-dark shadow-sm px-2 mb-0" style="background-color:#c3c3c3">
                        <div class="form-row mb-0 d-flex justify-content-between">
                            <div class="form-group col-lg-5 mb-0 ">
                                <label for="data_cursa" class="mb-0">Data plecării:<span class="text-danger">*</span></label>
                                <vue2-datepicker
                                    data-veche="{{ old('data_cursa') == '' ? $rezervari->data_cursa : old('data_cursa') }}"
                                    nume-camp-db="data_cursa"
                                    tip="date"
                                    latime="150"
                                    not-before="{{ \Carbon\Carbon::today() }}"
                                    {{ auth()->user()->isDispecer() ? '' : 'disabled-date'}}
                                ></vue2-datepicker> 
                            </div>
                            <div class="form-group col-lg-5 mb-0">
                                <label for="zbor_ora_decolare" class="mb-0">Oră decolare:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('zbor_ora_decolare') ? 'is-invalid' : '' }}" 
                                    name="zbor_ora_decolare" 
                                    placeholder="00:00" 
                                    value="{{ old('zbor_ora_decolare') == '' ? $rezervari->zbor_ora_decolare : old('zbor_ora_decolare') }}"
                                    {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                    required>
                            </div>
                        </div>
                        <div class="form-row mb-2 d-flex justify-content-between">
                            <div class="form-group col-lg-5 mb-0">
                                <label for="zbor_oras_decolare" class="mb-0">Oraș decolare avion:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('zbor_oras_decolare') ? 'is-invalid' : '' }}" 
                                    name="zbor_oras_decolare" 
                                    placeholder="" 
                                    value="{{ old('zbor_oras_decolare') == '' ? $rezervari->zbor_oras_decolare : old('zbor_oras_decolare') }}"
                                    style="text-transform:uppercase"
                                    {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                    required>  
                            </div>
                            <div class="form-group col-lg-5 mb-0">
                                <label for="zbor_ora_aterizare" class="mb-0">Ora aterizare:</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('zbor_ora_aterizare') ? 'is-invalid' : '' }}" 
                                    name="zbor_ora_aterizare" 
                                    placeholder="00:00" 
                                    value="{{ old('zbor_ora_aterizare') == '' ? $rezervari->zbor_ora_aterizare : old('zbor_ora_aterizare') }}"
                                    {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                    required>  
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-row mb-2 d-flex justify-content-center">   
                    <div class="form-group col-lg-6 card text-dark shadow-sm px-2 mb-0" style="background-color:#c3c3c3"> 
                        <div class="form-group row mb-0">
                            <div class="form-group col-lg-12 my-2">
                                {{-- <label for="nume" class="mb-0">Nume client:<span class="text-danger">*</span></label> --}}
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('nume') ? 'is-invalid' : '' }}" 
                                    name="nume" 
                                    placeholder="Nume client" 
                                    value="{{ old('nume') == '' ? $rezervari->nume : old('nume') }}"
                                    style="text-transform:uppercase"
                                    {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                    required> 
                            </div>
                            <div class="form-group col-lg-12 mb-2">
                                {{-- <label for="telefon" class="mb-0">Telefon:<span class="text-danger">*</span></label> --}}
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('telefon') ? 'is-invalid' : '' }}" 
                                    name="telefon" 
                                    placeholder="Telefon" 
                                    value="{{ old('telefon') == '' ? $rezervari->telefon : old('telefon') }}"
                                    required> 
                            </div>  
                            <div class="form-group col-lg-12 mb-1">
                                {{-- <label for="email" class="mb-0">E-mail:</label> --}}
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                    name="email" 
                                    placeholder="E-mail" 
                                    value="{{ old('email') == '' ? $rezervari->email : old('email') }}"
                                    {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                    required> 
                            </div> 
                            <div class="form-group col-lg-12 mb-1">
                                <label for="nume" class="mb-0">
                                    Statie îmbarcare:
                                    @if(!empty($rezervari->statie))
                                        {{ $rezervari->statie->nume }}
                                    @endif
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-sm {{ $errors->has('statie_imbarcare') ? 'is-invalid' : '' }}" 
                                    name="statie_imbarcare" 
                                    placeholder="" 
                                    value="{{ old('statie_imbarcare') == '' ? $rezervari->statie_imbarcare : old('statie_imbarcare') }}"
                                    required> 
                            </div>
                            <div class="form-group col-lg-12 mb-0 pt-1 border-top border-bottom">
                                    {{-- <label for="nume" class="mb-0">Număr de locuri rezervate:</label>  --}}
                                <div class="form-group row mb-0">                                
                                        <div class="form-group col-lg-7 mb-0 d-flex">
                                            {{-- <label for="nume" class="mb-0">Număr de locuri:</label> --}}
                                                <script type="application/javascript"> 
                                                    nrAdultiVechi={!! json_encode(old('nr_adulti', $rezervari->nr_adulti)) !!}
                                                </script>  
                                                <label for="nr_adulti" class="col-form-label pr-0">Număr de locuri:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adulți:<span class="text-danger">*</span></label>
                                                    <div class="pl-0" style="width:80px">
                                                    <input 
                                                        type="text"
                                                        {{-- min="0"
                                                        max="20"  --}}
                                                        class="form-control form-control-sm {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}" 
                                                        name="nr_adulti" 
                                                        v-model="nr_adulti" 
                                                        value="{{ old('nr_adulti') }}"
                                                        required
                                                        v-on:input='getPretTotal()'
                                                        {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                                        > 
                                                    {{-- <select class="custom-select custom-select-sm {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}"
                                                        name="nr_adulti"
                                                        v-model="nr_adulti"
                                                        {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                                    @change='getPretTotal()'>
                                                        @for ($i = 1; $i < 16; $i++)
                                                            <option>{{ $i }}</option>
                                                        @endfor                                                        
                                                    </select> --}}
                                                    </div>                                       
                                        </div>  
                                        <div class="form-group col-lg-5 mb-0 d-flex">
                                            <script type="application/javascript"> 
                                                nrCopiiVechi={!! json_encode(old('nr_copii', $rezervari->nr_copii)) !!}
                                            </script>  
                                            <label for="nr_copii" class="col-form-label pr-0">Copii:</label>
                                                <div class="px-0" style="width:80px">
                                                <input 
                                                    type="text"
                                                    {{-- min="0"
                                                    max="10"  --}}
                                                    class="form-control form-control-sm {{ $errors->has('nr_copii') ? 'is-invalid' : '' }}" 
                                                    name="nr_copii" 
                                                    v-model="nr_copii" 
                                                    value="{{ old('nr_copii') }}"
                                                    required
                                                    v-on:input='getPretTotal()'
                                                    {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                                    >
                                                {{-- <select class="custom-select custom-select-sm {{ $errors->has('nr_copii') ? 'is-invalid' : '' }}"
                                                    name="nr_copii"
                                                    v-model="nr_copii"
                                                    {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                                @change='getPretTotal()'>
                                                    @for ($i = 1; $i < 11; $i++)
                                                        <option>{{ $i }}</option>
                                                    @endfor                                                        
                                                </select> --}}
                                                </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                2-7 ani
                                            </label>
                                        </div>
                                </div>
                            </div>               
                            <div class="form-group col-lg-12 mb-0 pt-1 border-bottom d-flex">
                                <div class="form-group row mb-1">
                                    <div class="form-group col-lg-12 mb-0 d-flex">
                                        <label class="col-form-label mb-0 pb-0">
                                            Completați doar dacă încasați comisionul agenției:
                                        </label>
                                        <div class="px-1 mb-0" style="width:80px">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm {{ $errors->has('comision_agentie') ? 'is-invalid' : '' }}"
                                                name="comision_agentie"
                                                placeholder="0"
                                                value="{{ old('comision_agentie') == '' ? $rezervari->comision_agentie : old('comision_agentie') }}"
                                                {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                                {{-- {{ old('statie_imbarcare') == '' ? $rezervari->statie_imbarcare : old('statie_imbarcare') }} --}}
                                                >
                                        </div>
                                        <label class="col-form-label mb-0 pb-0">
                                            lei
                                        </label>
                                    </div>
                                </div>
                            </div>                       
                            <div class="form-group col-lg-12 mb-0 mt-1 d-flex border-bottom">
                                <label class="mr-2">Plata:<span class="text-danger">*</span></label>
                                <div class="form-check mr-4">
                                    <input type="checkbox" class="form-check-input" name="tip_plata_id" value="1"
                                    {{ old('tip_plata_id', $rezervari->tip_plata_id) == '1' ? 'checked' : '' }}
                                    {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                    >
                                    <label class="form-check-label" for="tip_plata_id">La șofer</label>
                                </div>
                                <div class="form-check ml-4">
                                    <input type="checkbox" class="form-check-input" name="tip_plata_id" value="2"
                                    {{ old('tip_plata_id', $rezervari->tip_plata_id) == '2' ? 'checked' : '' }}
                                    {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                    >
                                    <label class="form-check-label" for="tip_plata_id">La agenție</label>
                                </div>
                            </div>                     
                            <div class="form-group col-lg-12 mb-0 mt-1 d-flex border-bottom">
                                <script type="application/javascript"> 
                                    pretTotal={!! json_encode(old('pret_total', $rezervari->pret_total)) !!}
                                </script>
                                <label for="pret_total" class="col-form-label mb-0">Preț total:</label>
                                <div class="px-1 mb-0" style="width:80px">
                                    <input 
                                        type="text" 
                                        class="form-control form-control-sm {{ $errors->has('pret_total') ? 'is-invalid' : '' }}" 
                                        name="pret_total"
                                        placeholder="0" 
                                        value="{{ old('pret_total') == '' ? $rezervari->pret_total : old('pret_total') }}"
                                        required
                                        {{ auth()->user()->isDispecer() ? '' : 'disabled'}}
                                        > 
                                </div> 
                                <label class="col-form-label mb-0 pb-0">
                                    lei
                                </label>
                            </div> 
                            <div class="form-group col-lg-12 mb-0 d-flex">                                
                                Total plata acum:
                                    @if (($rezervari->comision_agentie == 0) && ($rezervari->tip_plata_id == 2))
                                        {{ $rezervari->pret_total }}
                                    @elseif ($rezervari->tip_plata_id == 3)
                                        0
                                    @else 
                                        {{ $rezervari->comision_agentie - 0}}
                                    @endif
                                    lei                                
                                <br>                                
                                Total plata la imbarcare:
                                    @if (($rezervari->comision_agentie == 0) && ($rezervari->tip_plata_id == 2))
                                        0
                                    @elseif ($rezervari->tip_plata_id == 3)
                                        0
                                    @else 
                                        {{ $rezervari->pret_total - $rezervari->comision_agentie }}
                                    @endif
                                    lei
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="form-row justify-content-center">
                    <div class="col-lg-6">                        
                        <button type="submit" class="btn btn-primary" style="width: 100%; height:100%; white-space: normal;">Salvare modificare</button> 
                    </div>
                </div>                    
            </form>
        </div>
    </div>
</div>
@endsection