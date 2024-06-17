@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe/create_step_one.css') }}">
@section('tab-title', 'Створення рецепту: етап 1')
@section('page-content')
<div class="text-center mb-2">
    <h2>Створіть новий вегетаріанський Рецепт</h2>
</div>
<div class="form-container">
    <div class="card col-5">
        <div class="card-header">Етап 1: Загальна інформація</div>
        <div class="card-body">
            <form action="{{ route('recipes.store_step_one', Auth::user()->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="recipe_name">Назва Рецепту</label>
                <input type="text" id="recipe_name" name="recipe_name" class="form-control @error('recipe_name') is-invalid @enderror" placeholder="Назва" value="{{ old('recipe_name') }}">
                @error('recipe_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label for="recipe_img">Головне фото</label>
                <input type="file" id="recipe_img" name="recipe_img" class="mt-2 form-control @error('recipe_img') is-invalid @enderror" accept="image/jpeg, image/png, image/jpg, image/bmp">
                @error('recipe_img')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label for="cuisine">Кухня</label>
                <select name="cuisine" id="cuisine" class="mt-2 form-select @error('cuisine') is-invalid @enderror">
                    @foreach ($cuisines as $cuisine)
                        <option value="{{ $cuisine->cuisine_id }}">{{ $cuisine->name }}</option>
                    @endforeach
                </select>
                @error('cuisine')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label for="recipe_meal_type">Тип страви</label>
                <select id="recipe_meal_type" name="recipe_meal_type" class="mt-2 form-select @error('recipe_meal_type') is-invalid @enderror">
                    <option value="головна страва">Головна Страва</option>
                    <option value="закуска">Закуска</option>
                    <option value="салат">Салат</option>
                    <option value="десерт">Десерт</option>
                    <option value="напій">Напій</option>
                </select>
                @error('recipe_meal_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label for="recipe_description">Короткий опис (необов'язково)</label>
                <textarea rows="5" id="recipe_description" name="recipe_description" class="form-control" placeholder="Опис Рецепту">{{ old('recipe_description') }}</textarea>
                <button id="submit-button" class="mt-4 btn btn-primary" type="submit">Далі</button>
            </form>
        </div>
    </div>
</div>
@endsection