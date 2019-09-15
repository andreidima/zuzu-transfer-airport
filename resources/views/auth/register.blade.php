@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        {{ __('Înregistrare') }}
                    </div>
                    <div>
                        Zuzu Transfer Aeroport
                    </div>
                </div>

                @include ('errors')

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="firma_nume" class="col-md-4 col-form-label text-md-right">{{ __('Denumire firmă*:') }}</label>

                            <div class="col-md-6">
                                <input id="firma_nume" type="text" class="form-control{{ $errors->has('firma_nume') ? ' is-invalid' : '' }}" name="firma_nume" value="{{ old('firma_nume') }}" autocomplete="firma_nume" autofocus>

                                @if ($errors->has('firma_nume'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firma_nume') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firma_punct_lucru" class="col-md-4 col-form-label text-md-right">{{ __('Punct lucru*:') }}</label>

                            <div class="col-md-6">
                                <input id="firma_punct_lucru" type="text" class="form-control{{ $errors->has('firma_punct_lucru') ? ' is-invalid' : '' }}" name="firma_punct_lucru" value="{{ old('firma_punct_lucru') }}" autocomplete="firma_punct_lucru" autofocus>

                                @if ($errors->has('firma_punct_lucru'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firma_punct_lucru') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firma_cif" class="col-md-4 col-form-label text-md-right">{{ __('C.I.F.:') }}</label>

                            <div class="col-md-6">
                                <input id="firma_cif" type="text" class="form-control{{ $errors->has('firma_cif') ? ' is-invalid' : '' }}" name="firma_cif" value="{{ old('firma_cif') }}" autocomplete="firma_cif" autofocus>

                                @if ($errors->has('firma_cif'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firma_cif') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firma_nr_orc" class="col-md-4 col-form-label text-md-right">{{ __('Nr. O.R.C.:') }}</label>

                            <div class="col-md-6">
                                <input id="firma_nr_orc" type="text" class="form-control{{ $errors->has('firma_nr_orc') ? ' is-invalid' : '' }}" name="firma_nr_orc" value="{{ old('firma_nr_orc') }}" autocomplete="firma_nr_orc" autofocus>

                                @if ($errors->has('firma_nr_orc'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firma_nr_orc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nume" class="col-md-4 col-form-label text-md-right">{{ __('Persoana contact*:') }}</label>

                            <div class="col-md-6">
                                <input id="nume" type="text" class="form-control{{ $errors->has('nume') ? ' is-invalid' : '' }}" name="nume" value="{{ old('nume') }}" autocomplete="nume" autofocus>

                                @if ($errors->has('nume'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nume') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefon" class="col-md-4 col-form-label text-md-right">{{ __('Telefon*:') }}</label>

                            <div class="col-md-6">
                                <input id="telefon" type="telefon" class="form-control{{ $errors->has('telefon') ? ' is-invalid' : '' }}" name="telefon" value="{{ old('telefon') }}" autocomplete="telefon">
                                <small id="telefonAjutor" class="form-text text-muted">Telefon de contact, preferabil telefon mobil</small>
                                @if ($errors->has('telefon'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail*:') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autocomplete="email">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Nume de utilizator*:') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" autocomplete="username">

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Parola*:') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" autocomplete="new-password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirmare Parolă*:') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center mb-2">
                            <div class="form-check">
                                <div>
                                    <input type="checkbox" class="form-check-input" name="acord_de_confidentialitate" value="1" 
                                    {{ old('acord_de_confidentialitate') == '1' ? 'checked' : '' }}>
                                </div>
                                <div>
                                    <label class="form-check-label" for="acord_de_confidentialitate">Am citit și sunt de acord cu <i>Termenii și condițiile</i> de utilizare</label>
                                </div>
                                <div>
                                    @if ($errors->has('acord_de_confidentialitate'))
                                        <span class="text-danger" role="alert">
                                            <small>
                                                <strong>{{ $errors->first('acord_de_confidentialitate') }}</strong>
                                            </small>
                                        </span>
                                    @endif
                                </div>

                            </div>
                            
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Înregistrare') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
