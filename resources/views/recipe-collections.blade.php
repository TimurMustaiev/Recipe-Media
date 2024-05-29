@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe-collections.css') }}">
@section('tab-title', 'Збірки Рецептів')
@section('page-content')
    @foreach ($recipe_collections as $recipe_collection)
            <div class="recipe-collection-container">
                <div class="card-body shadow-sm recipe-collection">
                    <h3>{{ $recipe_collection->name }}</h3>
                    <img src="{{ asset($recipe_collection->img_path) }}" alt="Картинка збірки">
                    <br>
                    @if (isset($recipe_collection->description)) <!--css-->
                        <p class="right-align">{{ Illuminate\Support\Str::limit($recipe_collection->description, $limit = 120, $end = '...') }}</p>
                    @else
                        <p>Без опису</p>
                        <br>
                    @endif
                    <!--спробувати різні значення довжини тексту-->
                    <a class="btn" href="{{ route('recipe_collections.show_recipes', [$user_id, $recipe_collection->recipe_collection_id]) }}">
                        Переглянути
                    </a>
                    @if (Auth::user()->user_id == $user_id)
                        @if(isset($recipe_to_add_in_collection))
                            <button class="btn btn" data-bs-toggle="modal" data-bs-target="#addModal-{{ $recipe_collection->recipe_collection_id }}">Додати Рецепт у Колекцію</button>
                            <div class="modal fade" id="addModal-{{ $recipe_collection->recipe_collection_id }}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabel">Розширення Збірки Рецептів</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Додати Рецепт у Збірку Рецептів "{{ $recipe_collection->name }}"?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bsdismiss="modal">Ні</button>
                                            <form id="form_add-{{ $recipe_collection->recipe_collection_id }}"
                                                action="{{ route('recipe_collections.store_recipe', [Auth::user()->user_id, $recipe_collection->recipe_collection_id, $recipe_to_add_in_collection]) }}" method="POST">
                                                @csrf
                                                <button type="submit" id="add-{{ $recipe_collection->recipe_collection_id }}"
                                                class="btn btn-primary">Додати</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <a class="btn btn" href="{{ route('recipe_collections.edit', [$user_id, $recipe_collection->recipe_collection_id]) }}">
                            Редагувати
                        </a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $recipe_collection->recipe_collection_id }}">Видалити</button>
                        <div class="modal fade" id="deleteModal-{{ $recipe_collection->recipe_collection_id }}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ModalLabel">Видалення Збірки Рецептів</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Видалити Збірку Рецептів "{{ $recipe_collection->name }}"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bsdismiss="modal">Ні</button>
                                        <form id="form_delete-{{ $recipe_collection->recipe_collection_id }}"
                                            action="{{ route('recipe_collections.destroy', [Auth::user()->user_id == $user_id, $recipe_collection->recipe_collection_id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="delete-{{ $recipe_collection->recipe_collection_id }}"
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
    @if (Auth::user()->user_id == $user_id)
        <a href="{{ route('recipe_collections.create', Auth::user()->user_id) }}">Створити нову Збірку Рецептів</a>
    @endif        
@endsection