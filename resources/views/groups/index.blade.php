@extends('layouts.app')

@section('content')
	@auth
		<a href="{{ route('groups.create') }}" class="btn btn-primary">
			<i class="bi bi-plus-lg"></i>
			New Group
		</a>
	@endauth
	@foreach ($groups as $group)
		@include('partials.group_card', ['group' => $group])
	@endforeach
@endsection
