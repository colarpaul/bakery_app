<!-- Modal -->
<div class="modal fade" id="add_ingredient_modal" tabindex="-1" role="dialog" aria-labelledby="add_ingredient_modal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add new ingredient</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('save_ingredient') }}" method="POST">
      @csrf
			<div class="modal-body">
				<div class="form-group row">
					<label for="name" class="col-md-2 col-form-label">Name</label>
					<div class="col-md-10">
						<input type="text" class="form-control" id="name" name="name" value="" placeholder="Ingredient name" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="quantity" class="col-md-2 col-form-label">Quantity</label>
					<div class="col-md-10">
						<input type="number" class="form-control" id="quantity" name="quantity" min="0" value="" placeholder="Ingredient quantity" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-2 col-form-label">Ingredients</label>
					<div class="col-md-10">
							<select class="form-control" name="unit_of_measure" required>
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
