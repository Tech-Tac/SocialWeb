@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				@foreach ($users as $user)
					@include('partials.user_card', ['user' => $user])
				@endforeach
			</div>
		</div>
	</div>
@endsection
