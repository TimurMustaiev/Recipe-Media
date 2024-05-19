@php
    $layout_name = 'simple-layout';
@endphp
@if (Auth::user()->user_id != $user_id)
    @php
        $layout_name = 'layout';
    @endphp
@endif
@extends($layout_name)
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@section('tab-title', 'Профіль користувача: ' . $user->nickname)
@section('page-content')
<div class="user-block">
    <img src="{{ asset($user->img_path) }}" alt="Фото користувача">
    <h2>{{ $user->nickname }}</h2>
    <!-- if той же юзер -->
    <a href="">Переглянути дані</a>
    <!-- endif -->
</div>

<div class="user-content-block">
    <div class="recipe-block">
        <h3>Опубліковані Рецепти</h3>
        @if (count($recipes) == 0)
            @if (Auth::user()->user_id == $user_id)
                У вас ще немає опублікованих Рецептів
                <a href="{{ route('recipes.create_step_one', Auth::user()->user_id) }}">Створити новий Рецепт</a> 
            @else
                Цей користувач не має опублікованих Рецептів
            @endif
        @else
            <div class="recipe-list">
                @foreach ($recipes as $recipe)
                <div class="recipe-container">
                    <div class="card-body shadow-sm recipe">
                        <h3>{{ $recipe->name }}</h3>
                        <img src="{{ asset($recipe->img_path) }}" alt="Картинка рецепту">
                        <br>
                        <p class="left-align">{{ Illuminate\Support\Str::limit($recipe->description, $limit = 60, $end = '...') }}</p>
                        <!--спробувати різні значення довжини тексту-->
                        <a class="btn" href="{{ route('recipes.show', $recipe->recipe_id) }}">Переглянути</a>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('recipes.show_user', $user_id) }}">Переглянути всі Рецепти</a>
        @endif
    </div>

    <div class="recipe-collection-block">
        <h3>Збірки Рецептів</h3>
        <div class="recipe-collection-list">
            @if (count($recipe_collections) == 0)
                @if (Auth::user()->user_id == $user_id)
                    У вас ще немає збірок Рецептів
                    <a href="{{ route('recipe_collections.create', Auth::user()->user_id) }}">Створити нову Збірку</a> 
                @else
                    Цей користувач не має Збірок Рецептів, які ви можете переглянути
                @endif
            @else
                @foreach ($recipe_collections as $recipe_collection)
                <div class="recipe-collection-container">
                    <div class="card-body shadow-sm recipe-collection">
                        <h4>{{ $recipe_collection->name }}</h4>
                        <img src="{{ asset($recipe_collection->img_path) }}" alt="Картинка збірки">
                        <br>
                        @if (isset($recipe_collection->description))
                            <p class="left-align">{{ Illuminate\Support\Str::limit($recipe_collection->description, $limit = 120, $end = '...') }}</p>
                        @else
                            <p>Без опису</p>
                            <br>
                        @endif
                        <!--спробувати різні значення довжини тексту-->
                        <a href="{{ route('recipe_collections.show_recipes', [Auth::user()->user_id, $recipe_collection->recipe_collection_id]) }}">Переглянути</a>
                    </div>
                </div>
                @endforeach
                <a href="{{ route('users.show_recipe_collections', $user_id) }}">Переглянути всі Збірки Рецептів</a>
            @endif
        </div>
    </div>
</div>
@endsection