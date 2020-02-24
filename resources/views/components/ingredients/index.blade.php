<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.layouts.header')

    <body>

      @include('components.layouts.navbar')

      <div class="container padding-top-15">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex">
              <h3>Ingredients</h3>
              <a href="#" class="btn btn-success px-4 ml-auto" data-toggle="modal" data-target="#add_ingredient_modal"><i class="fa fa-plus mr-2"></i>Add</a>
            </div>

            @include('components.layouts.errors')

            @if (!$ingredients->isEmpty())
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Quantity</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($ingredients as $ingredient)
                  <tr>
                    <td>
                      <a href="{{ route('view_ingredient', $ingredient->id) }}">
                      {{ $ingredient->name }}
                      </a>
                    </td>
                    <td>{{ $ingredient->quantity . '' . $ingredient->unit_of_measure }}</td>
                    <td class="text-right">
                      <a class="btn btn-sm btn-danger" href="{{ route('delete_ingredient', $ingredient->id) }}"
                         onclick="return confirm('Are you sure you want to delete ingredient {{ $ingredient->name }}?')">
                         <i class="fa-fw fa fa-times"></i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
            {{ $ingredients->links() }}
            @endif
          </div>
        </div>
      </div>
    </body>

    @include('components.ingredients.modal.add')

    @include('components.layouts.footer')

</html>
