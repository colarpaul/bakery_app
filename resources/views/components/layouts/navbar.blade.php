<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">BakeryApp</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item @if(Route::current()->getName() == 'view_productions') active @endif">
            <a class="nav-link" href="{{ route('view_productions') }}"> Production <span class="sr-only"></span></a>
        </li>
        <li class="nav-item @if(Route::current()->getName() == 'view_recipes') active @endif">
          <a class="nav-link" href="{{ route('view_recipes') }}"> Recipes <span class="sr-only"></span></a>
        </li>
        <li class="nav-item @if(Route::current()->getName() == 'view_ingredients') active @endif">
          <a class="nav-link" href="{{ route('view_ingredients') }}"> Ingredients <span class="sr-only"></span></a>
        </li>

      </ul>
    </div>
  </div>
</nav>
