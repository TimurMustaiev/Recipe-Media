@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipes.css') }}">
@section('tab-title', 'Рецепти')
@section('page-content')
    @if (count($recipes) != 0)
        <div class="card-group recipes-container">
            <div class="row" style="margin-left:auto;margin-right: auto;justify-content:space-evenly; height:44vh;width:100%;!important">
                @foreach ($recipes as $recipe)
                    <div class="card mb-3 recipe" style="max-width: 35%;max-height:100%;margin-bottom: 2vh;!important">
                        <div class="row no-gutters" style="margin-right: 0;height:100%;!important">
                            <div class="col-6" style="padding: 0;height:100%;!important">
                                <img class="card-img" src="{{ asset($recipe->img_path) }}" alt="...">
                            </div>
                            <div class="col-6" style="padding-bottom: 0;max-height:100%;!important">
                                <div class="card-body" style="padding-bottom: 0;;width:100%;height:100%;!important">
                                    <h5 class="card-title">{{ $recipe->name }}</h5>
                                    <p class="card-text">{{ $recipe->meal_type }}</p>
                                    <p class="left-align card-text">{{ Illuminate\Support\Str::limit($recipe->description, $limit = 40, $end = '...') }}</p>
                                    <p class="left-align card-text">Автор: {{ $recipe->user->nickname }}</p>
                                    <p class="card-text"><small class="text-muted">Востаннє оновлений {{ $recipe->updated_at->format('d-m-Y H:i') }}</small></p>
                                    <div class="mt-auto" style="float: right;margin-bottom:2vh;width:110%"> <!-- This div ensures the button stays at the bottom -->
                                        <a class="btn btn-sm btn-outline-secondary" style="float: right;" href="{{ route('recipes.show', $recipe->recipe_id) }}">
                                            Переглянути
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
    <h2>На жаль, не було знайдено рецептів</h2>
    @endif
@endsection