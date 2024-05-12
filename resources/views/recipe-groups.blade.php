@extends('layout')
<link rel="stylesheet" href="{{ asset('css/recipe-groups.css') }}">
@section('tab-title', 'Групи Рецептів')
@section('page-content')
    @foreach ($recipe_groups as $recipe_group)
            <div class="recipe-group-container">
                <div class="card-body shadow-sm recipe-group">
                    <h3>{{ $recipe_group->name }}</h3>
                    <img src="{{ asset($recipe_group->img_path) }}" alt="Картинка групи">
                    <br>
                    <p class="left-align">{{ Illuminate\Support\Str::limit($recipe_group->description, $limit = 120, $end = '...') }}</p>
                    <!--спробувати різні значення довжини тексту-->
                    <a href="{{ route('recipe_groups.show_recipes', [$user_id, $recipe_group->recipe_group_id]) }}">
                        <button class="btn-btn recipe-view">Переглянути</button>
                    </a>
                </div>
            </div>
    @endforeach
@endsection