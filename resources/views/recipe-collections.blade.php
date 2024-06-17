@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe-collections.css') }}">
@section('tab-title', 'Збірки Рецептів')
@section('page-content')
    <h2 style="text-align: center;">Збірки Рецептів</h2>
    <div style="width:85%;display: flex; flex-direction: row; flex-wrap:wrap; justify-content: center;margin-left:auto;margin-right:auto;">
        @foreach ($recipe_collections as $recipe_collection)
        <div class="card recipe-collection">
        <img class="card-img" src="{{ asset($recipe_collection->img_path) }}" alt="Картинка збірки">
        <div class="card-body">
            <h3 class="card-title">
                {{ $recipe_collection->name }}
                @if(isset($recipe_to_add_in_collection))
                    <button class="btn btn-outline-success"  data-bs-toggle="modal" data-bs-target="#addModal-{{ $recipe_collection->recipe_collection_id }}"><i class="fas fa-plus"></i></button></button>
                    <div class="modal fade" id="addModal-{{ $recipe_collection->recipe_collection_id }}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalLabel">Збірка Рецептів</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="text-align:center;font-size:17px;font-weight:normal;">
                                    Додати обраний Рецепт у Збірку Рецептів "{{ $recipe_collection->name }}"?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ні</button>
                                    <form id="form_add-{{ $recipe_collection->recipe_collection_id }}"
                                        action="{{ route('recipe_collections.store_recipe', [$recipe_collection->recipe_collection_id, $recipe_to_add_in_collection]) }}" method="POST">
                                        @csrf
                                        <button type="submit" id="add-{{ $recipe_collection->recipe_collection_id }}"
                                        class="btn btn-primary">Так</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </h3>
            @if (isset($recipe_collection->description))
            <p class="card-text">{{ Illuminate\Support\Str::limit($recipe_collection->description, $limit = 120, $end = '...') }}</p>
            @else
                <p class="card-text">Без опису</p>
            @endif
            <p class="card-text"><small class="text-muted">Востаннє оновлений {{ $recipe_collection->updated_at->format('d-m-Y H:i') }}</small></p>
        </div>
        <div class="card-footer">
            <a class="btn btn-outline-secondary" style="font-size:12px;float:right;" href="{{ route('recipe_collections.show_recipes', [$user_id, $recipe_collection->recipe_collection_id]) }}">
                Переглянути
            </a>
            @if (Auth::user()->user_id == $user_id)
                <a class="btn btn-outline-primary" style="" href="{{ route('recipe_collections.edit', [$recipe_collection->recipe_collection_id]) }}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <button class="btn btn-outline-danger" style="" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $recipe_collection->recipe_collection_id }}">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <div class="modal fade" id="deleteModal-{{ $recipe_collection->recipe_collection_id }}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalLabel">Збірка Рецептів</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="text-align: center;">
                                Видалити Збірку Рецептів "{{ $recipe_collection->name }}"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ні</button>
                                <form id="form_delete-{{ $recipe_collection->recipe_collection_id }}"
                                    action="{{ route('recipe_collections.destroy', $recipe_collection->recipe_collection_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="delete-{{ $recipe_collection->recipe_collection_id }}"
                                    class="btn btn-danger">Видалити</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endforeach
    </div>
    @if (Auth::user()->user_id == $user_id)
        <div class="create-button-block">
            <a class="btn btn-success" style="margin-top:auto;margin-bottom:auto;" href="{{ route('recipe_collections.create', Auth::user()->user_id) }}">Створити нову Збірку Рецептів</a>
        </div>
    @endif        
@endsection