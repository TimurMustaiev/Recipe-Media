<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('tab-title', 'Vegipe')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>
<body>
  <div class="container-fluid vw-100 min-vh-100">
    <header class="row">
      <div class="col-3 main-link">
        <a href="{{ route('main_page') }}">Головна</a>
      </div>
      <div class="col-7 search-container" role="search">
        <form action="{{ route('recipes.search') }}" class="search-form">
          <input type="search" id="recipe_name" class="form-control" placeholder="Знайдіть відмінний рецепт!" aria-label="Search" aria-describedby="search-addon">
          <button class="btn btn-primary search-btn" type="button">
            <i class="fas fa-search"></i> <!-- Font Awesome search icon -->
          </button>
        </form>
      </div>
      <div class="col-2 user">
        @guest
          <a href="{{ route('users.log_in') }}">Увійти</a>
        @endguest
        @auth
          <a href="{{ route('users.show_profile', Auth::user()->user_id) }}">
            <img class="user-picture" src="{{ asset(Auth::user()->img_path) }}">
          </a>
          <li class="navitem dropdown user-menu-block">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->nickname }}</a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('users.show_profile', Auth::user()->user_id) }}">Профіль</a></li>
              <li><a href="{{ route('recipes.create_step_one') }}">Створити рецепт</a></li>
              <li><a href="{{ route('users.log_out') }}">Вийти</a></li>
            </ul>
          </li>
        @endauth
      </div>
    </header>
    <div class="row content">
      @yield('page-content')
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>