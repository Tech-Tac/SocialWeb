@extends('layouts.app')

@section('content')
	<div class="fs-4">New Post</div>
	@include('partials.post_form')
	<hr>
	<div>
		<span class="fs-4">Home Feed</span>
		<span class="text-secondary float-end">{{ count($posts) }} shown posts</span>
		<br>
	</div>
	<div id="posts">
		@foreach ($posts as $post)
			@include('partials.post', ['post', $post])
		@endforeach
	</div>
	<div class="text-center text-secondary">You have reached the end.</div>
@endsection
