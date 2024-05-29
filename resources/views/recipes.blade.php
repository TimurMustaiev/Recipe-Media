@extends('layouts.main')

@section('tab-title', 'Усі Рецепти')
@section('page-content')
    @foreach ($recipes as $recipe)
            <div class="recipe-container">
                <div class="card-body shadow-sm recent_recipe">
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
            </div>
    @endforeach
@endsection