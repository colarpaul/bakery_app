<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.layouts.header')

    <body>

      @include('components.layouts.navbar')

      <div class="container padding-top-15">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex">
              <h3>Recipes</h3>
              <a href="#" class="btn btn-success px-4 ml-auto" data-toggle="modal" data-target="#add_recipe_modal"><i class="fa fa-plus mr-2"></i>Add</a>
            </div>

            @include('components.layouts.errors')

            @if (!$recipes->isEmpty())
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">Name</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Ingredients</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($recipes as $recipe)
                  <tr>
                    <td>
                      <img src="{{ Storage::url($recipe->image_url) }}" width="50" height="50">
                    </td>
                    <td>
                      <a href="{{ route('view_recipe', $recipe->id) }}">
                      {{ $recipe->name }}
                      </a>
                    </td>
                    <td>{{ $recipe->quantity . '' . $recipe->unit_of_measure }}</td>
                    <td>{{ $recipe->total_ingredients }}</td>
                    <td class="text-right">
                      <a class="btn btn-sm btn-danger" href="{{ route('delete_recipe', $recipe->id) }}"
                         onclick="return confirm('Are you sure you want to delete recipe {{ $recipe->name }}?')">
                         <i class="fa-fw fa fa-times"></i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
            {{ $recipes->links() }}
            @endif
          </div>
        </div>
      </div>
    </body>

    @include('components.recipes.modal.add')

    @include('components.layouts.footer')

</html>
