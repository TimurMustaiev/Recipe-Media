@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe/create_step_one.css') }}">
@section('tab-title', 'Створення рецепту')
@section('page-content')
<div class="container-fluid vw-100 vh-100 row align-items-center d-flex flex-column">
    <div class="text-center col-4">
        <h2>Редагування Рецепту "{{ $recipe->name }}"</h2>
        <p>Загальні дані</p>
    </div>
    <div class="form-container row-5 col-4">
        <form action="{{ route('recipes.update_general_data', $recipe->recipe_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <label for="recipe_name">Введіть назву Рецепту</label>
            <input type="text" id="recipe_name" name="recipe_name" class="form-control @error('recipe_name') is-invalid @enderror" placeholder="Назва" value="{{ old('recipe_name') ? old('recipe_name') : $recipe->name }}">
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
                    <option value="{{ $cuisine->cuisine_id }}" {{ $recipe->cuisine_id == $cuisine->cuisine_id ? 'selected' : '' }}>{{ $cuisine->name }}</option>
                @endforeach
            </select>
            @error('cuisine')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="recipe_meal_type">Оберіть тип страви</label>
            <select id="recipe_meal_type" name="recipe_meal_type" class="form-select @error('recipe_meal_type') is-invalid @enderror">
                @foreach(['головна страва', 'закуска', 'десерт', 'напій'] as $option)
                    <option value="{{ $option }}" {{ $recipe->meal_type == $option ? 'selected' : '' }}>{{ ucfirst($option) }}</option>
                @endforeach
            </select>
            @error('recipe_meal_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="recipe_description">Введіть короткий опис Рецепту (необов'язково)</label>
            <textarea id="recipe_description" name="recipe_description" class="form-control" placeholder="Опис Рецепту">{{ old('recipe_description') ? old('recipe_description') : $recipe->description }}</textarea>
            <button class="btn btn-primary" type="submit">Оновити</button>
        </form>
    </div>
</div>
@endsection