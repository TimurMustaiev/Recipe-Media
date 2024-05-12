@extends('simple-layout')

@section('tab-title', 'Реєстрація')

@section('page-content')
<div class="container-fluid vw-100 vh-100 row align-items-center d-flex flex-column">
  <div class="text-center col-4">
    <h2>Вітаємо! Введіть дані для створення профілю</h2>
  </div>
  <div class="form-container row-5 col-4">
    <form action="">
      <div class="form-group mb-3">
        <label for="email" class="form-label">Поштова скринька</label>
        <input name="email" type="email" class="form-control" placeholder="Поштова скринька">
      </div>
      <div class="form-group mb-3">
        <label for="username" class="form-label">Ім'я користувача</label>
        <input name="username" type="text" class="form-control" placeholder="Ім'я користувача">
        <!-- Може додати підказку -->
      </div>
      <div class="form-group mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input name="password" type="password" class="form-control" placeholder="Пароль">
      </div>
      <button class="btn border" type="submit">Увійти</button>
      <div class="form-group">
        <button>Google</button> <!-- Картинки -->
        <button>Facebook</button>
      </div>
    </form>
  </div>
</div>
@endsection