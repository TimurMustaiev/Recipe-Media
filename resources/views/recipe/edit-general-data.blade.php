@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe/edit-general-data.css') }}">
@section('tab-title', 'Створення рецепту')
@section('page-content')
<div class="text-center">
    <h2>Редагування Рецепту "{{ $recipe->name }}"</h2>
</div>
<div class="form-container">
    <div class="card">
        <div class="card-header">Рецепт: загальна інформація</div>
        <div class="card-body">
            <form action="{{ route('recipes.update_general_data', $recipe->recipe_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <label for="recipe_name">Назва</label>
                <input type="text" id="recipe_name" name="recipe_name" class="form-control @error('recipe_name') is-invalid @enderror" placeholder="Назва" value="{{ old('recipe_name') ? old('recipe_name') : $recipe->name }}">
                @error('recipe_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label class="mt-2" for="recipe_img">Головне фото</label>
                <input type="file" id="recipe_img" name="recipe_img" class="form-control @error('recipe_img') is-invalid @enderror" accept="image/jpeg, image/png, image/jpg, image/bmp">
                @error('recipe_img')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label class="mt-2" for="cuisine">Кухня</label>
                <select name="cuisine" id="cuisine" class="form-select @error('cuisine') is-invalid @enderror">
                    @foreach ($cuisines as $cuisine)
                        <option value="{{ $cuisine->cuisine_id }}" {{ $recipe->cuisine_id == $cuisine->cuisine_id ? 'selected' : '' }}>{{ $cuisine->name }}</option>
                    @endforeach
                </select>
                @error('cuisine')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label class="mt-2" for="recipe_meal_type">Тип страви</label>
                <select id="recipe_meal_type" name="recipe_meal_type" class="form-select @error('recipe_meal_type') is-invalid @enderror">
                    @foreach(['головна страва', 'закуска', 'десерт', 'напій'] as $option)
                        <option value="{{ $option }}" {{ $recipe->meal_type == $option ? 'selected' : '' }}>{{ ucfirst($option) }}</option>
                    @endforeach
                </select>
                @error('recipe_meal_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label class="mt-2" for="recipe_description">Короткий опис (необов'язково)</label>
                <textarea rows="5" id="recipe_description" name="recipe_description" class="form-control" placeholder="Опис Рецепту">{{ old('recipe_description') ? old('recipe_description') : $recipe->description }}</textarea>
                <button id="submit-button" class="mt-4 btn btn-primary" type="submit">Оновити</button>
            </form>
        </div>
    </div>
</div>
@endsection