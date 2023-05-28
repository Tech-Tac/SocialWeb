@extends('layouts.app')

@section('content')
	@include('partials.new_post')
	<hr>
	@foreach ($posts as $post)
		@include('partials.post', ['post', $post])
	@endforeach
@endsection
