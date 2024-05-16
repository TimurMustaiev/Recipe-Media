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
                    @if (Auth::user()->user_id == $user_id)
                        <a href="{{ route('recipe_groups.edit', [$user_id, $recipe_group->recipe_group_id]) }}">
                            <button class="btn-btn recipe-view">Редагувати</button>
                        </a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $recipe_group->recipe_group_id }}">Видалити</button>
                        <div class="modal fade" id="deleteModal-{{ $recipe_group->recipe_group_id }}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ModalLabel">Видалення Групи Рецептів</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Видалити Групу Рецептів "{{ $recipe_group->name }}"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bsdismiss="modal">Ні</button>
                                        <form id="form_delete-{{ $recipe_group->recipe_group_id }}"
                                            action="{{ route('recipe_groups.destroy', [Auth::user()->user_id == $user_id, $recipe_group->recipe_group_id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="delete-{{ $recipe_group->recipe_group_id }}"
                                            class="btn btn-primary">Видалити
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    @endforeach
    @if (Auth::user()->user_id == $user_id)
        <a href="{{ route('recipe_groups.create', Auth::user()->user_id) }}">Створити нову Групу Рецептів</a>
    @endif        
@endsection