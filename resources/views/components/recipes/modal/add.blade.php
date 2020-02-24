<!-- Modal -->
<div class="modal fade" id="add_recipe_modal" tabindex="-1" role="dialog" aria-labelledby="add_recipe_modal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add new recipe</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('save_recipe') }}" method="POST" enctype="multipart/form-data">
      @csrf
			<div class="modal-body">
				<div class="form-group row">
					<label for="name" class="col-md-2 col-form-label">Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" id="name" name="recipe_name" value="" placeholder="Recipe name" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="quantity" class="col-md-2 col-form-label">Quantity</label>
					<div class="col-md-10">
						<input type="number" class="form-control" id="quantity" name="recipe_quantity" min="0" value="" placeholder="Recipe quantity" required>
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
				      aria-describedby="inputGroupFileAddon01" name="image_url" required>
				    <label class="custom-file-label" for="inputGroupFile01">Upload image</label>
				  </div>
				</div>
				</div>
				<div class="form-group row">
					<label class="col-md-2 col-form-label">UOM</label>
					<div class="col-md-10">
							<select class="form-control" name="recipe_unit_of_measure" required>
								<option value="" selected="" disabled="">Unit of measure</option>
                @foreach($units_of_measure as $unit_of_measure)
								<option value="{{ $unit_of_measure }}">{{ $unit_of_measure }}</option>
                @endforeach
							</select>
					</div>
				</div>
        <div class="form-group row">
				<label class="col-md-2 col-form-label">Ingredients</label>
				<div class="col-md-10">
					<div class="row">
						<div class="col">
							<div class="d-flex align-items-center mb-1 ingredient-row-to-clone">
								<div class="row">
									<div class="col-sm-6">
										<input type="text" class="form-control ingredient_name" value="" placeholder="Ingredient name" name="ingredients[0][name]" required>
									</div>
									<div class="col-sm-3">
										<input type="number" class="form-control ingredient_quantity" min="0" value="" placeholder="Quantity" name="ingredients[0][quantity]" required>
									</div>
									<div class="col-sm-3">
										<select class="form-control ingredient_unit_of_measure" required name="ingredients[0][unit_of_measure]">
                      <option value="" selected="" disabled="">Unit of measure</option>
                      @foreach($units_of_measure as $unit_of_measure)
      								<option value="{{ $unit_of_measure }}">{{ $unit_of_measure }}</option>
                      @endforeach
										</select>
									</div>
								</div>
								<a class="btn btn-sm btn-danger ml-2 btn-remove-ingredient-row" href="#"><i class="fa-fw fa fa-times"></i></a>
							</div>
							<div class="mt-3">
								<a href="#" class="btn btn-success ml-auto btn-add-ingredient-row"><i class="fa fa-plus mr-2"></i>Add more ingredients to recipe</a>
							</div>
						</div>

					</div>
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light px-3" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-success px-5">Save</button>
			</div>
    </form>
		</div>
	</div>
</div>
