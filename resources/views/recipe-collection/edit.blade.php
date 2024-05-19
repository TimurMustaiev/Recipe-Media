@extends('layout')

@section('tab-title', 'Редагування Групи Рецептів')
@section('page-content')
<div class="container-fluid vw-100 vh-100 row align-items-center d-flex flex-column">
    <div class="text-center col-4">
        <h2>Редагуйте Групу Рецептів</h2>
    </div>
    <div class="form-container row-5 col-4">
        <form action="{{ route('recipe_collections.update', [Auth::user()->user_id, $recipe_collection->recipe_collection_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <label for="name">Введіть нову назву Групи Рецептів</label>
            <input type="text" id="name" name="name" placeholder="Назва" value="{{ $recipe_collection->name }}">
            <label for="img">Оберіть нову обкладинку Групи Рецептів</label>
            <input type="file" id="img" name="img" accept="image/jpeg, image/png, image/jpg, image/bmp">
            <label for="description">Введіть короткий опис Групи Рецептів (необов'язково)</label>
            <br>
            <textarea id="description" name="description" placeholder="Опис Групи">
              {{ $recipe_collection->description }}
            </textarea>
            <br>
            <label>Оберіть нову видимість Вашої Групи Рецептів</label>
            <br>
            <input type="radio" id="public_access_modificator" name="access_modificator" value="публічна">
            <label for="public_access_modificator">публічна (бачитимуть всі)</label>
            <br>
            <input type="radio" id="private_access_modificator" name="access_modificator" value="публічна">
            <label for="private_access_modificator">приватна (бачитимете лише Ви)</label>
            <br>
            <button type="submit">Зберегти зміни</button>
        </form>
    </div>
</div>
@endsection