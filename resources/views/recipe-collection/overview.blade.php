@extends('layout')

@section('tab-title', 'Усі Рецепти Колекції "{{ $recipe_collection->name }}"')
@section('page-content')
    <h2>{{ $recipe_collection->name }}</h2>
    @foreach ($recipe_collection->recipes as $recipe)
            <div class="recipe-container">
                <div class="card-body shadow-sm recent_recipe">
                    <h3>{{ $recipe->name }}</h3>
                    <img src="{{ asset($recipe->img_path) }}" alt="Картинка рецепту">
                    <br>
                    <p class="left-align">{{ Illuminate\Support\Str::limit($recipe->description, $limit = 120, $end = '...') }}</p>
                    <!--спробувати різні значення довжини тексту-->
                    <a class="btn" href="{{ route('recipes.show', $recipe->recipe_id) }}">Переглянути</a>
                    @if (Auth::user()->user_id == $user_id)
                        <a class="btn" href="">Видалити з Колекції</a>
                    @endif
                </div>
            </div>
    @endforeach
    @if (Auth::user()->user_id == $user_id)
        <a class="btn" href="">Додати Рецепт</a>
    @endif
@endsection