@extends('simple-layout')
<link rel="stylesheet" href="{{asset('css/auth-login.css')}}">
@section('tab-title', 'Вхід')

@section('page-content')
<div class="container-fluid vw-100 vh-100 row align-items-center d-flex flex-column">
  <div class="text-center col-4">
    <h2>Вітаємо! Увійдіть до свого профілю</h2>
  </div>
  <div class="form-container row-5 col-4">
    <form method="POST" action="{{route('users.log_in')}}">
      @csrf
      <div class="form-group mb-3">
        <label for="email" class="form-label">Поштова скринька</label>
        <input name="email" type="email" class="form-control" placeholder="Поштова скринька">
      </div>
      <div class="form-group mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input name="password" type="password" class="form-control" placeholder="Пароль">
      </div>
      <div class="action">
        <button class="btn border" type="submit">Увійти</button>
        <span>Не маєте профілю? -> <a href="{{route('users.create')}}">Зареєструватися</a></span>
      </div>
    </form>
  </div>
</div>
@endsection