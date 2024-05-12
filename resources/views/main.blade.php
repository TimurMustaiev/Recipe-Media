@extends('layout')
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@section('page-content')
<div class="container-fluid main-content col-9">
    <h2>Нові Рецепти</h2>
    @foreach ($recent_recipes as $recent_recipe)
        <div class="card-body shadow-sm recent_recipe">
            <h3>{{ $recent_recipe->name }}</h3>
            <img src="{{ $recent_recipe->img_path }}" alt="Картинка рецепту">
            <br>
            <p class="left-align">{{ Illuminate\Support\Str::limit($recent_recipe->description, $limit = 60, $end = '...') }}</p>
            <a href="{{ route('recipes.show', $recent_recipe->recipe_id) }}">
                <button class="btn-btn recipe-view">Переглянути</button>
            </a>
        </div>
    @endforeach
    <a id="show-recipes" href="{{ route('recipes.show_all') }}">Переглянути усі Рецепти</a>
</div>
<div class="container popular-recipes-panel col-3">
</div>
<footer class="row">
</footer>
@endsection