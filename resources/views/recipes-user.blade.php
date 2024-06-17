@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipes-user.css') }}">
@section('tab-title', 'Усі Рецепти Користувача')
@section('page-content')
    @if (Auth::user()->user_id == $user_id)
        <h2 class="title">Усі Ваші Рецепти</h2>
    @else
        <h2 class="title">Усі Рецепти Користувача</h2>
    @endif
    @foreach ($recipes as $recipe)
        <div class="card recipe" style="max-width: 43%;height: 41vh;">
            <div class="row" style="height: 100%; !important">
                <div class="col-6" style="padding: 0;">
                    <img class="card-img" src="{{ asset($recipe->img_path) }}" alt="...">
                </div>
                <div class="col-6" style="height: 100%">
                    <div class="card-body" style="height: 100%;">
                        @if (Auth::user()->user_id == $user_id)
                            <h5 class="card-title">
                                {{ $recipe->name }}
                                <a class="btn btn-outline-primary" href="{{ route('recipes.edit', $recipe->recipe_id) }}"><i class="fas fa-pencil-alt"></i></a>
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $recipe->recipe_id }}"><i class="fas fa-trash-alt"></i></button>
                            </h5>
                            <div class="modal fade" id="deleteModal-{{ $recipe->recipe_id }}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabel">Рецепт</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="text-align: center;">
                                            Видалити Рецепт "{{ $recipe->name }}"?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ні</button>
                                            <form id="form_delete-{{ $recipe->recipe_id }}"
                                                action="{{ route('recipes.destroy', $recipe->recipe_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" id="delete-{{ $recipe->recipe_id }}"
                                                class="btn btn-danger">Видалити</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <h5 class="card-title">{{ $recipe->name }}</h5>
                        @endif
                        <p class="card-text">{{ $recipe->meal_type }}</p>
                        <p class="left-align card-text">{{ Illuminate\Support\Str::limit($recipe->description, $limit = 60, $end = '...') }}</p>
                        @if (Auth::user()->user_id != $user_id)
                        <p class="left-align card-text">Автор: {{ $recipe->user->nickname }}</p>
                        @endif
                        <p class="card-text"><small class="text-muted">Востаннє оновлений {{ $recipe->updated_at->format('d-m-Y H:i') }}</small></p>
                        <a class="btn btn-sm btn-outline-secondary" style="width: 40%;justify-self: end;align-self: end;" href="{{ route('recipes.show', $recipe->recipe_id) }}">
                            Переглянути
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection