@extends('layouts.app')

@section('content')
<div>
    <div class="container p-0 " id="orase-ore-plecare">
        {{-- <div class="d-flex justify-content-between card-header mb-1">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a> - Adaugă o rezervare nouă</h4>
            </div>
            <div>
                <a class="btn btn-secondary" href="/rezervari" role="button">Renunță</a>
            </div>
        </div> --}}

        @include ('errors')

        <div class="">
            <form  class="needs-validation" novalidate method="POST" action="/rezervari" style="font-size:0.8rem">
                @csrf

                {{-- <div class="form-row mb-2 d-flex justify-content-center">
                    <div class="form-group col-lg-9 card text-dark shadow-sm p-0 mb-1 text-center" style="background-color:#FFDF8E">
                        <h6 class="m-0 p-0">Preturile au fost modificate de la 1 Aprilie 2020 pe perioada starii de urgenta! Multumim pentru intelegere!</h6>
                    </div>
                </div> --}}

                <div class="form-row mb-0 d-flex justify-content-center">
                    <div class="form-group col-lg-6 card text-dark shadow-sm px-2 mb-0" style="background-color:#FFDF8E">
                        <div class="form-row mb-0 d-flex justify-content-between">
                            <div class="form-group col-lg-5 m-0">
                                <script type="application/javascript">
                                    orasPlecareVechi={!! json_encode(old('oras_plecare', "0")) !!}
                                    statieImbarcareVeche = 0
                                    nrAdultiVechi = 0
                                    nrCopiiVechi = 0
                                    plataOnlineVeche = 0
                                </script>
                                <label for="oras_plecare" class="form-label mb-0">Plecare din:<span class="text-danger">*</span></label>
                                    <select class="form-select {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}"
                                        name="oras_plecare"
                                        v-model="oras_plecare"
                                        v-if="oras_plecare.id = 8"
                                    @change='getOraseSosire();oferta_5_adulti();'>
                                            <optgroup label="Oraș">
                                                <option v-for='oras_plecare in orase_plecare'
                                                :value='oras_plecare.id'
                                                v-bind:style= "[oras_plecare.id == 3 ? {color: 'black', 'font-weight': 'bold'} : {}]"
                                                >
                                                    @{{oras_plecare.nume}}
                                                </option>
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
                                <label for="oras_sosire" class="form-label mb-0">Sosire la:<span class="text-danger">*</span></label>
                                    <select class="form-select {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}"
                                        name="oras_sosire"
                                        v-model="oras_sosire"
                                    @change='getOrePlecare();getReturOrePlecare();'>
                                            <option v-for='oras_sosire in orase_sosire'
                                            :value='oras_sosire.id'
                                            v-bind:style= "[oras_sosire.id == 3 ? {color: 'black', 'font-weight': 'bold'} : {}]"
                                            >@{{oras_sosire.nume}}</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-row mb-2 d-flex justify-content-between">
                            <div class="form-group col-lg-5 m-0">
                                <script type="application/javascript">
                                    oraPlecareVeche={!! json_encode(old('ora_id', "0")) !!}
                                </script>
                                <label for="ora_id" class="form-label mb-0">Ora de plecare:<span class="text-danger">*</span></label>
                                    <select class="form-select {{ $errors->has('ora_id') ? 'is-invalid' : '' }}"
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
                                <label for="ora_sosire" class="form-label mb-0">Ora sosire:</label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('ora_sosire') ? 'is-invalid' : '' }}"
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
                    <div class="form-group col-lg-6 card shadow-sm px-2 mb-0" style="background-color:#FFDF8E">
                        <div class="form-row mb-0 d-flex justify-content-between">
                            <div class="form-group col-lg-5 mb-0 ">
                                <label for="data_cursa" class="mb-0">Data plecării:<span class="text-danger">*</span></label>
                                <vue2-datepicker
                                    data-veche="{{ old('data_cursa') == '' ? '' : old('data_cursa') }}"
                                    nume-camp-db="data_cursa"
                                    tip="date"
                                    latime="220"
                                    not-before="{{ \Carbon\Carbon::today() }}"
                                    {{-- disabled-dates="{{ \Carbon\Carbon::tomorrow() }}" --}}
                                    style="box-shadow: 0px 0px 5px yellow;"
                                ></vue2-datepicker>
                            </div>
                            <div class="form-group col-lg-5 m-0">
                                <label for="zbor_ora_decolare" class="mb-0">Oră decolare:</label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('zbor_ora_decolare') ? 'is-invalid' : '' }}"
                                    name="zbor_ora_decolare"
                                    placeholder="00:00"
                                    value="{{ old('zbor_ora_decolare') }}"
                                    style="box-shadow: 0px 0px 5px yellow;"
                                    required>
                            </div>
                        </div>
                        <div class="form-row mb-2 d-flex justify-content-between">
                            <div class="form-group col-lg-5 m-0">
                                <label for="zbor_oras_decolare" class="mb-0">Oraș decolare avion:<span class="text-light">*</span></label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('zbor_oras_decolare') ? 'is-invalid' : '' }}"
                                    name="zbor_oras_decolare"
                                    placeholder=""
                                    value="{{ old('zbor_oras_decolare') }}"
                                    style="text-transform:uppercase; box-shadow: 0px 0px 5px yellow;"
                                    required>
                            </div>
                            <div class="form-group col-lg-5 m-0">
                                <label for="zbor_ora_aterizare" class="mb-0">Ora aterizare:<span class="text-light">*</span></label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('zbor_ora_aterizare') ? 'is-invalid' : '' }}"
                                    name="zbor_ora_aterizare"
                                    placeholder="00:00"
                                    value="{{ old('zbor_ora_aterizare') }}"
                                    style="box-shadow: 0px 0px 5px yellow;"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-row mb-2 d-flex justify-content-center">
                    <div class="form-group col-lg-6 card shadow-sm px-2 mb-0" style="background-color:#FFDF8E">
                        <div class="form-group row mb-0">
                            <div class="form-group col-lg-12 my-2">
                                {{-- <label for="nume" class="mb-0">Nume client:<span class="text-danger">*</span></label> --}}
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('nume') ? 'is-invalid' : '' }}"
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
                                    class="form-control {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                                    name="telefon"
                                    placeholder="Telefon"
                                    autocomplete="off"
                                    value="{{ old('telefon') }}"
                                    required>
                            </div>
                            <div class="form-group col-lg-12 mb-1">
                                {{-- <label for="email" class="mb-0">E-mail:</label> --}}
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    name="email"
                                    placeholder="E-mail"
                                    value="{{ old('email') }}"
                                    >
                            </div>
                            <div class="form-group col-lg-12 mb-1">
                                <label for="nume" class="mb-0">Statie îmbarcare:</label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('statie_imbarcare') ? 'is-invalid' : '' }}"
                                    name="statie_imbarcare"
                                    placeholder=""
                                    value="{{ old('statie_imbarcare') }}"
                                    required>
                            </div>
                            <div class="form-group col-lg-12 mb-0 pt-1 border-top border-bottom border-white">
                                    {{-- <label for="nume" class="mb-0">Număr de locuri rezervate:</label>  --}}
                                <div class="form-group row mb-0">
                                        <div class="form-group col-lg-7 mb-0 d-flex">
                                            {{-- <label for="nume" class="mb-0">Număr de locuri:</label> --}}
                                                <script type="application/javascript">
                                                    nrAdultiVechi={!! json_encode(old('nr_adulti', " ")) !!}
                                                </script>
                                                <label for="nr_adulti" class="col-form-label pr-0">Număr de locuri:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adulți:<span class="text-danger">*</span></label>
                                                    <div class="pl-0" style="width:100px">
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
                                                    <select class="form-select {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}"
                                                        name="nr_adulti"
                                                        v-model="nr_adulti"
                                                    @change='getPretTotal();oferta_5_adulti();'>
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
                                                    <select class="form-select {{ $errors->has('nr_copii') ? 'is-invalid' : '' }}"
                                                        name="nr_copii"
                                                        v-model="nr_copii"
                                                    @change='getPretTotal()'>
                                                        @for ($i = 1; $i < 11; $i++)
                                                            <option>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            <label id="" class="col-form-label pl-1 align-bottom">
                                                2-7 ani
                                            </label>
                                        </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 mb-0 pt-1 border-bottom border-white d-flex">
                                <div class="form-group row mb-1">
                                    <div class="form-group col-lg-12 mb-0 d-flex">
                                        <label class="col-form-label mb-0 pb-0">
                                            Completați doar dacă încasați comisionul agenției:
                                        </label>
                                        <div class="px-1 mb-0" style="width:80px">
                                            <input
                                                type="text"
                                                class="form-control {{ $errors->has('comision_agentie') ? 'is-invalid' : '' }}"
                                                name="comision_agentie"
                                                placeholder="0"
                                                value="{{ old('comision_agentie') }}"
                                                >
                                        </div>
                                        <label class="col-form-label mb-0 pb-0">
                                            lei
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 mb-0 mt-1 d-flex">
                                {{-- <span class="badge text-white m-0" style="background-color:darkcyan; font-size: 1em;"> --}}
                                    <label class="mr-2"><b>Plata:</b></label>
                                    {{-- <div class="form-check mr-4">
                                        <input type="checkbox" class="form-check-input" name="tip_plata_id" value="1"
                                        {{ old('tip_plata_id') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tip_plata_id">La șofer</label>
                                    </div> --}}
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="tip_plata_id" v-model="tip_plata_la_agentie" @change='oferta_5_adulti()' value="2"
                                        {{ old('tip_plata_id') == '2' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tip_plata_id"><b>La agenție</b></label>
                                    </div>
                                {{-- </span> --}}
                            </div>
                            {{-- <div class="form-group col-lg-4 mb-0 mt-2 d-flex"> --}}
                                <script type="application/javascript">
                                    pretTotal={!! json_encode(old('pret_total', "0")) !!}
                                </script>
                                {{-- <label for="pret_total" class="col-form-label mb-0">Preț total:</label>
                                <div style="width:80px">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm {{ $errors->has('pret_total') ? 'is-invalid' : '' }}"
                                        name="pret_total"
                                        v-model="pret_total"
                                        placeholder="0"
                                        value="{{ old('pret_total') }}"
                                        required>
                                </div>
                            </div>  --}}
                        </div>
                    </div>
                </div>




            {{-- <script type="application/javascript">
                returVechi={!! json_encode(old('retur', false)) !!}
            </script> --}}

            <div v-show="retur" class="mb-2">
                <div class="form-row justify-content-center">
                    {{-- <div class="col-md-auto card bg-dark justify-content-center px-0">
                        <h4 style="width:16px; word-wrap: break-word; white-space:pre-wrap;">
                            RETUR
                        </h4>
                    </div> --}}
                    <div class="mx-auto col-lg-6 card border-dark">
                        <div class="form-row mb-0 justify-content-center">
                            <div class="form-group col-lg-12 card shadow-sm p-0 m-0 bg-dark text-white text-center">
                                Retur
                            </div>
                        </div>
                        <div class="form-row mb-0 justify-content-center">
                            <div class="form-group col-lg-12 card shadow-sm px-2 mb-0" style="background-color:#FFDF8E">
                                <div class="form-row mb-2 d-flex justify-content-between">
                                    <div class="form-group col-lg-5 mb-0">
                                        <script type="application/javascript">
                                            returOraPlecareVeche={!! json_encode(old('retur_ora_id', "0")) !!}
                                        </script>
                                        <label for="ora_id" class="form-label mb-0">Ora îmbarcare:<span class="text-danger">*</span></label>
                                            <select class="form-select {{ $errors->has('retur_ora_id') ? 'is-invalid' : '' }}"
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
                                    <div class="form-group col-lg-5 mb-0">
                                        <label for="retur_ora_sosire" class="form-label mb-0">Ora debarcare:</label>
                                        <input
                                            type="text"
                                            class="form-control {{ $errors->has('retur_ora_sosire') ? 'is-invalid' : '' }}"
                                            name="retur_ora_sosire"
                                            placeholder=""
                                                v-model="retur_ora_sosire"
                                            required
                                            disabled
                                            >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mb-0 justify-content-center">
                            <div class="form-group col-lg-12 card shadow-sm px-2 mb-0" style="background-color:#FFDF8E">
                                <div class="form-row mb-0 d-flex justify-content-between">
                                    <div class="form-group col-lg-5 m-0">
                                        <label for="retur_data_cursa" class="mb-0">Data plecării:<span class="text-danger">*</span></label>
                                        <vue2-datepicker
                                            data-veche="{{ old('retur_data_cursa') == '' ? '' : old('retur_data_cursa') }}"
                                            nume-camp-db="retur_data_cursa"
                                            tip="date"
                                            latime="150"
                                            not-before="{{ \Carbon\Carbon::today() }}"
                                        ></vue2-datepicker>
                                    </div>
                                    <div class="form-group col-lg-5 m-0">
                                        <label for="retur_zbor_ora_decolare" class="mb-0">Oră decolare:</label>
                                        <input
                                            type="text"
                                            class="form-control {{ $errors->has('retur_zbor_ora_decolare') ? 'is-invalid' : '' }}"
                                            name="retur_zbor_ora_decolare"
                                            placeholder="00:00"
                                            value="{{ old('retur_zbor_ora_decolare') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-row mb-2 d-flex justify-content-between">
                                    <div class="form-group col-lg-5 mb-0">
                                        <label for="retur_zbor_oras_decolare" class="mb-0">Oraș decolare avion:</label>
                                        <input
                                            type="text"
                                            class="form-control {{ $errors->has('retur_zbor_oras_decolare') ? 'is-invalid' : '' }}"
                                            name="retur_zbor_oras_decolare"
                                            placeholder=""
                                            value="{{ old('retur_zbor_oras_decolare') }}"
                                            style="text-transform:uppercase"
                                            required>
                                    </div>
                                    <div class="form-group col-lg-5 mb-0">
                                        <label for="retur_zbor_ora_aterizare" class="mb-0">Ora aterizare:</label>
                                        <input
                                            type="text"
                                            class="form-control {{ $errors->has('retur_zbor_ora_aterizare') ? 'is-invalid' : '' }}"
                                            name="retur_zbor_ora_aterizare"
                                            placeholder="00:00"
                                            value="{{ old('retur_zbor_ora_aterizare') }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mb-0 justify-content-center">
                            <div class="form-group col-lg-12 card shadow-sm px-2 mb-0 pb-2" style="background-color:#FFDF8E">
                                        <label for="nume" class="mb-0">Statie îmbarcare retur:</label>
                                        <input
                                            type="text"
                                            class="form-control {{ $errors->has('retur_statie_imbarcare') ? 'is-invalid' : '' }}"
                                            name="retur_statie_imbarcare"
                                            placeholder=""
                                            value="{{ old('retur_statie_imbarcare') }}"
                                            required>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-auto card bg-dark justify-content-center px-0">
                        <h4 style="width:16px; word-wrap: break-word; white-space:pre-wrap;">
                            RETUR
                        </h4>
                    </div> --}}
                </div>
            </div>

                <div class="form-row">
                    <div class="col-lg-6 d-flex justify-content-center m-auto">
                        <input
                                type="hidden"
                                name="oferta"
                                v-model="oferta">



                        {{-- @if ((auth()->user()->id == 355) || (auth()->user()->id == 356)) --}}
                            <div v-if="oferta" class="col-lg-12 px-0">
                                <div class="text-center mb-4">
                                    <div class="card border-success">
                                        <h5 class="card-header bg-success text-white">Ofertă pentru grupuri de minim 5 adulți doar în Otopeni!</h5>
                                        <div class="card-body">
                                                <h6 v-if="oferta === 'Tecuci_Panciu_Adjud'" class="mb-3">Plata tur la Agenție, 120 lei/adult (60 lei/copil).</h6>
                                                <h6 v-if="oferta === 'Galati_Ianca_Braila'" class="mb-3">Plata tur la Agenție, 100 lei/adult (60 lei/copil).</h6>
                                                <h6 v-if="oferta === 'Vaslui'" class="mb-3">Plata tur la Agenție, 150 lei/adult (90 lei/copil).</h6>
                                                <h6 v-if="oferta === 'Barlad'" class="mb-3">Plata tur la Agenție, 140 lei/adult (80 lei/copil).</h6>
                                            <button type="submit" name="action" value="cu_oferta" class="btn btn-success">Adaugă Rezervarea folosind Oferta</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-center m-auto">
                                    <button type="submit" name="action" value="fara_oferta" class="btn btn-primary mr-4">Adaugă Rezervarea fără Ofertă</button>
                                    <button type="button" class="btn btn-dark ml-4" v-on:click="(retur = !retur);oferta_5_adulti();">Retur</button>
                                </div>
                            </div>
                            <div v-else class="d-flex justify-content-center m-auto">
                                <button type="submit" class="btn btn-primary text-white mr-4">Adaugă Rezervare</button>
                                <button type="button" class="btn btn-dark ml-4" v-on:click="(retur = !retur);oferta_5_adulti();">Retur</button>
                            </div>
                        {{-- @else
                            <div class="d-flex justify-content-center m-auto">
                                <button type="submit" class="btn btn-primary mr-4">Adaugă Rezervare</button>
                                <button type="button" class="btn btn-dark ml-4" v-on:click="(retur = !retur);oferta_5_adulti();">Retur</button>
                            </div>

                        @endif --}}

                        {{-- @if (auth()->user()->isDispecer())
                            <button type="submit" class="btn btn-primary mr-4">Adaugă Rezervare</button>
                        @else
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Adaugă Rezervare
                            </button>

                            <!-- The Modal -->
                            <div class="modal" id="myModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header bg-warning">
                                    <h4 class="modal-title">Ai verificat cu atenție datele înregistrării?</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Odata adaugată înregistrarea, vei mai putea modifica doar câmpurile <b>Stație de îmbarcare</b> și <b>telefon</b>.
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary mr-4">Adaugă Rezervare</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Reverifică datele</button>
                                </div>

                                </div>
                            </div>
                            </div>
                        @endif --}}

                        {{-- <button type="button" class="btn btn-dark ml-4" v-on:click="(retur = !retur);oferta_5_adulti();">Retur</button>                            --}}
                            <input
                                type="hidden"
                                name="retur"
                                v-model="retur">
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="m-3">
        &nbsp;
    </div>


                {{-- <div class="form-row my-3 d-flex justify-content-center">
                    <div class="form-group col-lg-9 card shadow-sm px-4 mb-0">
                        <h5 class="m-0 p-0 text-center"><b>Program de sarbatori 2019 - 2020:</b></h5>
                        - 24.12.2019 si 31.12.2019 ultima cursa pe tur Galati/Tecuci este la 10:30 iar din Otopeni la ora 14:30,
                        <br>
                        - 26.12.2019 si 02.01.2020 prima cursa pe tur Galati/Tecuci este la ora 00:00 iar din Otopeni la ora 04:00,
                        <br>
                        - 25.12.2019 si 01.01.2020 nu se lucreaza.
                    </div>
                </div> --}}


    @include ('layouts.grila-ore')

    {{-- <div class="justify-content">
        <div class="row">
            <div class="col-lg-12 justify-content">
                <img src="{{ asset('images/grile-ore/Galati - Otopeni.jpg') }}" width="258px">
                <img src="{{ asset('images/grile-ore/Otopeni - Galati.jpg') }}" width="250px">
                <img src="{{ asset('images/grile-ore/Tecuci - Otopeni.jpg') }}" width="290px">
                <img src="{{ asset('images/grile-ore/Otopeni - Tecuci.jpg') }}" width="288px">
            </div>
        </div>
    </div> --}}
</div>
@endsection
