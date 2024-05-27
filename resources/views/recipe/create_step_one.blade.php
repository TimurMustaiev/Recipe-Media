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
            <input type="text" id="recipe_name" name="recipe_name" class="form-control @error('recipe_name') is-invalid @enderror" placeholder="Назва" value="{{ old('recipe_name') }}">
            @error('recipe_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="recipe_img">Оберіть головне фото Рецепту</label>
            <input type="file" id="recipe_img" name="recipe_img" class="form-control @error('recipe_img') is-invalid @enderror" accept="image/jpeg, image/png, image/jpg, image/bmp">
            @error('recipe_img')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="cuisine">Оберіть тип кухні Рецепту</label>
            <select name="cuisine" id="cuisine" class="form-select @error('cuisine') is-invalid @enderror">
                @foreach ($cuisines as $cuisine)
                    <option value="{{ $cuisine->cuisine_id }}">{{ $cuisine->name }}</option>
                @endforeach
            </select>
            @error('cuisine')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="recipe_meal_type">Оберіть тип страви</label>
            <select id="recipe_meal_type" name="recipe_meal_type" class="form-select @error('recipe_meal_type') is-invalid @enderror">
                <option value="головна страва">Головна Страва</option>
                <option value="закуска">Закуска</option>
                <option value="десерт">Десерт</option>
                <option value="напій">Напій</option>
            </select>
            @error('recipe_meal_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="recipe_description">Введіть короткий опис Рецепту (необов'язково)</label>
            <textarea id="recipe_description" name="recipe_description" class="form-control" placeholder="Опис Рецепту">{{ old('recipe_description') }}</textarea>
            <button class="btn btn-primary" type="submit">Далі</button>
        </form>
    </div>
</div>
@endsection