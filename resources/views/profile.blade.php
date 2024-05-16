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
        <div class="recipe-list">
            @foreach ($recipes as $recipe)
            <div class="recipe-container">
                <div class="card-body shadow-sm recipe">
                    <h3>{{ $recipe->name }}</h3>
                    <img src="{{ asset($recipe->img_path) }}" alt="Картинка рецепту">
                    <br>
                    <p class="left-align">{{ Illuminate\Support\Str::limit($recipe->description, $limit = 60, $end = '...') }}</p>
                    <!--спробувати різні значення довжини тексту-->
                    <button class="btn-btn recipe-view">Переглянути</button>
                </div>
            </div>
            @endforeach
        </div>
        <a href="{{ route('recipes.show_user', $user_id) }}">Переглянути всі Рецепти</a>
    </div>

    <div class="recipe-group-block">
        <h3>Групи Рецептів</h3>
        <div class="recipe-group-list">
            @if (count($recipe_groups) == 0)
                @if (Auth::user()->user_id == $user_id)
                    У вас ще немає груп Рецептів
                    <a href="">Створити нову Групу</a> 
                @else
                    Цей користувач не має Груп Рецептів, які ви можете переглянути
                @endif
            @else
                @foreach ($recipe_groups as $recipe_group)
                <div class="recipe-group-container">
                    <div class="card-body shadow-sm recipe-group">
                        <h4>{{ $recipe_group->name }}</h4>
                        <img src="{{ asset($recipe_group->img_path) }}" alt="Картинка групи">
                        <br>
                        @if (isset($recipe_group->description))
                            <p class="left-align">{{ Illuminate\Support\Str::limit($recipe_group->description, $limit = 120, $end = '...') }}</p>
                        @else
                            <p>Без опису</p>
                            <br>
                        @endif
                        <!--спробувати різні значення довжини тексту-->
                        <button class="btn-btn recipe-view">Переглянути</button>
                    </div>
                </div>
                @endforeach
                <a href="{{ route('users.show_recipe_groups', $user_id) }}">Переглянути всі Групи Рецептів</a>
            @endif
        </div>
    </div>
</div>
@endsection