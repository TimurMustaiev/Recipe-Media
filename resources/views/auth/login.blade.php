@extends('layouts.simple')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@section('tab-title', 'Вхід')
@section('page-content')
    <div class="card col-4">
        <div class="card-header">{{ __('Вхід') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="row mb-5 register-link-block">
                    <span>Не маєте профілю? <a href="{{ route('register') }}" id="register-link">Зареєструватися</a></span>
                </div>

                <div class="row mb-3 d-flex justify-content-center">
                    <div class="col-md-8 email-input">
                        <input id="email" type="email" placeholder="Електронна пошта" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 d-flex justify-content-center">
                    <div class="col-md-8 password-input">
                        <input id="password" type="password" placeholder="Пароль" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __("Запам'ятати мене") }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-0 d-flex justify-content-center">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary" id="submit-button">
                            {{ __('Увійти') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
