@extends('layout')
<link rel="stylesheet" href="{{ asset('css/recipe/overview.css') }}">
{{-- @php
    $submit_rating_url = route('');
@endphp --}}
@section('tab-title', 'Рецепт: ' . $recipe->name)
@section('page-content')
    <div class="main-info">
        <img src="{{ asset($recipe->img_path) }}" alt="Фото страви">
        <div class="text-entry">
            <h3>{{ $recipe->name }}</h3>
            <p>{{  $recipe->description }}</p>
        </div>
        <div class="ingredients">
            <h4>Інгрідієнти</h4>
            <table>
                <thead>
                    <th>Назва</th>
                    <th>Кількість одиниць</th>
                    <th>Одиниці виміру</th>
                </thead>
                <tbody>
                    @foreach ($recipe->recipe_ingredients as $recipe_ingredient)
                        <tr>
                            <td>{{ $recipe_ingredient->name }}</td>
                            <td>{{ $recipe_ingredient->amount }}</td>
                            <td>{{ $recipe_ingredient->unit }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--зробити коментар який пояснює скорочення в одиницях-->
        </div>
    </div>
    <div class="description">
        <h4>Кроки приготування</h4>
        @foreach ($recipe->recipe_steps as $recipe_step)
            <p class="recipe-step"><span class="recipe-step-number">{{ $recipe_step->ordinal_number }}.</span>{{ $recipe_step->description }}</p>
        @endforeach
    </div>
    <div class="rating-block">
        <form action="{{ route('recipes.show_post', $recipe->recipe_id) }}" method="POST" id="star-rating-form">
            @csrf
            <input type="radio" id="star1" name="recipe_rating" value="1" />
            <label for="star1" title="1 stars"></label>
            <input type="radio" id="star2" name="recipe_rating" value="2" />
            <label for="star2" title="2 stars"></label>
            <input type="radio" id="star3" name="recipe_rating" value="3" />
            <label for="star3" title="3 stars"></label>
            <input type="radio" id="star4" name="recipe_rating" value="4" />
            <label for="star4" title="4 stars"></label>
            <input type="radio" id="star5" name="recipe_rating" value="5" />
            <label for="star5" title="5 star"></label>
        </form>
    </div>
    <script>
        document.querySelectorAll('input[type=radio]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('star-rating-form').submit();
            });
        }); //зробити більш специфічною відносно радіобатонів
    </script>
    <div class="comment-section">
        <h4>Коментарі</h4>
        @guest
            <div>
                <p>Увійдіть щоб залишити коментар</p>
            </div>
        @endguest
        @auth
            <div>
                <form action="">
                    <input type="text" placeholder="Введіть текст коментаря">
                    <button type="submit">Залишити</button> <!--поміняти текст на картинку-->
                </form>
            </div>
        @endauth
        <!-- коментар власний або увійдіть -->
        @foreach ($recipe->recipe_comments as $recipe_comment)
            <div class="recipe-comment">
                <div class="user-info">
                    <a href="{{ route('users.show_profile', $recipe_comment->user->user_id) }}">
                        <img src="{{ asset($recipe_comment->user->img_path) }}" alt="">
                    </a>
                    <a href="{{ route('users.show_profile', $recipe_comment->user->user_id) }}">
                        {{ $recipe_comment->user->nickname }}
                    </a>
                </div>
                <div class="comment-text">
                    {{ $recipe_comment->description }}
                </div>
            </div>
        @endforeach
    </div>

   @if (isset($set_rating) && $set_rating == true)
    <div class="modal fade" id="ratingModal" tabindex="-1" arialabelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Оцінка Рецепту</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
                </div>
                <div class="modal-body">
                @if ($has_previous_rating == false)
                Ви оцінили цей рецепт на {{ $recipe_rating->value }} балів!
                @else
                Ви змінили свою думку і оцінили цей рецепт на {{ $recipe_rating->value }} балів!
                @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bsdismiss="modal">Ок</button>
                </div>
            </div>
        </div>
    </div>
   @endif
    <script>
        $(document).ready(function(){
            <?php
            if (isset($set_rating) && $set_rating == true) {
                echo "$('#ratingModal').modal('show');";
            }
            ?>
        });
    </script>
@endsection