@extends('layouts.app')

@section('content')
	<div class="text-center">
		<img src="{{ $group->icon ? asset('images/' . $group->icon) : 'https://placehold.co/512' }}" class="img-thumbnail" style="height:12em;width:12em;"alt="Group Icon">
		<br><br>
		<h4>{{ $group->name }}</h4>
		<p>{{ $group->description }}</p>
		<p>{{ $group->members->count() }} members, {{ $group->posts->count() }} posts</p>
		@if (Auth::check() && in_array(Auth::user()->id, $group->memberships->pluck('user_id')->toArray()))
			<form action="{{ route('groups.leave', $group) }}" method="post">
				@csrf
				<button class="btn btn-primary" type="submit">
					<i class="bi bi-check-circle"></i>
					Joined
				</button>
			</form>
			<br>
			<a href="{{ route('groups.edit', $group) }}" class="btn btn-secondary">
				<i class="bi bi-pencil-square"></i>
				Edit
			</a>
		@elseif(Auth::check())
			<form action="{{ route('groups.join', $group) }}" method="post">
				@csrf
				<button class="btn btn-primary" type="submit">
					<i class="bi bi-plus-circle"></i>
					Join
				</button>
			</form>
		@endif
	</div>
	@includeWhen(Auth::check() && in_array(Auth::user()->id, $group->memberships->pluck('user_id')->toArray()), 'partials.post_form')
	<hr>
	@foreach ($group->posts->sortByDesc('created_at') as $post)
		@include('partials.post', ['post', $post])
	@endforeach
@endsection
