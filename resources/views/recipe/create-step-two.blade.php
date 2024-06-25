@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe/create_step_two.css') }}">
@section('tab-title', 'Створення рецепту: етап 2')
@section('page-content')
<div class="text-center">
    <h2>Створіть новий вегетаріанський Рецепт</h2>
</div>
<div class="form-container">
    <div class="card col-5">
        <div class="card-header">Етап 2: Інгредієнти рецепту</div>
        <div class="card-body">
            <form action="{{ route('recipes.store_step_two') }}" method="POST">
                @csrf
                <div class="main-container">
                    <div class="inputs">
                        <label for="recipe_ingredient">Інгредієнт</label>
                        <input id="recipe_ingredient" name="recipe_ingredient" class="form-control" type="text" placeholder="Інгредієнт">
                        <label for="amount">Кількість Інгредієнту</label>
                        <input id="amount" name="amount" class="form-control" type="number" min="0" step="any">
                        <label for="unit">Одиниця вимірювання кількості</label>
                        <select id="unit" name="unit" class="form-select">
                            <option value="г.">Грам</option>
                            <option value="кг.">Кілограм</option>
                            <option value="мл.">Мілілітр</option>
                            <option value="л.">Літр</option>
                            <option value="ст.л.">Столова Ложка</option>
                            <option value="ч.л.">Чайна Ложка</option>
                            <option value="шт.">Штука</option>
                        </select>
                    </div>
                    <input type="hidden" id="ingredients_array" name="ingredients_array" value="">
                    <button class="mt-3 btn btn-dark" type="button" onclick="addIngredient()" style="width:30%;">Додати</button>
                </div>
                <div id="entered_ingredients" class="mt-2 entered_ingredients">
                </div>
                <div class="error" style="color: red;margin-top:3vh;">
                    @error('ingredients_array')
                    {{ $message }}
                    @enderror
                </div>
                <div class="button-container">
                    <a class="btn btn-secondary" href="{{ route('recipes.create_step_one') }}" style="float: left;width: 13%;">Назад</a>
                    <button class="btn btn-primary" type="submit" onclick="submitForm()" style="float: right;width: 13%;">Далі</button>
                </div>
            </form>
        </div>
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