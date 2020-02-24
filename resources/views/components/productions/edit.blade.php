<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.layouts.header')

    <body>

      @include('components.layouts.navbar')

      <div class= "container padding-top-15">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex">
              <h3>{{ $production->name }}</h3>
              <a href="{{ route('view_production', $production->id) }}" class="btn btn-dark px-4 ml-auto"><i class="fa fa-chevron-left mr-2"></i>Back</a>
            </div>

            <hr>
            <form action="{{ route('update_production', $production->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
						<div class="form-group row">
							<label class="col-md-2 col-form-label">Name</label>
							<div class="col-md-10">
                <input type="text" class="form-control" name="name" value="{{ $production->name }}" required>
							</div>
						</div>
            <div class="form-group row">
    					<label class="col-md-2 col-form-label">Recipe</label>
    					<div class="col-md-10">
    						<select class="form-control production_recipe_id" required name="recipe_id">
    							<option value="" selected="" disabled="">Recipe</option>
    							@foreach ($recipes as $recipe)
    							<option value="{{ $recipe->id }}" data-uom="{{ $recipe->unit_of_measure }}" data-quantity="{{ $recipe->quantity_left + $production->quantity }}" @if($production->recipe_name == $recipe->name) selected @endif>{{ $recipe->name }}</option>
    							@endforeach
    						</select>
    					</div>
    				</div>
						<div class="form-group row">
							<label class="col-md-2 col-form-label">Quantity</label>
							<div class="col-md-10">
    						<input type="number" class="form-control production_quantity" id="quantity" name="quantity" min="0" value="{{ $production->quantity }}" placeholder="Production quantity" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-2 col-form-label">Unit of measure</label>
							<div class="col-md-10">
                <div class="form-group">
                  <select class="form-control production_unit_of_measure" name="unit_of_measure">
                    @foreach ($units_of_measure as $unit_of_measure)
                    <option value="{{ $unit_of_measure }}" @if($production->unit_of_measure == $unit_of_measure) selected @else disabled @endif>{{ $unit_of_measure }}</option>
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
