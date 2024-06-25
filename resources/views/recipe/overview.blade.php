@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe/overview.css') }}">
@section('tab-title', 'Рецепт: ' . $recipe->name)
@section('page-content')
    <div class="recipe-container shadow">
        <div class="general-info">
            <img class="shadow-sm" style="height: 50vh; width:30vw;" src="{{ asset($recipe->img_path) }}" alt="Фото страви">
            <div class="text-entry">
                <h2 style="text-align: left;margin-left: 20vw;margin-bottom:5vh;">{{ $recipe->name }}</h2>
                @if (Request::has('edit_mode'))
                    <a href="{{ route('recipes.edit_general_data', [Auth::user()->user_id, $recipe->recipe_id]) }}">
                        <i class="fas fa-pencil-alt" style="float: left;">Загальна інформація</i>
                    </a>
                    <br>
                @endif
                @if (isset($recipe->description))
                <p>Від Автора ({{$recipe->user->nickname}}): {{ $recipe->description }}</p>
                @endif
                <p>Тип: <i>{{ $recipe->meal_type }}</i></p>
                <p>Кухня: <i>{{ $recipe->cuisine->name }}</i></p>
                <p><small class="text-muted">Востаннє оновлений {{ $recipe->updated_at->format('d-m-Y H:i') }}</small></p>
                @if (!Request::has('edit_mode'))
                <div class="like-recipe-block" style="float:left;">
                    <p style="margin-bottom: 2px;">Оцініть Рецепт!</p>
                    <form style="float: left;" action="{{ route('recipe_ratings.store', $recipe->recipe_id) }}" method="POST" id="star-rating-form">
                        @csrf
                        <input type="radio" id="star5" name="recipe_rating" value="5" onclick="submitForm()" />
                        <label for="star5" title="5 star"></label>
                        <input type="radio" id="star4" name="recipe_rating" value="4" onclick="submitForm()" />
                        <label for="star4" title="4 stars"></label>
                        <input type="radio" id="star3" name="recipe_rating" value="3" onclick="submitForm()" />
                        <label for="star3" title="3 stars"></label>
                        <input type="radio" id="star2" name="recipe_rating" value="2" onclick="submitForm()" />
                        <label for="star2" title="2 stars"></label>
                        <input type="radio" id="star1" name="recipe_rating" value="1" onclick="submitForm()" />
                        <label for="star1" title="1 star"></label>
                    </form>
                </div>                
                <script>
                    function submitForm() {
                        document.getElementById('star-rating-form').submit();
                    }
                </script>                          
                @if (session('rating_stored_value'))
                    <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="ModalLabel">Оцінка Рецепту</h5>
                                </div>
                                <div class="modal-body">
                                Ви оцінили цей рецепт на {{ session('rating_stored_value') }} бали/-ів!
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            $(document).ready(function() {
                                // Show the modal
                                $('#ratingModal').modal('show');

                                setTimeout(function() {
                                    $('#ratingModal').modal('hide');
                                }, 2000);
                            });
                        });
                    </script>
                @endif
            @endif
            </div>
        </div>
        @auth
        <a class="btn btn-success" style="width:20%; margin-left:14vw;margin-bottom:4vh;margin-top:-2vh;" href="{{ route('users.show_recipe_collections', Auth::user()->user_id)}}?recipe-to-add-in-collection={{$recipe->recipe_id}}">Додати у Збірку Рецептів</a>
        @endauth
        <div class="main-info">
            <div class="ingredients-container">
                @if (Request::has('edit_mode'))
                <h4 style="width: 12vw;">Інгредієнти <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addIngredientModal"><i class="fas fa-plus"></i></button></h4>
                <div class="modal fade" id="addIngredientModal" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalLabel">Новий Інгредієнт</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="form_add_ingredient"
                                    action="{{ route('recipes.add_ingredient', $recipe->recipe_id) }}" method="POST">
                                    @csrf
                                    <label for="recipe_ingredient" style="float: left; margin-left: 2%;">Інгредієнт</label>
                                    <input id="recipe_ingredient" name="recipe_ingredient" class="form-control" type="text">
                                    <label for="amount" class="mt-2" style="float: left; margin-left: 2%;">Кількість Інгредієнту</label>
                                    <input id="amount" name="amount" class="form-control" type="number" min="0" step="any">
                                    <label for="unit" class="mt-2" style="float: left; margin-left: 2%;">Одиниця вимірювання кількості</label>
                                    <select id="unit" name="unit" class="form-select">
                                        <option value="г.">Грам</option>
                                        <option value="кг.">Кілограм</option>
                                        <option value="мл.">Мілілітр</option>
                                        <option value="л.">Літр</option>
                                        <option value="ст.л.">Столова Ложка</option>
                                        <option value="ч.л.">Чайна Ложка</option>
                                        <option value="шт.">Штука</option>
                                    </select>
                                    <button class="mt-4 btn btn-primary" type="submit" style="width: 25%;margin-left:11.5vw;">Додати</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <h4>Інгредієнти</h4>
            @endif
            @foreach ($recipe->recipe_ingredients as $recipe_ingredient)
                            @if (Request::has('edit_mode'))
                                <div style="margin-bottom: 2vh;" class="ingredient-field">
                                    <p style="margin-bottom: 0;">{{ $recipe_ingredient->name }} <strong>{{ $recipe_ingredient->amount }} {{ $recipe_ingredient->unit }}</strong></p>
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editIngredientModal-{{ $recipe_ingredient->recipe_ingredient_id }}"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteIngredientModal-{{ $recipe_ingredient->recipe_ingredient_id }}"><i class="fas fa-trash-alt"></i></button>
                                </div>
                                <div class="modal fade" id="editIngredientModal-{{ $recipe_ingredient->recipe_ingredient_id }}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Існуючий Інгредієнт</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_edit_ingredient-{{ $recipe_ingredient->recipe_ingredient_id }}"
                                                    action="{{ route('recipes.update_ingredient', [$recipe->recipe_id, $recipe_ingredient->recipe_ingredient_id]) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <label style="float: left; margin-left: 2%;" for="recipe_ingredient">Інгредієнт</label>
                                                    <input id="recipe_ingredient" name="recipe_ingredient" class="form-control" type="text" placeholder="Інгредієнт" value="{{ $recipe_ingredient->name }}">
                                                    <label for="amount" class="mt-2" style="float: left; margin-left: 2%;">Кількість Інгредієнту</label>
                                                    <input id="amount" name="amount" class="form-control" type="number" min="0" step="any" value="{{ $recipe_ingredient->amount }}">
                                                    <label for="unit" class="mt-2" style="float: left; margin-left: 2%;">Одиниця вимірювання кількості</label>
                                                    <select id="unit" name="unit" class="form-select">
                                                        <option value="г." {{ $recipe_ingredient->unit == 'г.' ? 'selected' : '' }}>Грам</option>
                                                        <option value="кг." {{ $recipe_ingredient->unit == 'кг.' ? 'selected' : '' }}>Кілограм</option>
                                                        <option value="мл." {{ $recipe_ingredient->unit == 'мл.' ? 'selected' : '' }}>Мілілітр</option>
                                                        <option value="л." {{ $recipe_ingredient->unit == 'л.' ? 'selected' : '' }}>Літр</option>
                                                        <option value="ст.л." {{ $recipe_ingredient->unit == 'ст.л.' ? 'selected' : '' }}>Столова Ложка</option>
                                                        <option value="ч.л." {{ $recipe_ingredient->unit == 'ч.л.' ? 'selected' : '' }}>Чайна Ложка</option>
                                                        <option value="шт." {{ $recipe_ingredient->unit == 'шт.' ? 'selected' : '' }}>Штука</option>
                                                    </select>
                                                    <button class="mt-4 btn btn-primary" style="width: 25%;margin-left:11.5vw;" type="submit">Змінити</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteIngredientModal-{{ $recipe_ingredient->recipe_ingredient_id }}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Існуючий Інгредієнт</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Видалити цей Інгредієнт?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ні</button>
                                                <form id="form_delete-{{ $recipe_ingredient->recipe_ingredient_id }}"
                                                    action="{{ route('recipes.delete_ingredient', [$recipe->recipe_id, $recipe_ingredient->recipe_ingredient_id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" id="delete-{{ $recipe_ingredient->recipe_ingredient_id }}"
                                                    class="btn btn-danger">Видалити
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p style="width:15vw;">{{ $recipe_ingredient->name }} <strong>{{ $recipe_ingredient->amount }} {{ $recipe_ingredient->unit }}</strong></p>
                            @endif
                    @endforeach
            </div>
            <div class="steps-container">
                    @if (Request::has('edit_mode'))
                    <h4>Кроки приготування <span><button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addStepModal"><i class="fas fa-plus"></i></button></span></h4>
                    <div class="modal fade" id="addStepModal" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalLabel">Новий Крок</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form_add_ingredient"
                                        action="{{ route('recipes.add_step', $recipe->recipe_id) }}" method="POST">
                                        @csrf
                                        <label style="float: left; margin-left: 2%;" for="ordinal_number">Номер</label>
                                        <input type="number" min="1" name="ordinal_number" id="ordinal_number" class="form-control">
                                        <label class="mt-2" style="float: left; margin-left: 2%;" for="description">Опис</label>
                                        <textarea rows="4" id="description" name="description" class="form-control"></textarea>
                                        <button class="mt-4 btn btn-primary" style="width:25%;margin-left:11.5vw;" type="submit">Додати</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <h4>Кроки приготування</h4>
                @endif
                @foreach ($recipe->recipe_steps->sortBy('ordinal_number') as $recipe_step)
                    <div>
                        <p class="recipe-step" style="margin-right:2vw;margin-bottom:3vh;margin-top:2vw;"><span class="recipe-step-number">{{ $recipe_step->ordinal_number }}.</span> {{ $recipe_step->description }}</p>
                        @if (Request::has('edit_mode'))
                            <button style="margin-bottom: 3vh;" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editStepModal-{{ $recipe_step->recipe_step_id }}"><i class="fas fa-pencil-alt"></i></button>
                            <button style="margin-bottom: 3vh;" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteStepModal-{{ $recipe_step->recipe_step_id }}"><i class="fas fa-trash-alt"></i></button>
                            <div class="modal fade" id="editStepModal-{{ $recipe_step->recipe_step_id }}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabel">Існуючий Крок</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form_edit_step-{{ $recipe_step->recipe_step_id }}"
                                                action="{{ route('recipes.update_step', [$recipe->recipe_id, $recipe_step->recipe_step_id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <label style="float: left; margin-left: 2%;" for="ordinal_number">Номер</label>
                                                <input class="form-control" type="number" min="1" name="ordinal_number" value="{{ $recipe_step->ordinal_number }}">
                                                <label class="mt-2" style="float: left; margin-left: 2%;" for="description">Опис</label>
                                                <textarea rows="4" id="description" name="description" class="form-control">{{ $recipe_step->description }}</textarea>
                                                <button class="mt-4 btn btn-primary" style="width:25%;margin-left:11.5vw;" type="submit">Змінити</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="deleteStepModal-{{ $recipe_step->recipe_step_id }}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabel">Існуючий Крок</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Видалити цей Крок?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ні</button>
                                            <form id="form_delete-{{ $recipe_step->recipe_step_id }}"
                                            action="{{ route('recipes.delete_step', [$recipe->recipe_id, $recipe_step->recipe_step_id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" id="delete-{{ $recipe_step->recipe_step_id }}"
                                                class="btn btn-danger">Видалити
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif 
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @if (!Request::has('edit_mode'))
        <div class="comment-section shadow">
            <h4 style="margin-left: 40px;margin-bottom:30px">Коментарі</h4>
            @guest
                <div>
                    <p style="margin-left: 2.5vw;margin-top:-3vh;">Увійдіть щоб залишити коментар</p>
                </div>
            @endguest
            @auth
                <div style="margin-left: 15px;">
                    <form action="{{ route('recipe_comments.store', $recipe->recipe_id) }}" method="POST" style="display: flex; align-items: center;">
                        @csrf
                        <div style="display: flex; align-items: center; flex: 1;margin-bottom:15px;">
                            <img class="user-img" src="{{ asset(Auth::user()->img_path) }}" alt="" style="margin-right: 10px;">
                            <textarea rows="3" id="recipe_comment" name="recipe_comment" class="form-control @error('recipe_comment') is-invalid @enderror" placeholder="Введіть текст коментаря" style="width:50%;"></textarea>
                            <button class="btn btn-primary" type="submit" style="flex: 0;margin-left:0.5vw;">Коментувати</button>
                        </div>
                        @error('recipe_comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            @endauth
            <!-- коментар власний або увійдіть -->
            @foreach ($recipe->recipe_comments as $recipe_comment)
                <div class="recipe-comment" style="margin-left: 15px; margin-bottom: 2vh;">
                    <div class="user-info">
                        <a style="text-decoration: none;" href="{{ route('users.show_profile', $recipe_comment->user->user_id) }}">
                            <img class="user-img" src="{{ asset($recipe_comment->user->img_path) }}" alt="">
                        </a>
                        <a class="user-name" href="{{ route('users.show_profile', $recipe_comment->user->user_id) }}">
                            <strong>{{ $recipe_comment->user->nickname }}</strong>
                        </a>
                        @auth
                            @if (Auth::user()->user_id == $recipe_comment->user_id)
                                <div style="display: inline-block;">
                                    <li class="navitem dropdown user-menu-block">
                                        <a class="comment-menu" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <ul class="dropdown-menu">
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteCommentModal-{{ $recipe_comment->recipe_comment_id }}">Видалити</button>
                                        </ul>
                                    </li>
                                </div>
                                <div class="modal fade" id="deleteCommentModal-{{ $recipe_comment->recipe_comment_id }}" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Видалення Коментаря</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Видалити цей Коментар назавжди?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ні</button>
                                                <form id="form_delete-{{ $recipe_comment->recipe_comment_id }}"
                                                    action="{{ route('recipe_comments.destroy', [$recipe->recipe_id, $recipe_comment->recipe_comment_id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" id="delete-{{ $recipe_comment->recipe_comment_id }}"
                                                    class="btn btn-danger">Видалити
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <div class="comment-text">
                        {{ $recipe_comment->description }}
                    </div>
                </div>
            @endforeach
        </div>
        @endif
        @if (session('add_to_collection_error'))
        <div class="modal fade" id="addToCollectionErrorModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Помилка</h5>
                    </div>
                    <div class="modal-body">
                    {{ session('add_to_collection_error') }}
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                            $(document).ready(function() {
                                // Show the modal
                                $('#addToCollectionErrorModal').modal('show');

                                setTimeout(function() {
                                    $('#addToCollectionErrorModal').modal('hide');
                                }, 2000);
                            });
            });
        </script>
        @endif
@endsection