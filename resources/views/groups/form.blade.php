@extends('layouts.app')

@section('content')
	<div class="card">
		<div class="card-body">
			@if ($errors->any())
				<div class="alert alert-danger">
					Something went wrong, please try again.
				</div>
			@endif
			<form action="{{ isset($group) ? route('groups.update', $group) : route('groups.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				@if (isset($group))
					@method('PUT')
				@endif
				<fieldset>
					<legend>Group Info</legend>
					<div class="mb-3">
						<label for="name" class="form-label"><i class="bi bi-bookmark-fill"></i> Name</label>
						<input type="text" class="form-control" name="name" maxlength="255" required value="{{ $group->name ?? '' }}">
					</div>
					<div class="mb-3">
						<label for="description" class="form-label"><i class="bi bi-text-paragraph"></i> Description</label>
						<textarea name="description" id="description" class="form-control" rows="3" maxlength="1043">{{ $group->description ?? '' }}</textarea>
					</div>
					<div class="mb-3">
						<label for="icon" class="form-label"><i class="bi bi-image"></i> Icon</label>
						<div class="row">
							<div class="col-auto">
								<img src="{{ isset($group) ? asset('images/' . ($group->icon ?? 'group.svg')) : asset('images/group.svg') }}" id="image" class="img-thumbnail"
									style="width:10em;height:10em;">
							</div>
							<div class="col">
								<input type="file" class="form-control" name="icon" id="icon" accept="image/*"><br>
								<input type="hidden" id="clear_icon" name="clear_icon" value="0">
								<button class="btn btn-danger" id="clear_btn" type="button"><i class="bi bi-x-lg"></i>Remove</button>
							</div>
						</div>
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
@endsection
@push('scripts')
	<script>
		window.addEventListener("load", () => {
			const preview = document.getElementById("image");
			const input = document.getElementById("icon");
			const clearImage = document.getElementById('clear_icon');

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
				preview.src = "{{ asset('images/group.svg') }}";
			}
		});
	</script>
@endpush
