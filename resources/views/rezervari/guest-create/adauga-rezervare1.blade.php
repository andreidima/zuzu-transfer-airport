@extends('layouts.app')

@section('content')
<div class="container p-0">
<div class="row justify-content-center">
    <div class="col-lg-6 p-0 mb-4 " id="orase-ore-plecare">
    <div class="shadow-lg bg-white" style="border-radius: 40px 40px 40px 40px;">
        <div class="p-2 d-flex justify-content-between align-items-end"
            style="border-radius: 40px 40px 0px 0px; border:2px solid #2C7996">
            <div class="flex flex-vertical-center">
                <h3 class="mt-2" style="color:#2C7996">
                    {{-- <a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a> - Adaugă o rezervare nouă --}}
                    <i class="fas fa-ticket-alt fa-lg mx-1"></i>Rezervare bilet călătorie</h3>
                </h3>
            </div>
            <div>
                {{-- <a class="btn btn-secondary" href="/rezervari" role="button">Renunță</a> --}}
                {{-- <h3 class="mt-2">
                    Zuzu Transfer Airport
                </h3> --}}
                <img src="{{ asset('images/logo_alb.jpg') }}" height="70" class="mx-3 border border-light border-2">
            </div>
        </div>

        @include ('errors')

        <div class="card-body px-4 py-3 m-0 pb-4 border border-dark"
            style="background-color:#EF9A3E;"
        >
            <form  class="needs-validation" novalidate method="POST" action="/adauga-rezervare-pasul-1" style="font-size:1rem">
                @csrf

                {{-- <div class="form-row mb-2 d-flex justify-content-center">
                    <div class="form-group col-lg-8 card bg-danger text-white shadow-sm px-2 mb-0">
                        <h5 class="m-0 p-0">Program de sarbatori 2019 - 2020:</h5>
                        - 24.12.2019 si 31.12.2019 ultima cursa pe tur Galati/Tecuci este la 10:30 iar din Otopeni la ora 14:30,
                        <br>
                        - 26.12.2019 si 02.01.2020 prima cursa pe tur Galati/Tecuci este la ora 00:00 iar din Otopeni la ora 04:00,
                        <br>
                        - 25.12.2019 si 01.01.2020 nu se lucreaza.
                    </div>
                </div> --}}
                {{-- <div class="form-row mb-2 d-flex justify-content-center">
                    <div class="form-group col-lg-11 card bg-danger text-white shadow-sm p-0 mb-1 text-center">
                        <h5 class="m-0 p-0">Preturile au fost modificate de la 1 Aprilie 2020 pe perioada starii de urgenta! Multumim pentru intelegere!</h5>
                    </div>
                    <div class="form-group col-lg-7 card bg-danger text-white shadow-sm p-0 mb-0 text-center">
                        <h5 class="m-0 p-0">Program de Paște 2020: program normal, se efectuează toate cursele!</h5>
                    </div>
                </div> --}}

                <div class="row mb-3 justify-content-center text-white border border-white"
                >
                    <div class="col-lg-12 shadow-sm p-3"
                        style="background-color:#2C7996;"
                    >
                        <div class="row justify-content-between">
                            <div class="col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                    <h4 class="mb-2">Detalii călătorie:</h4>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <script type="application/javascript">
                                    orasPlecareVechi={!! json_encode(old('oras_plecare', "0")) !!}
                                    statieImbarcareVeche = 0
                                    nrAdultiVechi = 0
                                    nrCopiiVechi = 0
                                    returOraPlecareVeche = 0
                                    pretTotal = 0
                                </script>
                                <label for="oras_plecare" class="form-label mb-0">Plecare din:<span class="text-light">*</span></label>
                                    <select class="form-select {{ $errors->has('oras_plecare') ? 'is-invalid' : '' }}"
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
                            <div class="col-lg-6 mb-3">
                                <script type="application/javascript">
                                    orasSosireVechi={!! json_encode(old('oras_sosire', "0")) !!}
                                </script>
                                <label for="oras_sosire" class="form-label mb-0">Sosire la:<span class="text-light">*</span></label>
                                    <select class="form-select {{ $errors->has('oras_sosire') ? 'is-invalid' : '' }}"
                                        name="oras_sosire"
                                        v-model="oras_sosire"
                                    @change='getOrePlecare();getReturOrePlecare();'>
                                            <option v-for='oras_sosire in orase_sosire'
                                            :value='oras_sosire.id'
                                            >@{{oras_sosire.nume}}</option>
                                    </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="data_cursa" class="form-label mb-0">Data plecării:<span class="text-light">*</span></label>
                                <vue2-datepicker
                                    data-veche="{{ old('data_cursa') == '' ? '' : old('data_cursa') }}"
                                    nume-camp-db="data_cursa"
                                    tip="date"
                                    latime="150"
                                    not-before="{{ \Carbon\Carbon::today() }}"
                                ></vue2-datepicker>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <script type="application/javascript">
                                    statieImbarcareVeche={!! json_encode(old('statie_id', "0")) !!}
                                </script>
                                <label for="statie_id" class="form-label mb-0">Stația de îmbarcare:</label>
                                    <select class="form-select {{ $errors->has('statie_id') ? 'is-invalid' : '' }}"
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

                        <div class="row justify-content-between">
                            <div class="col-lg-6 mb-3">
                                <script type="application/javascript">
                                    oraPlecareVeche={!! json_encode(old('ora_id', "0")) !!}
                                </script>
                                <label for="ora_id" class="form-label mb-0">Ora de plecare:<span class="text-light">*</span></label>
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
                            <div class="col-lg-6 mb-3">
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

                <div class="row mb-3 justify-content-center text-white border border-white"
                >
                    <div class="col-lg-12 shadow-sm p-3"
                        style="background-color:#2C7996;"
                    >
                        <div class="row justify-content-between">
                            <div class="col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                    <h4 class="mb-2">Detalii despre călătoria cu avionul:</h4>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="zbor_oras_decolare" class="form-label mb-0">Oraș decolare avion:</label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('zbor_oras_decolare') ? 'is-invalid' : '' }}"
                                    name="zbor_oras_decolare"
                                    placeholder=""
                                    value="{{ old('zbor_oras_decolare') }}"
                                    style="text-transform:uppercase"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="zbor_ora_decolare" class="form-label mb-0">Oră decolare:</label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('zbor_ora_decolare') ? 'is-invalid' : '' }}"
                                    name="zbor_ora_decolare"
                                    placeholder="00:00"
                                    value="{{ old('zbor_ora_decolare') }}"
                                    required>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label for="zbor_ora_aterizare" class="form-label mb-0">Ora aterizare:</label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('zbor_ora_aterizare') ? 'is-invalid' : '' }}"
                                    name="zbor_ora_aterizare"
                                    placeholder="00:00"
                                    value="{{ old('zbor_ora_aterizare') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-lg-12 px-2 border-start border-warning border-5"
                            {{-- style="border-width:5px !important" --}}
                        >

                            <small>
                                *Aceste informații ne ajută să vă transportăm în timp util și cât mai eficient pentru dumneavoastră.
                            </small>
                        </div>
                    </div>
                </div>


                <div class="row mb-3 justify-content-center text-white border border-white"
                >
                    <div class="col-lg-12 shadow-sm p-3"
                        style="background-color:#006366;"
                    >
                        <div class="row justify-content-between">
                            <div class="col-lg-12 mb-2 d-flex justify-content-center border-bottom">
                                    <h4 class="mb-2">Prețuri bilete:</h4>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-lg-6 mb-0 d-flex">
                                    <label for="pret_adult" class="col-form-label">Preț adult:</label>
                                    <div class="mx-1" style="width:60px">
                                        <input
                                            type="text"
                                            class="form-control {{ $errors->has('pret_adult') ? 'is-invalid' : '' }}"
                                            name="pret_adult"
                                            v-model="pret_adult"
                                            value="{{ old('pret_adult') }}"
                                            required
                                            disabled>
                                    </div>
                                    <label for="pret_adult" class="col-form-label">lei</label>
                            </div>
                            <div class="col-lg-6 mb-0 d-flex">
                                <label for="pret_copil" class="col-form-label">Preț copil <small>(2-7 ani)</small>:</label>
                                <div class="mx-1" style="width:60px">
                                    <input
                                        type="text"
                                        class="form-control {{ $errors->has('pret_copil') ? 'is-invalid' : '' }}"
                                        name="pret_copil"
                                        v-model="pret_copil"
                                        value="{{ old('pret_copil') }}"
                                        required
                                        disabled>
                                </div>
                                <label id="pret_copil" class="col-form-label">
                                    lei
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 justify-content-center text-white border border-white"
                >
                    <div class="col-lg-12 shadow-sm p-3"
                        style="background-color:#006366;"
                    >
                        <div class="row mb-3">
                            <label for="nume" class="col-lg-3 col-form-label pb-0">Nume client:<span class="text-light">*</span></label>
                            <div class="col-lg-9">
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                                    name="nume"
                                    placeholder="Nume Client"
                                    value="{{ old('nume') }}"
                                    style="text-transform:uppercase"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="telefon" class="col-lg-3 col-form-label pb-0">Telefon:<span class="text-light">*</span></label>
                            <div class="col-lg-9">
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                                    name="telefon"
                                    placeholder="Telefon"
                                    value="{{ old('telefon') }}"
                                    required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-lg-3 col-form-label pb-0">E-mail:</label>
                            <div class="col-lg-9">
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    name="email"
                                    placeholder="E-mail"
                                    value="{{ old('email') }}"
                                    >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 py-2 border-top border-bottom">
                                <script type="application/javascript">
                                    nrAdultiVechi={!! json_encode(old('nr_adulti', " ")) !!}
                                    nrCopiiVechi={!! json_encode(old('nr_copii', " ")) !!}
                                </script>
                                <div class="row">
                                    <label for="nr_adulti" class="col-lg-4 col-form-label">Număr de locuri:</label>
                                    <div class="col-lg-8 d-flex">
                                        <label for="nr_adulti" class="col-form-label">Adulți:<span class="text-light">*</span></label>
                                        <div class="" style="margin-right:20px">
                                            <select class="form-select {{ $errors->has('nr_adulti') ? 'is-invalid' : '' }}"
                                                name="nr_adulti"
                                                v-model="nr_adulti"
                                            @change='getPretTotal()'>
                                                @for ($i = 1; $i < 16; $i++)
                                                    <option>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <label for="nr_copii" class="col-form-label">Copii <small>(2-7 ani)</small>:</label>
                                        <div class="px-1" style="width:80px">
                                            <select class="form-select {{ $errors->has('nr_copii') ? 'is-invalid' : '' }}"
                                                name="nr_copii"
                                                v-model="nr_copii"
                                            @change='getPretTotal()'>
                                                @for ($i = 1; $i < 11; $i++)
                                                    <option>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 py-2 border-bottom d-flex">
                                <script type="application/javascript">
                                    pretTotal={!! json_encode(old('pret_total', 0)) !!}
                                </script>
                                    <label for="pret_total" class="col-form-label" style="margin-right:10px">Preț total:</label>
                                    <div class="" style="width:100px">
                                        <input
                                            type="text"
                                            class="form-control {{ $errors->has('pret_total') ? 'is-invalid' : '' }}"
                                            name="pret_total"
                                            v-model="pret_total"
                                            placeholder="0"
                                            value="{{ old('pret_total') }}"
                                            required
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 py-1 border-bottom ">
                                <div class="row">
                                    <div class="col-lg-4 d-flex align-items-center">
                                        <script type="application/javascript">
                                            plataOnlineVeche={!! json_encode(old('plata_online') == "true" ? true : false) !!}
                                        </script>
                                        <label for="" class="form-check-label">Plata cu card:</label>
                                        <input type="hidden" name="plata_online" value="0" />
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input px-2" name="plata_online" value="1" required
                                            {{ old('plata_online') == '1' ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <img src="{{ asset('images/netopia_banner_blue.jpg') }}" class="border border-white" width="350px">
                                    </div>
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

                            <div class="col-lg-12 my-2 px-2 border-start border-5 border-warning">
                                <label for="" class="form-check-label small">Acord de confidențialitate:</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="acord_de_confidentialitate" value="1" required
                                    {{ old('acord_de_confidentialitate') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="acord_de_confidentialitate" style="font-size: 0.7rem">
                                            *Sunt de acord cu colectarea și prelucrarea datelor cu caracter personal
                                            <a href="/termeni-si-conditii#politica-de-confidentialitate" target="_blank">
                                                <span class="badge badge-primary border border-dark"
                                                    style="background-color:yellow; color:black"
                                                >
                                                    nota de informare
                                                </span>
                                            </a>
                                        </label>
                                </div>
                            </div>

                            <div class="col-lg-12 my-2 px-2 border-start border-5 border-warning">
                                <label for="" class="form-check-label small">Termeni și condiții:</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="termeni_si_conditii" value="1" required
                                    {{ old('termeni_si_conditii') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="termeni_si_conditii" style="font-size: 0.7rem">
                                            *Sunt de acord cu condițiile generale de transport persoane -
                                            <a href="/termeni-si-conditii" target="_blank">
                                                <span class="badge badge-primary border border-dark"
                                                    style="background-color:red; color:white"
                                                >
                                                    Termeni și condiții
                                                </span>
                                            </a>
                                        </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-0">
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="submit" class="btn btn-lg btn-primary text-white border border-4 border-light">
                                <h4 class="mb-0">
                                    Verifică Rezervarea
                                </h4>
                            </button>
                        </div>
                    </div>
                </div>

            </form>


        </div>
    </div>

    {{-- @include ('layouts.grila-ore') --}}
    </div>
</div>
</div>
@endsection
