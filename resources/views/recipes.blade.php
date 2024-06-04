@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipes.css') }}">
@section('tab-title', 'Усі Рецепти')
@section('page-content')
    <div class="recipes-container">
        @foreach ($recipes as $recipe)
                <div class="recipe">
                    <h3>{{ $recipe->name }}</h3>
                    <img src="{{ asset($recipe->img_path) }}" alt="Картинка рецепту">
                    <br>
                    <p class="left-align">{{ Illuminate\Support\Str::limit($recipe->description, $limit = 120, $end = '...') }}</p>
                    <!--спробувати різні значення довжини тексту-->
                    <a class="btn btn" href="{{ route('recipes.show', $recipe->recipe_id) }}">
                        Переглянути
                    </a>
                    @auth
                        <a class="btn btn" href="">Додати у Колекцію</a>
                    @endauth
                </div>
        @endforeach
    </div>
@endsection