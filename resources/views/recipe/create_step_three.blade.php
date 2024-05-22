@extends('layout')

@section('tab-title', 'Створення рецепту')
@section('page-content')
<div class="container-fluid vw-100 vh-100 row align-items-center d-flex flex-column">
    <div class="text-center col-4">
        <h2>Створіть новий вегетаріанський шедевр!</h2>
        <p>Крок 3</p>
    </div>
    <div class="form-container row-5 col-4">
        <form action="" method="POST">
            @csrf
            <label for="recipe_step">Опишіть Крок</label>
            <textarea id="recipe_step" name="recipe_step">
            </textarea>
            <button type="button" onclick="">Додати</button>
            <button type="submit">Далі</button>
        </form>
    </div>
</div>
@endsection