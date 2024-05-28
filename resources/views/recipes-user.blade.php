@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipes-user.css') }}">
@section('tab-title', 'Усі Рецепти Користувача')
@section('page-content')
    @foreach ($recipes as $recipe)
            <div class="recipe-container">
                <div class="card-body shadow-sm recent_recipe">
                    <h3>{{ $recipe->name }}</h3>
                    <img src="{{ asset($recipe->img_path) }}" alt="Картинка рецепту">
                    <br>
                    <p class="left-align">{{ Illuminate\Support\Str::limit($recipe->description, $limit = 120, $end = '...') }}</p>
                    <!--спробувати різні значення довжини тексту-->
                    <a class="btn" href="{{ route('recipes.show', $recipe->recipe_id) }}">Переглянути</a>
                    @if (Auth::user()->user_id == $user_id)
                        <div class="navitem dropdown btn btn edit-button">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Редагувати</a>
                            <ul class="dropdown-menu">
                            <li><a href="{{ route('recipes.edit_general_data', $recipe->recipe_id) }}">Загальні дані</a></li>
                            <li><a href="">Інгрідієнти</a></li>
                            <li><a href="">Кроки</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $recipe->recipe_id }}">Видалити</button>
                        <div class="modal fade" id="deleteModal-{{ $recipe->recipe_id }}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ModalLabel">Видалення Збірки Рецептів</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Видалити Рецепт "{{ $recipe->name }}"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bsdismiss="modal">Ні</button>
                                        <form id="form_delete-{{ $recipe->recipe_id }}"
                                            action="{{ route('recipes.destroy', $recipe->recipe_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="delete-{{ $recipe->recipe_id }}"
                                            class="btn btn-primary">Видалити</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    @endforeach
@endsection