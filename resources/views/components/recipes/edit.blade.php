<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.layouts.header')

    <body>

      @include('components.layouts.navbar')

      <div class= "container padding-top-15">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex">
              <h3>{{ $recipe->name }}</h3>
              <a href="{{ route('view_recipe', $recipe->id) }}" class="btn btn-dark px-4 ml-auto"><i class="fa fa-chevron-left mr-2"></i>Back</a>
            </div>

            @include('components.layouts.errors')

            <hr>
            <form action="{{ route('update_recipe', $recipe->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
						<div class="form-group row">
							<label class="col-md-2 col-form-label">Name</label>
							<div class="col-md-10">
                <input type="text" class="form-control" name="recipe_name" value="{{ $recipe->name }}" required>
							</div>
						</div>
            <div class="form-group row">
							<label class="col-md-2 col-form-label">Quantity</label>
							<div class="col-md-10">
    						<input type="number"
                       class="form-control production_quantity"
                       id="recipe_quantity"
                       name="recipe_quantity"
                       min="0"
                       value="{{ $recipe->quantity }}"
                       placeholder="Recipe quantity"
                       required>
							</div>
						</div>
            <div class="form-group row">
    					<label for="image" class="col-md-2 col-form-label">Image</label>
    					<div class="input-group col-md-10">
    				  <div class="input-group-prepend">
    				    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
    				  </div>
    				  <div class="custom-file">
    				    <input type="file" class="custom-file-input" id="image_url"
    				      aria-describedby="inputGroupFileAddon01" name="image_url" value="{{ $recipe->image_url }}">
    				    <label class="custom-file-label" for="inputGroupFile01">Upload image</label>
    				  </div>
    				</div>
    				</div>
						<div class="form-group row">
							<label class="col-md-2 col-form-label">Unit of measure</label>
							<div class="col-md-10">
                <div class="form-group">
                  <select class="form-control" name="recipe_unit_of_measure">
                    @foreach ($units_of_measure as $unit_of_measure)
                    <option @if($recipe->unit_of_measure == $unit_of_measure) selected @endif>{{ $unit_of_measure }}</option>
                    @endforeach
                  </select>
                </div>
							</div>
						</div>
            <div class="form-group row">
      				<label class="col-md-2 col-form-label">Ingredients</label>
      				<div class="col-md-10">
      					<div class="row">
      						<div class="col">
                    @foreach($recipe->ingredients as $key => $ingredient)
      							<div class="d-flex align-items-center mb-1 ingredient-row-to-clone">
      								<div class="row">
      									<div class="col-sm-6">
      										<input type="text" class="form-control ingredient_name" value="{{ $ingredient->name }}" placeholder="Ingredient name" name="ingredients[{{ $key }}][name]" required>
      									</div>
      									<div class="col-sm-3">
      										<input type="number" class="form-control ingredient_quantity" min="0" value="{{ $ingredient->pivot->ingredient_quantity }}" placeholder="Quantity" name="ingredients[{{ $key }}][quantity]" required>
      									</div>
      									<div class="col-sm-3">
      										<select class="form-control ingredient_unit_of_measure" required name="ingredients[{{ $key }}][unit_of_measure]">
                            <option value="" selected="" disabled="">Unit of measure</option>
                            @foreach($units_of_measure as $unit_of_measure)
            								<option @if($ingredient->unit_of_measure == $unit_of_measure) selected @endif>{{ $unit_of_measure }}</option>
                            @endforeach
      										</select>
      									</div>
      								</div>
      								<a class="btn btn-sm btn-danger ml-2 btn-remove-ingredient-row" href="#"><i class="fa-fw fa fa-times"></i></a>
      							</div>
                    @endforeach
      							<div class="mt-3">
      								<a href="#" class="btn btn-success ml-auto btn-add-ingredient-row"><i class="fa fa-plus mr-2"></i>Add more ingredients to recipe</a>
      							</div>
      						</div>
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
