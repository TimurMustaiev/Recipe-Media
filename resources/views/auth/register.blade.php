@extends('layouts.simple')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@section('tab-title', 'Реєстрація')
@section('page-content')
    <div class="card col-5">
        <div class="card-header">{{ __('Реєстрація') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row mb-3 d-flex justify-content-center">
                    <div class="col-md-6">
                        <input id="name" placeholder="Ім'я користувача" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 d-flex justify-content-center">
                    <div class="col-md-6">
                        <input id="email" placeholder="Електронна Пошта" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 d-flex justify-content-center">
                    <div class="col-md-6">
                        <input id="password" placeholder="Пароль" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 d-flex justify-content-center">
                    <div class="col-md-6">
                        <input id="password-confirm" placeholder="Підтвердіть пароль" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-0 d-flex justify-content-center">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary" id="submit-button">
                            {{ __('Зареєструватися') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
