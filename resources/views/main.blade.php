@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@section('page-content')
<div class="container-fluid main-content col-6">
    <h2>Нові Рецепти</h2>
    <div class="recent_recipes_container">
        @foreach ($recent_recipes as $recent_recipe)
        <div class="card-body shadow-sm recent_recipe">
            <img src="{{ $recent_recipe->img_path }}" alt="Картинка рецепту">
            <br>
            <h3>{{ $recent_recipe->name }}</h3>
            <p class="left-align">{{ Illuminate\Support\Str::limit($recent_recipe->description, $limit = 60, $end = '...') }}</p>
            <a class="btn btn-sm btn-outlinesecondary" href="{{ route('recipes.show', $recent_recipe->recipe_id) }}">
                Переглянути
            </a>
        </div>
        @endforeach
    </div>
</div>
<div class="container-fluid popular-recipes-panel col-6">
    <h2>Найкраще оцінені Рецепти</h2>
    @foreach ($best_recipes as $best_recipe)
    <div class="card-body shadow-sm best_recipe">
        <img src="{{ $best_recipe->img_path }}" alt="Картинка рецепту">
        <br>
        <h3>{{ $best_recipe->name }}</h3>
        <p class="left-align">{{ Illuminate\Support\Str::limit($best_recipe->description, $limit = 60, $end = '...') }}</p>
        <a class="btn btn-sm btn-outlinesecondary" href="{{ route('recipes.show', $best_recipe->recipe_id) }}">
            Переглянути
        </a>
    </div>
    @endforeach
</div>
<div class="link-container">
    <a id="show-recipes" href="{{ route('recipes.show_all') }}">Переглянути усі Рецепти</a>
</div>
@endsection