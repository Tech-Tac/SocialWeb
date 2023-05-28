@extends('layouts.app')

@section('content')
	@foreach ($users as $user)
		@include('partials.user_card', ['user' => $user])
	@endforeach
@endsection
