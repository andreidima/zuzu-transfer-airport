@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="row mb-2">
            <div class="form-group col-lg-12 mb-2">
                <label for="nume" class="mb-0 pl-3">Nume șofer*:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $sofer->nume) }}"
                    required>
            </div>
            <div class="form-group col-lg-4 text-center mb-2">
                <label for="fisa_medicala" class="mb-0 mr-2">Fișa medicală:</label>
                    <vue2-datepicker
                        data-veche="{{ old('fisa_medicala', ($sofer->fisa_medicala ?? '')) }}"
                        nume-camp-db="fisa_medicala"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center mb-2">
                <label for="examen_psihologic" class="mb-0 mr-2">Examen psihologic:</label>
                    <vue2-datepicker
                        data-veche="{{ old('examen_psihologic', ($sofer->examen_psihologic ?? '')) }}"
                        nume-camp-db="examen_psihologic"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center mb-2">
                <label for="medicina_muncii" class="mb-0 mr-2">Medicina muncii:</label>
                    <vue2-datepicker
                        data-veche="{{ old('medicina_muncii', ($sofer->medicina_muncii ?? '')) }}"
                        nume-camp-db="medicina_muncii"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center mb-2">
                <label for="permis" class="mb-0 mr-2">Permis:</label>
                    <vue2-datepicker
                        data-veche="{{ old('permis', ($sofer->permis ?? '')) }}"
                        nume-camp-db="permis"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center mb-2">
                <label for="atestat" class="mb-0 mr-2">Atestat:</label>
                    <vue2-datepicker
                        data-veche="{{ old('atestat', ($sofer->atestat ?? '')) }}"
                        nume-camp-db="atestat"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
            <div class="form-group col-lg-4 text-center mb-2">
                <label for="card" class="mb-0 mr-2">Card:</label>
                    <vue2-datepicker
                        data-veche="{{ old('card', ($sofer->card ?? '')) }}"
                        nume-camp-db="card"
                        :latime="{ width: '125px' }"
                        tip="date"
                        value-type="YYYY-MM-DD"
                        format="DD-MM-YYYY"
                    ></vue2-datepicker>
            </div>
        </div>
        <div class="row mb-2">
            <div class="form-group col-lg-12 mb-2">
                <label for="observatii" class="mb-0 pl-3">Observații:</label>
                <textarea class="form-control {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii"
                    rows="2"
                >{{ old('observatii', ($sofer->observatii ?? '')) }}</textarea>
            </div>
        </div>

        <div class="row py-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary text-white btn-sm mx-2 rounded-pill">{{ $buttonText }}</button>
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $sofer->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/soferi">Renunță</a>
            </div>
        </div>
    </div>
</div>
