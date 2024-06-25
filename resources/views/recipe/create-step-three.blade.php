@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe/create_step_three.css') }}">
@section('tab-title', 'Створення рецепту: етап 3')
@section('page-content')
<div class="text-center">
    <h2>Створіть новий вегетаріанський Рецепт</h2>
</div>
<div class="mb-5 form-container">
    <div class="card col-5">
        <div class="card-header">Етап 3: Кроки Рецепту</div>
        <div class="card-body">
            <form action="{{ route('recipes.store_step_three') }}" method="POST">
                @csrf
                <div class="main-container">
                    <label for="description">Опис</label>
                    <textarea rows="6" id="description" name="description" class="form-control"></textarea>
                    <button class="mt-3 btn btn-dark" type="button" onclick="addStep()" style="width:30%;">Додати</button>
                </div>
                <div id="entered_steps" class="entered_steps">
                </div>
                <div class="error" style="color: red;margin-top:3vh;">
                    @error('steps_array')
                    {{ $message }}
                    @enderror
                </div>
                <div class="button-container">
                    <a class="btn btn-secondary" href="{{ route('recipes.create_step_two') }}" style="float: left;width: 13%;">Назад</a>
                    <button class="btn btn-success" type="submit" onclick="submitForm()" style="float: right;width: 28%;">Створити Рецепт</button>
                </div>
                <input type="hidden" id="steps_array" name="steps_array">
            </form>
        </div>
    </div>
</div>
<script>
    var recipeSteps = [];
    var stepCount = 1;

    function addStep() {
        var descriptionInput = document.getElementById('description');

        var description = descriptionInput.value;

        if (description) {
            var recipeStep = {
                ordinalNumber: stepCount,
                description: description
            };

            recipeSteps.push(recipeStep);
        }

        var enteredSteps = document.getElementById('entered_steps');
        var stepContainer = document.createElement('div');
        stepContainer.classList.add('new-step-field');
        stepContainer.innerHTML = `${stepCount} - ${description.substring(0, 50)}`;
        if(description.length >= 50) {
            stepContainer.innerHTML += '...';
        }

        enteredSteps.appendChild(stepContainer);
        enteredSteps.appendChild(document.createElement('br'));

        stepCount++;
        descriptionInput.value = '';
    }

    function submitForm() {
        document.getElementById('steps_array').value = JSON.stringify(recipeSteps);
    }
</script>
@endsection