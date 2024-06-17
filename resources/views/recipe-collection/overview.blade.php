@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe-collection/overview.css') }}">
@section('tab-title', 'Усі Рецепти Збірки')
@section('page-content')
    <h2 style="text-align: center;">{{ $recipe_collection->name }}</h2>
    <p style="margin-bottom:4vh;" style="text-align:center;" class="text-muted">{{ $recipe_collection->description }}</p>
    @if (count($recipe_collection->recipes) > 0)
        <div class="recipes-container">
                @foreach ($recipe_collection->recipes as $recipe)
                    <div class="card mb-3 recipe" style="max-width: 40%;">
                        <div class="row" style="@import 'bootstrap/scss/bootstrap';--bs-gutter-x: 0;">
                            <div class="col-6" style="padding: 0;">
                                <img class="card-img" src="{{ asset($recipe->img_path) }}" alt="...">
                            </div>
                            <div class="col-6">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $recipe->name }}</h5>
                                    <p class="card-text">{{ $recipe->meal_type }}</p>
                                    <p class="left-align card-text">{{ Illuminate\Support\Str::limit($recipe->description, $limit = 60, $end = '...') }}</p>
                                    <p class="left-align card-text">Автор: {{ $recipe->user->nickname }}</p>
                                    <p class="card-text"><small class="text-muted">Востаннє оновлений {{ $recipe->updated_at->format('d-m-Y H:i') }}</small></p>
                                    <a class="btn btn-sm btn-outline-secondary" style="float: right; margin-bottom: 4%;" href="{{ route('recipes.show', $recipe->recipe_id) }}">
                                        Переглянути
                                    </a>
                                    @if (Auth::user()->user_id == $recipe_collection->user_id)
                                    <button class="btn btn-outline-danger" style="float: right; margin-right:0.5vw;" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$recipe_collection->recipe_collection_id}}-{{$recipe->recipe_id}}"><i class="fas fa-trash-alt"></i></button>
                                    <div class="modal fade" id="deleteModal-{{$recipe_collection->recipe_collection_id}}-{{$recipe->recipe_id}}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ModalLabel">Збірка Рецептів</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="text-align: center;">
                                                    Видалити Рецепт "{{ $recipe->name }}" зі Збірки "{{ $recipe_collection->name }}" ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ні</button>
                                                    <form id="form_delete-{{$recipe_collection->recipe_collection_id}}-{{$recipe->recipe_id}}"
                                                        action="{{ route('recipe_collections.delete_recipe', [$recipe_collection->recipe_collection_id, $recipe->recipe_id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" id="delete"
                                                        class="btn btn-danger">Видалити</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
    @else
    <h3 style="text-align: center; margin-top:15%">Збірка ще не містить рецептів</h3>
    @endif
@endsection