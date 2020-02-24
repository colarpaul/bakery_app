<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.layouts.header')

    <body>

      @include('components.layouts.navbar')

      <div class= "container padding-top-15">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex">
              <h3>{{ $ingredient->name }}</h3>
              <a href="{{ route('view_ingredient', $ingredient->id) }}" class="btn btn-dark px-4 ml-auto"><i class="fa fa-chevron-left mr-2"></i>Back</a>
            </div>

            <hr>
            <form action="{{ route('update_ingredient', $ingredient->id) }}" method="POST">
            @csrf
						<div class="form-group row">
							<label class="col-md-2 col-form-label">Name</label>
							<div class="col-md-10">
                <input type="text" class="form-control" name="name" value="{{ $ingredient->name }}" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-2 col-form-label">Quantity</label>
							<div class="col-md-10">
                <input type="text" class="form-control" name="quantity" value="{{ $ingredient->quantity }}" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-2 col-form-label">Unit of measure</label>
							<div class="col-md-10">
                <div class="form-group">
                  <select class="form-control" name="unit_of_measure">
                    @foreach ($units_of_measure as $unit_of_measure)
                    <option @if($ingredient->unit_of_measure == $unit_of_measure) selected @endif>{{ $unit_of_measure }}</option>
                    @endforeach
                  </select>
                </div>
							</div>
						</div>
						<hr>
						<div class="form-group row">
							<label class="col-md-2 col-form-label">&nbsp;</label>
							<div class="col-md-10">
								<button type="submit" class="btn btn-primary px-4"><i class="fa fa-pencil mr-2"></i>Update</a>
							</div>
						</div>
            </form>
          </div>
        </div>
      </div>
    </body>

    @include('components.layouts.footer')

</html>
