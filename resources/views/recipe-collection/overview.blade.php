@extends('layouts.main')

@section('tab-title', 'Усі Рецепти Колекції "{{ $recipe_collection->name }}"')
@section('page-content')
    <h2>{{ $recipe_collection->name }}</h2>
    @foreach ($recipe_collection->recipes as $recipe)
            <div class="recipe-container">
                <div class="card-body shadow-sm recent_recipe">
                    <h3>{{ $recipe->name }}</h3>
                    <img src="{{ asset($recipe->img_path) }}" alt="Картинка рецепту">
                    <br>
                    <p class="left-align">{{ Illuminate\Support\Str::limit($recipe->description, $limit = 120, $end = '...') }}</p>
                    <!--спробувати різні значення довжини тексту-->
                    <a class="btn" href="{{ route('recipes.show', $recipe->recipe_id) }}">Переглянути</a>
                    @if (Auth::user()->user_id == $user_id)
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$recipe_collection->recipe_collection_id}}-{{$recipe->recipe_id}}">Видалити зі Збірки</button>
                        <div class="modal fade" id="deleteModal-{{$recipe_collection->recipe_collection_id}}-{{$recipe->recipe_id}}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ModalLabel">Видалення Рецепту зі Збірки Рецептів</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Видалити Рецепт "{{ $recipe->name }}" зі Збірки "{{ $recipe_collection->name }}" ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bsdismiss="modal">Ні</button>
                                        <form id="form_delete-{{$recipe_collection->recipe_collection_id}}-{{$recipe->recipe_id}}"
                                            action="{{ route('recipe_collections.delete_recipe', [Auth::user()->user_id, $recipe_collection->recipe_collection_id, $recipe->recipe_id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="delete"
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