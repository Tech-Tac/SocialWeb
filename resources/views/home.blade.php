@extends('layouts.app')

@section('content')
	<div class="fs-4">New Post</div>
	@include('partials.new_post')
	<hr>
	<div>
		<span class="fs-4">Home Feed</span>
		<span class="text-secondary float-end">{{ count($posts) }} shown posts</span>
		<br>
	</div>
	@foreach ($posts as $post)
		@include('partials.post', ['post', $post])
	@endforeach
@endsection
