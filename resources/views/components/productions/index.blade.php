<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.layouts.header')

    <body>

      @include('components.layouts.navbar')

      <div class="container padding-top-15">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex">
              <h3>Production</h3>
              <a href="#" class="btn btn-success px-4 ml-auto" data-toggle="modal" data-target="#add_production_modal"><i class="fa fa-plus mr-2"></i>Add</a>
            </div>

            @include('components.layouts.errors')

            @if (!$productions->isEmpty())
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Recipe name</th>
                  <th scope="col">Quantity</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($productions as $production)
                  <tr>
                    <td>
                      <a href="{{ route('view_production', $production->id) }}">
                      {{ $production->name }}
                      </a>
                    </td>
                    <td>{{ $production->recipe_name }}</td>
                    <td>{{ $production->quantity . '' . $production->unit_of_measure }}</td>
                    <td class="text-right">
                      <a class="btn btn-sm btn-danger" href="{{ route('delete_production', $production->id) }}"
                         onclick="return confirm('Are you sure you want to delete production {{ $production->name }}?')">
                         <i class="fa-fw fa fa-times"></i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
            {{ $productions->links() }}
            @endif
          </div>
        </div>
      </div>
    </body>

    @include('components.productions.modal.add')

    @include('components.layouts.footer')

</html>
