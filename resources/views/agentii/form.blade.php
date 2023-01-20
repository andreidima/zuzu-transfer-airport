@csrf

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="col-lg-12 mb-0">

        <div class="row p-2 mb-0">
            <div class="col-lg-6 mb-4 mx-auto">
                <label for="nume" class="mb-0 ps-3">Nume*:</label>
                <input
                    type="text"
                    class="form-control rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $agentii->nume) }}"
                    required>
            </div>
            <div class="col-lg-6 mb-4 mx-auto">
                <label for="punct_lucru" class="mb-0 ps-3">Punct de lucru:</label>
                <input
                    type="text"
                    class="form-control rounded-pill {{ $errors->has('punct_lucru') ? 'is-invalid' : '' }}"
                    name="punct_lucru"
                    placeholder=""
                    value="{{ old('punct_lucru', $agentii->punct_lucru) }}">
            </div>
            <div class="col-lg-6 mb-4 mx-auto">
                <label for="cif" class="mb-0 ps-3">CIF:</label>
                <input
                    type="text"
                    class="form-control rounded-pill {{ $errors->has('cif') ? 'is-invalid' : '' }}"
                    name="cif"
                    placeholder=""
                    value="{{ old('cif', $agentii->cif) }}">
            </div>
            <div class="col-lg-6 mb-4 mx-auto">
                <label for="nr_orc" class="mb-0 ps-3">Nr ORC:</label>
                <input
                    type="text"
                    class="form-control rounded-pill {{ $errors->has('nr_orc') ? 'is-invalid' : '' }}"
                    name="nr_orc"
                    placeholder=""
                    value="{{ old('nr_orc', $agentii->nr_orc) }}">
            </div>
            <div class="col-lg-6 mb-4 mx-auto">
                <label for="persoana_contact" class="mb-0 ps-3">Persoana de contact:</label>
                <input
                    type="text"
                    class="form-control rounded-pill {{ $errors->has('persoana_contact') ? 'is-invalid' : '' }}"
                    name="persoana_contact"
                    placeholder=""
                    value="{{ old('persoana_contact', $agentii->persoana_contact) }}">
            </div>
            <div class="col-lg-6 mb-4 mx-auto">
                <label for="telefon" class="mb-0 ps-3">Telefon:</label>
                <input
                    type="text"
                    class="form-control rounded-pill {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                    name="telefon"
                    placeholder=""
                    value="{{ old('telefon', $agentii->telefon) }}">
            </div>
            <div class="col-lg-6 mb-4 mx-auto">
                <label for="email" class="mb-0 ps-3">Email:</label>
                <input
                    type="text"
                    class="form-control rounded-pill {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    name="email"
                    placeholder=""
                    value="{{ old('email', $agentii->email) }}">
            </div>
        </div>

        <div class="row p-2">
            <div class="col-lg-12 py-3 d-flex justify-content-center">
                <button type="submit" ref="submit" class="btn btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-secondary rounded-3" href="/agentii">Renunță</a>
            </div>
        </div>
    </div>
</div>
