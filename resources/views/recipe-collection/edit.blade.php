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
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Назва" value="{{ old('name') ? old('name') : $recipe_collection->name }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="img">Оберіть нову обкладинку Групи Рецептів</label>
            <input type="file" id="img" name="img" class="form-control @error('img') is-invalid @enderror">
            @error('img')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="description">Введіть новий короткий опис Групи Рецептів (необов'язково)</label>
            <br>
            <textarea id="description" name="description" class="form-control" placeholder="Опис Групи">{{ old('description') ? old('description') : $recipe_collection->description }}</textarea>
            <br>
            <label>Оберіть нову видимість Вашої Групи Рецептів</label>
            <br>
            <input type="radio" id="public_access_modificator" name="access_modificator" class="form-check-input" value="публічна">
            <label for="public_access_modificator">публічна (бачитимуть всі)</label>
            <br>
            <input type="radio" id="private_access_modificator" name="access_modificator" class="form-check-input" value="публічна">
            <label for="private_access_modificator">приватна (бачитимете лише Ви)</label>
            @error('access_modificator')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <br>
            <button class="btn btn-primary" type="submit">Зберегти зміни</button>
        </form>
    </div>
</div>
@endsection