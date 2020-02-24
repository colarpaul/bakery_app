<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.layouts.header')

    <body>

      @include('components.layouts.navbar')

      <div class= "container padding-top-15">
        <div class="card">
						<div class="card-body">
							<div class="card-title d-flex align-items-center">
								<h1 class="h3">{{ $production->name }}</h1>
								<a href="{{ route('view_productions') }}" class="btn btn-dark px-4 ml-auto"><i class="fa fa-chevron-left mr-2"></i>Back</a>
							</div>
							<hr>
							<form class="pt-2">
								<div class="form-group row">
									<label class="col-md-2 col-form-label">Name</label>
									<div class="col-md-10">
										<div class="form-control-plaintext bg-light px-3">{{ $production->name }}</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 col-form-label">Recipe</label>
									<div class="col-md-10">
										<div class="form-control-plaintext bg-light px-3">{{ $production->recipe_name }}</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 col-form-label">Quantity</label>
									<div class="col-md-10">
										<div class="form-control-plaintext bg-light px-3">{{ $production->quantity }}</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 col-form-label">Unit of measure</label>
									<div class="col-md-10">
										<div class="form-control-plaintext bg-light px-3">{{ $production->unit_of_measure }}</div>
									</div>
								</div>
								<hr>
								<div class="form-group row">
									<label class="col-md-2 col-form-label">&nbsp;</label>
									<div class="col-md-10">
										<a href="{{ route('edit_production', $production->id) }}" class="btn btn-success px-4"><i class="fa fa-pencil mr-2"></i>Edit</a>
									</div>
								</div>

							</form>
						</div>
					</div>
      </div>
    </body>

    @include('components.layouts.footer')

</html>
