@extends('layouts.main-footer')
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@section('page-content')
<div class="main-content col-6">
    <h2 class="mb-4" style="text-align:center;">Нові Рецепти</h2>
    <div class="recent_recipes_container">
        @foreach ($recent_recipes as $recent_recipe)
        <div class="card recent-recipe mb-5" style="max-width: 75%;">
            <div class="row">
              <div class="col-6" style="padding: 0;">
                <img class="card-img" src="{{ asset($recent_recipe->img_path) }}" alt="...">
              </div>
              <div class="col-6">
                <div class="card-body">
                    <h5 class="card-title">{{ $recent_recipe->name }}</h5>
                    <p class="card-text">{{ $recent_recipe->meal_type }}</p>
                    <p class="left-align card-text">{{ Illuminate\Support\Str::limit($recent_recipe->description, $limit = 60, $end = '...') }}</p>
                    <p class="left-align card-text">Автор: {{ $recent_recipe->user->nickname }}</p>
                    <p class="card-text"><small class="text-muted">Востаннє оновлений {{ $recent_recipe->updated_at->format('d-m-Y H:i') }}</small></p>
                    <a class="btn btn-sm btn-outline-secondary" style="float: right; margin-bottom: 4%;" href="{{ route('recipes.show', $recent_recipe->recipe_id) }}">
                        Переглянути
                    </a>
                </div>
              </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="best-recipes-panel col-6">
    <h2 class="mb-4" style="text-align:center;">Найкращі Рецепти</h2>
    <div class="best_recipes_container">
        @foreach ($best_recipes as $best_recipe)
                <div class="card best-recipe mb-5" style="max-width: 75%;">
                    <div class="row no-gutters">
                    <div class="col-6" style="padding: 0;">
                        <img class="card-img" src="{{ asset($best_recipe->img_path) }}" alt="...">
                    </div>
                    <div class="col-6">
                        <div class="card-body">
                            <h5 class="card-title">{{ $best_recipe->name }}</h5>
                            <p class="card-text">{{ $best_recipe->meal_type }}</p>
                            <p class="left-align card-text">{{ Illuminate\Support\Str::limit($best_recipe->description, $limit = 60, $end = '...') }}</p>
                            <p class="left-align card-text">Автор: {{ $best_recipe->user->nickname }}</p>
                            <p class="left-align card-text">Середня оцінка: {{ number_format($best_recipe->recipe_ratings->first()->avg_recipe_rating, 1) }} з {{$best_recipe->recipe_ratings_count}} голосів</p>
                            <p class="card-text"><small class="text-muted">Востаннє оновлений {{ $best_recipe->updated_at->format('d-m-Y H:i') }}</small></p>
                            <a class="btn btn-sm btn-outline-secondary" style="float: right; margin-bottom: 4%;" href="{{ route('recipes.show', $best_recipe->recipe_id) }}">
                                Переглянути
                            </a>
                        </div>
                    </div>
                    </div>
                </div>
        @endforeach
    </div>
</div>
@endsection