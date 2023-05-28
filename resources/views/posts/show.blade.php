@extends('layouts.app')

@section('content')
	@include('partials.post', ['post' => $post])

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
