@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        {{ __('Login') }}
                    </div>
                    <div>
                        Zuzu Transfer Aeroport
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Email / Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="current-password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <img class="my-3 py-3" src="{{ asset('images/logo-zuzu.png') }}" style="width:300px; padding:0rem; margin:0rem;">
        </div>
    </div>

        {{-- <div class="row justify-content-center">
            <span class="badge badge-info">Suport Tehnic:</span> Elena Lemnaru +40 765 296 796
            <b>Suport Tehnic</b>: Elena Lemnaru +40 765 296 796
        </div> --}}

    <div class="row justify-content-center">
        <div class="col-md-4">    
            <div class="card text-white bg-info mx-0  mb-4 p-0" style="max-width: 19rem;">
                <div class="card-header my-0 py-0">
                    <h5 class="my-0 py-0 text-center">Suport Tehnic</h5>
                </div>
                <div class="card-body my-0 py-0 text-center">
                    Elena Lemnaru: +40 765 296 796
                </div>
            </div>
        </div>    
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4 text-center"> 
            <div style="max-width: 19rem;">
                <a href="{{ route('register') }}">
                    Înregistrare Agenție de Turism
                </a> 
            </div>              
        </div>    
    </div>

</div>
@endsection
