@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				@include('partials.new_post')
				<hr>
				@foreach ($posts as $post)
					@include('partials.post', ['post', $post])
				@endforeach
			</div>
		</div>
	</div>
@endsection
