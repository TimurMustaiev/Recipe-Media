@extends('layout')
<link rel="stylesheet" href="{{ asset('css/recipe-groups-create.css') }}">
@section('tab-title', 'Створення Групи Рецептів')
@section('page-content')
<div class="container-fluid vw-100 vh-100 row align-items-center d-flex flex-column">
    <div class="text-center col-4">
        <h2>Створіть власну нову Групу Рецептів</h2>
    </div>
    <div class="form-container row-5 col-4">
        <form action="{{ route('recipe_groups.store', Auth::user()->user_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="name">Введіть назву Групи Рецептів</label>
            <input type="text" id="name" name="name" placeholder="Назва">
            <label for="img">Оберіть обкладинку Групи Рецептів</label>
            <input type="file" id="img" name="img" accept="image/jpeg, image/png, image/jpg, image/bmp">
            <label for="description">Введіть короткий опис Групи Рецептів (необов'язково)</label>
            <br>
            <textarea id="description" name="description" placeholder="Опис Групи"></textarea>
            <br>
            <label>Оберіть видимість Вашої Групи Рецептів</label>
            <br>
            <input type="radio" id="public_access_modificator" name="access_modificator" value="публічна">
            <label for="public_access_modificator">публічна (бачитимуть всі)</label>
            <br>
            <input type="radio" id="private_access_modificator" name="access_modificator" value="публічна">
            <label for="private_access_modificator">приватна (бачитимете лише Ви)</label>
            <br>
            <button type="submit">Створити</button>
        </form>
    </div>
</div>
@endsection