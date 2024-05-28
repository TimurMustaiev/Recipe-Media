@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe/create_step_two.css') }}">
@section('tab-title', 'Створення рецепту')
@section('page-content')
<div class="container-fluid vw-100 vh-100 row align-items-center d-flex flex-column">
    <div class="text-center col-4">
        <h2>Створіть новий вегетаріанський шедевр!</h2>
        <p>Крок 2</p>
    </div>
    <div class="form-container row-5 col-4">
        <form action="{{ route('recipes.store_step_two') }}" method="POST">
            @csrf
            <div class="main-container">
                <div class="inputs">
                    <label for="recipe_ingredient">Введіть Інгрідієнт</label>
                    <input id="recipe_ingredient" name="recipe_ingredient" class="form-control" type="text" placeholder="Інгрідієнт">
                    <label for="amount">Введіть кількість продукту</label>
                    <input id="amount" name="amount" class="form-control" type="number" min="0">
                    <label for="unit">Оберіть одиницю вимірювання</label>
                    <select id="unit" name="unit" class="form-select">
                        <option value="г">Грам</option>
                        <option value="кг">Кілограм</option>
                        <option value="мл">Мілілітр</option>
                        <option value="л">Літр</option>
                        <option value="ст.л.">Столова Ложка</option>
                        <option value="ч.л.">Чайна Ложка</option>
                        <option value="шт.">Штука</option>
                    </select>
                </div>
                <div id="entered_ingredients" class="entered_ingredients">
                    @error('ingredients_array')
                        {{ $message }}
                    @enderror
                </div>

                <input type="hidden" id="ingredients_array" name="ingredients_array" value="">
            </div>
            <br>
            <div class="button-container">
                <button type="button" onclick="addIngredient()">Додати</button>
                <button type="submit" onclick="submitForm()">Далі</button>
            </div>
        </form>
    </div>
</div>
<script>
    var recipeIngredients = [];

    function addIngredient() {
        var nameInput = document.getElementById('recipe_ingredient');
        var amountInput = document.getElementById('amount');
        var unitInput = document.getElementById('unit');

        var name = nameInput.value;
        var amount = amountInput.value;
        var unit = unitInput.value;

        if (name && amount && unit) {
            var recipeIngredient = {
                name: name,
                amount: amount,
                unit: unit
            };

            recipeIngredients.push(recipeIngredient);
        }

        var enteredIngredients = document.getElementById('entered_ingredients');
        var ingredientContainer = document.createElement('div');
        ingredientContainer.classList.add('new-ingredient-field');
        ingredientContainer.innerHTML = name + ' ' + amount + ' ' + unit;
        enteredIngredients.appendChild(ingredientContainer);
        enteredIngredients.appendChild(document.createElement('br'));

        nameInput.value = '';
        amountInput.value = '';
        unitInput.selectedIndex = 0;
    }

    function submitForm() {
        document.getElementById('ingredients_array').value = JSON.stringify(recipeIngredients);
    }
</script>
@endsection