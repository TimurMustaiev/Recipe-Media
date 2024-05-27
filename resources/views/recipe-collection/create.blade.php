@extends('layout')
<link rel="stylesheet" href="{{ asset('css/recipe-collections-create.css') }}">
@section('tab-title', 'Створення Групи Рецептів')
@section('page-content')
<div class="container-fluid vw-100 vh-100 row align-items-center d-flex flex-column">
    <div class="text-center col-4">
        <h2>Створіть власну нову Групу Рецептів</h2>
    </div>
    <div class="form-container row-5 col-4">
        <form action="{{ route('recipe_collections.store', Auth::user()->user_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="name">Введіть назву Групи Рецептів</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Назва" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="img">Оберіть обкладинку Групи Рецептів</label>
            <input type="file" id="img" name="img" class="form-control @error('img') is-invalid @enderror">
            @error('img')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="description">Введіть короткий опис Групи Рецептів (необов'язково)</label>
            <br>
            <textarea id="description" name="description" class="form-control" placeholder="Опис Групи">{{ old('description') }}</textarea>
            <br>
            <label>Оберіть видимість Вашої Групи Рецептів</label>
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
            <button class="btn btn-primary" type="submit">Створити</button>
        </form>
    </div>
</div>
@endsection