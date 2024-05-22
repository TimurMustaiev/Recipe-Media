@extends('layout')
<link rel="stylesheet" href="{{ asset('css/recipe/create_step_one.css') }}">
@section('tab-title', 'Створення рецепту')
@section('page-content')
<div class="container-fluid vw-100 vh-100 row align-items-center d-flex flex-column">
    <div class="text-center col-4">
        <h2>Створіть новий вегетаріанський шедевр!</h2>
        <p>Крок 1</p>
    </div>
    <div class="form-container row-5 col-4">
        <form action="{{ route('recipes.store_step_one') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="recipe_name">Введіть назву Рецепту</label>
            <input type="text" id="recipe_name" name="recipe_name" placeholder="Назва">
            <label for="recipe_img">Оберіть головне фото Рецепту</label>
            <input type="file" id="recipe_img" name="recipe_img" accept="image/jpeg, image/png, image/jpg, image/bmp">
            <label for="cuisine">Оберіть тип кухні Рецепту</label>
            <select name="cuisine" id="cuisine">
                @foreach ($cuisines as $cuisine)
                    <option value="{{ $cuisine->cuisine_id }}">{{ $cuisine->name }}</option>
                @endforeach
            </select>
            <label for="recipe_description">Введіть короткий опис Рецепту (необов'язково)</label>
            <input type="text" id="recipe_description" name="recipe_description" placeholder="Опис Рецепту">
            <button type="submit">Далі</button>
        </form>
    </div>
</div>
@endsection