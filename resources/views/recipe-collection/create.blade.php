@extends('layouts.main')
<link rel="stylesheet" href="{{ asset('css/recipe-collection/create_edit.css') }}">
@section('tab-title', 'Створення Групи Рецептів')
@section('page-content')
<div class="text-center mb-2">
    <h2>Створіть нову Збірку Рецептів</h2>
</div>
<div class="form-container">
    <div class="card col-5">
        <div class="card-header">Збірка Рецептів</div>
        <div class="card-body">
            <form action="{{ route('recipe_collections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="name">Назва</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Назва" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label for="img">Обкладинка</label>
                <input type="file" id="img" name="img" class="mt-2 form-control @error('img') is-invalid @enderror">
                @error('img')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label class="mt-2" style="width:100%;text-align:left;">Видимість</label>
                <select id="access_modificator" name="access_modificator" class="form-select @error('access_modificator') is-invalid @enderror">
                    <option value="публічна">публічна (бачитимуть всі)</option>
                    <option value="приватна">приватна (бачитимете лише Ви)</option>
                </select>
                @error('access_modificator')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label class="mt-2" for="description">Короткий опис (необов'язково)</label>
                <textarea rows="5" id="description" name="description" class="form-control" placeholder="Опис Групи">{{ old('description') }}</textarea>
                <button id="submit-button" class="mt-4 btn btn-primary" type="submit">Створити</button>
            </form>
        </div>
    </div>
</div>
@endsection