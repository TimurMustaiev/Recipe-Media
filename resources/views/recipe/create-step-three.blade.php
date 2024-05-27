@extends('layout')

@section('tab-title', 'Створення рецепту')
@section('page-content')
<div class="container-fluid vw-100 vh-100 row align-items-center d-flex flex-column">
    <div class="text-center col-4">
        <h2>Створіть новий вегетаріанський шедевр!</h2>
        <p>Крок 3</p>
    </div>
    <div class="form-container row-5 col-4">
        <form action="{{ route('recipes.store_step_three') }}" method="POST">
            @csrf
            <div>
                <label for="description">Опишіть Крок Рецепту</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>
            <div id="entered_steps" class="entered_steps">
                @error('steps_array')
                    {{ $message }}
                @enderror
            </div>

            <input type="hidden" id="steps_array" name="steps_array" value="">
            <button type="button" onclick="addStep()">Додати</button>
            <button type="submit" onclick="submitForm()">Створити Рецепт</button>
        </form>
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
        stepContainer.innerHTML = `${stepCount} - ${description.substring(0, 20)}`;
        if(description.length >= 20) {
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