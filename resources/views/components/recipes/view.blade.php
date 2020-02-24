<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('components.layouts.header')

    <body>

      @include('components.layouts.navbar')

      <div class= "container padding-top-15">
        <div class="card">
						<div class="card-body">
							<div class="card-title d-flex align-items-center">
                <img src="{{ Storage::url($recipe['image_url']) }}" width="50" height="50">
								<h1 class="h3">{{ $recipe['name'] }}</h1>
								<a href="{{ route('view_recipes') }}" class="btn btn-dark px-4 ml-auto"><i class="fa fa-chevron-left mr-2"></i>Back</a>
							</div>
							<hr>
							<form class="pt-2">
								<div class="form-group row">
									<label class="col-md-2 col-form-label">Name</label>
									<div class="col-md-10">
										<div class="form-control-plaintext bg-light px-3">{{ $recipe['name'] }}</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 col-form-label">Quantity</label>
									<div class="col-md-10">
										<div class="form-control-plaintext bg-light px-3">{{ $recipe['quantity'] }}</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 col-form-label">Unit of measure</label>
									<div class="col-md-10">
										<div class="form-control-plaintext bg-light px-3">{{ $recipe['unit_of_measure'] }}</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 col-form-label">Ingredients</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col">
                        @foreach ($recipe['ingredients'] as $ingredient)
												<div class="form-control-plaintext bg-light px-3 mb-1">{{ $ingredient['name'] }} - {{ $ingredient['quantity'] }} {{ $ingredient['unit_of_measure'] }}</div>
                        @endforeach
											</div>

										</div>
									</div>
								</div>

								<hr>
								<div class="form-group row">
									<label class="col-md-2 col-form-label">&nbsp;</label>
									<div class="col-md-10">
										<a href="{{ route('edit_recipe', $recipe['id']) }}" class="btn btn-success px-4"><i class="fa fa-pencil mr-2"></i>Edit</a>
									</div>
								</div>

							</form>
						</div>
					</div>
      </div>
    </body>

    @include('components.layouts.footer')

</html>
