<!-- Modal -->
<div class="modal fade" id="add_production_modal" tabindex="-1" role="dialog" aria-labelledby="add_production_modal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add new production</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('save_production') }}" method="POST" enctype="multipart/form-data">
      @csrf
			<div class="modal-body">
				<div class="form-group row">
					<label for="name" class="col-md-2 col-form-label">Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" id="name" name="name" value="" placeholder="Production name" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-2 col-form-label">Recipe</label>
					<div class="col-md-10">
						<select class="form-control production_recipe_id" required name="recipe_id">
							<option value="" selected="" disabled="">Production</option>
							@foreach ($recipes as $recipe)
							<option value="{{ $recipe->id }}" data-uom="{{ $recipe->unit_of_measure }}" data-quantity="{{ $recipe->quantity }}">{{ $recipe->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="quantity" class="col-md-2 col-form-label">Quantity</label>
					<div class="col-md-10">
						<input type="number" class="form-control production_quantity" id="quantity" name="quantity" min="0" value="" placeholder="Production quantity" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-2 col-form-label">UOM</label>
					<div class="col-md-10">
							<select class="form-control production_unit_of_measure" name="unit_of_measure" required>
								<option value="" selected="" disabled="">Unit of measure</option>
                @foreach($units_of_measure as $unit_of_measure)
								<option value="{{ $unit_of_measure }}">{{ $unit_of_measure }}</option>
                @endforeach
							</select>
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
