@php
    $layout_name = 'layouts.simple';
@endphp
@if (Auth::user()->user_id != $user_id)
    @php
        $layout_name = 'layouts.main';
    @endphp
@endif
@extends($layout_name)
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@section('tab-title', 'Профіль користувача: ' . $user->nickname)
@section('page-content')
<div class="user-block">
    <div class="shadow-sm user-info-container">
        <img src="{{ asset($user->img_path) }}" alt="Фото користувача">
        <h2 style="margin-bottom: -7px;">{{ $user->nickname }}</h2>
        <p class="text-muted">Рецептів опубліковано: {{ count($user->recipes) }}</p>
        @if (Auth::user()->user_id == $user->user_id)
            <a class="btn btn-primary" style="margin-top: 3px" href="{{ route('users.edit_profile', Auth::user()->user_id) }}">Редагувати Профіль</a>
        @endif
    </div>
</div>

<div class="user-content-block">
    <div class="shadow-sm recipe-block">
        @if (count($recipes) == 0)
            <h3 style="text-align: center;margin-top:1vh;">Опубліковані Рецепти</h3>
            @if (Auth::user()->user_id == $user_id)
                <p style="text-align: center; margin-top: 10vh;">У вас ще немає опублікованих Рецептів</p>
            @else
                <p style="text-align: center; margin-top: 10vh;">Користувач не має опублікованих Рецептів</p>
            @endif
        @else
            <h3 style="text-align: center;margin-top:1vh;margin-left:9vw;margin-bottom:0">Опубліковані Рецепти <span><a class="btn btn-primary" href="{{ route('recipes.show_user', $user_id) }}">Переглянути всі</a></span></h3>
            <div class="recipe-list">
                @foreach ($recipes as $recipe)
                    <div class="card recipe" style="max-width: 50%; height: 90% !important;margin-bottom:2vh;">
                        <div class="row no-gutters" style="height: 100%; !important">
                            <div class="col-6">
                                <img class="card-img" src="{{ asset($recipe->img_path) }}" alt="...">
                            </div>
                        
                            <div class="col-6">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $recipe->name }}</h5>
                                    <p class="card-text">{{ $recipe->meal_type }}</p>
                                    <p class="left-align card-text">{{ Illuminate\Support\Str::limit($recipe->description, $limit = 35, $end = '...') }}</p>
                                    <p class="card-text"><small class="text-muted">Востаннє оновлений {{ $recipe->updated_at->format('d-m-Y H:i') }}</small></p>
                                    <a class="btn btn-sm btn-outline-secondary" style="float: right; margin-top: -1vh;" href="{{ route('recipes.show', $recipe->recipe_id) }}">
                                        Переглянути
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="shadow-sm recipe-collection-block">
            @if (count($recipe_collections) == 0)
                <h3 style="text-align: center;">Збірки Рецептів</h3>
                @if (Auth::user()->user_id == $user_id)
                    <p style="text-align: center; margin-top:8vh;">У вас ще немає збірок Рецептів</p>
                    <a class="btn btn-primary" style="margin-left: 28vw;" href="{{ route('recipe_collections.create', Auth::user()->user_id) }}">Створити нову Збірку</a> 
                @else
                    <p style="text-align: center; margin-top:15vh">Цей користувач не має Збірок Рецептів, які ви можете переглянути</p>
                @endif
            @else
                <h3 style="text-align: center;margin-top:1vh;margin-left:9vw;">Збірки Рецептів <span><a class="btn btn-primary" href="{{ route('users.show_recipe_collections', $user_id) }}">Переглянути всі</a></span></h3>
                <div class="recipe-collection-list">
                    @foreach ($recipe_collections as $recipe_collection)
                    <div class="card recipe-collection" style="max-width: 50%; height: 90% !important;margin-bottom:2vh; margin-top:0">
                        <div class="row no-gutters" style="height: 100%; !important">
                            <div class="col-6">
                                <img class="card-img"src="{{ asset($recipe_collection->img_path) }}" alt="...">
                            </div>
                        
                            <div class="col-6">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $recipe_collection->name }}</h5>
                                    @if (isset($recipe_collection->description))
                                        <p class="left-align card-text">{{ Illuminate\Support\Str::limit($recipe_collection->description, $limit = 35, $end = '...') }}</p>
                                    @else
                                        <p class="card-text" style="margin-top: 5vh;">Без опису</p>
                                    @endif
                                    <p class="card-text" style="margin-top:6vh;"><small class="text-muted">Востаннє оновлена {{ $recipe_collection->updated_at->format('d-m-Y H:i') }}</small></p>
                                    <a class="btn btn-outline-secondary" style="float: right; margin-top: -1vh; font-size: 14px" href="{{ route('recipe_collections.show_recipes', [$user_id, $recipe_collection->recipe_collection_id]) }}">
                                        Переглянути
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
    </div>
</div>
@endsection