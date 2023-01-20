@csrf

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="col-lg-12 mb-0">

        <div class="row p-2 mb-0">
            <div class="col-lg-7 mb-4 mx-auto">
                <input type="hidden" name="firma_id" value="{{ $agentie->id }}">
                <label for="nume" class="mb-0 ps-3">Agentie:</label>
                <input
                    type="text"
                    class="form-control rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ $agentie->nume }}"
                    disabled>
            </div>
        </div>
        <div class="row p-2 mb-0">
            <div class="col-lg-7 mb-4 mx-auto">
                {{-- <input type="hidden" name="user_id" value="{{ $user->id }}"> --}}
                <label for="username" class="mb-0 ps-3">Utilizator*:</label>
                <input
                    type="text"
                    class="form-control rounded-pill {{ $errors->has('username') ? 'is-invalid' : '' }}"
                    name="username"
                    placeholder=""
                    value="{{ old('username', $user->username) }}"
                    required>
            </div>
        </div>
        <div class="row p-2 mb-0">
            <div class="col-lg-7 mb-4 mx-auto">
                <label for="password" class="mb-0 ps-3">Parola ({{ $textSuplimentarParola ?? '*' }}):</label>
                <input
                    type="password"
                    class="form-control rounded-pill {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    name="password"
                    placeholder=""
                    value="{{ old('password') }}"
                    required>
                {{-- <small class="ps-3" style="font-size: 70%">{{ $textSuplimentarParola ?? '' }}</small> --}}
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
