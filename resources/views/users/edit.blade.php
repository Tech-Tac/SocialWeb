@extends('layouts.app')

@section('content')
	<div class="card">
		<div class="card-body">
			@if ($errors->any())
				<div class="alert alert-danger">
					Something went wrong, please try again.
				</div>
			@endif
			<form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<fieldset>
					<legend>Account Info</legend>
					<div class="mb-3">
						<label for="name" class="form-label"><i class="bi bi-person-fill"></i> Name</label>
						<input type="text" class="form-control" name="name" maxlength="255" required id="name" value="{{ Auth::user()->name }}">
					</div>
					<div class="mb-3">
						<label for="email" class="form-label"><i class="bi bi-envelope-at-fill"></i> Email address</label>
						<input type="email" class="form-control" name="email" maxlength="255" required id="email" value="{{ Auth::user()->email }}">
					</div>
					<div class="mb-3">
						<label for="about" class="form-label"><i class="bi bi-text-paragraph"></i> About</label>
						<textarea name="about" rows="3" id="about" class="form-control" maxlength="511">{{ Auth::user()->about }}</textarea>
					</div>
					<div class="mb-3">
						<label for="avatar" class="form-label"><i class="bi bi-person-circle"></i> Avatar</label>
						<div class="row">
							<div class="col-auto">
								<img src="{{ asset('images/' . (Auth::user()->avatar ?? 'person.svg')) }}" id="image" class="img-thumbnail" style="width:10em;height:10em;">
							</div>
							<div class="col">
								<input type="file" class="form-control" name="avatar" id="avatar" accept="image/*"><br>
								<input type="hidden" id="clear_avatar" name="clear_avatar" value="0">
								<button class="btn btn-danger" id="clear_btn" type="button"><i class="bi bi-x-lg"></i>Remove</button>
							</div>
						</div>
					</div>
				</fieldset>
				<hr>
				<fieldset>
					<legend>Change Password</legend>
					<div class="mb-3">
						<label for="old_password" class="form-label"><i class="bi bi-unlock"></i> Old password</label>
						<input type="password" class="form-control" name="old_password" id="old_password">
					</div>
					<div class="mb-3">
						<label for="password" class="form-label"><i class="bi bi-lock"></i> New password</label>
						<input type="password" class="form-control" name="password" id="password">
					</div>
					<div class="mb-3">
						<label for="password_confirmation" class="form-label"><i class="bi bi-lock-fill"></i> Confirm password</label>
						<input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
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
	<br>
	<div class="card">
		<div class="card-body">

			<fieldset>
				<legend>Danger Zone</legend>
				<button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm_modal">
					<i class="bi bi-person-x-fill"></i>
					Delete Account
				</button>
			</fieldset>

			<div class="modal fade" id="confirm_modal" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<h5 class="alert alert-warning">
								Are you sure about that?
							</h5>
							<p>
								Are you sure you want to delete your account?
								All your posts and comments are going to be deleted forever!
								There is no going back!
								You have been warned!
							</p>
						</div>
						<div class="modal-footer">
							<form action="{{ route('users.destroy', Auth::user()) }}" method="POST">
								@method('DELETE')
								@csrf
								<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
									<i class="bi bi-x-lg"></i>
									Never mind</button>
								<button type="submit" class="btn btn-danger">
									<i class="bi bi-trash-fill"></i>
									Delete Anyway</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script>
		window.addEventListener("load", () => {
			const preview = document.getElementById("image");
			const input = document.getElementById("avatar");
			const clearImage = document.getElementById('clear_avatar');

			input.addEventListener("input", () => {
				const file = input.files[0];

				if (file) {
					preview.src = URL.createObjectURL(file);
					clearImage.value = 0;
				}
			});

			document.getElementById("clear_btn").addEventListener("click", clear);

			function clear() {
				clearImage.value = 1;
				input.value = null;
				input.files = null;
				preview.src = "{{ asset('images/person.svg') }}";
			}
		});
	</script>
@endpush
