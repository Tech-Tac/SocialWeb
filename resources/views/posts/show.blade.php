@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				@include('partials.post', ['post' => $post])
			</div>
		</div>
	</div>
	<script defer>
		function likePost(postId, button) {
			const request = fetch({{ route('posts.like', $post) }}, {
				method: "POST",
				headers: {
					x_csrf_token: document
						.querySelector('meta[name="csrf-token"]')
						.getAttribute("content"),
				},
			}).then((response) => {
				response.text().then((value) => {
					button.innerText = value + " Like";
					button.classList.toggle("btn-outline-success");
					button.classList.toggle("btn-success");
				});
			}).catch((reason) => {
				console.error(reason);
			});
		}
	</script>
@endsection
