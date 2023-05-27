@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="card">
					<div class="card-body">
						@if ($errors->any())
							<div class="alert alert-danger">
								Something went wrong, please try again.
							</div>
						@endif
						<form action="{{ route('groups.store') }}" method="POST">
							@csrf
							<fieldset>
								<legend>Group Info</legend>
								<div class="mb-3">
									<label for="name" class="form-label"><i class="bi bi-bookmark-fill"></i> Name</label>
									<input type="text" class="form-control" name="name" maxlength="255" required id="name">
								</div>
								<div class="mb-3">
									<label for="description" class="form-label"><i class="bi bi-text-paragraph"></i> Description</label>
									<textarea name="description" id="description" class="form-control" maxlength="1043"></textarea>
								</div>
							</fieldset>
							<div class="text-center">
								<button type="submit" class="btn btn-success">
									<i class="bi bi-check-lg"></i>
									Submit
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
