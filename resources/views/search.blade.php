@extends('layouts.app')

@section('content')
	<div class="header">
		<span class="fs-4 title">Users</span>
		<span class="text-secondary float-end">{{ count($users) }}</span>
	</div>
	@if (count($users) === 0)
		<div class="text-center text-secondary">No users found.</div>
	@endif
	@foreach ($users as $user)
		@include('partials.user_card', ['user' => $user])
	@endforeach

	<div class="header">
		<span class="fs-4 title">Groups</span>
		<span class="text-secondary float-end">{{ count($groups) }}</span>
	</div>
	@if (count($groups) === 0)
		<div class="text-center text-secondary">No users found.</div>
	@endif
	@foreach ($groups as $group)
		@include('partials.group_card', ['group' => $group])
	@endforeach

	<div class="header">
		<span class="fs-4 title">Posts</span>
		<span class="text-secondary float-end">{{ count($posts) }}</span>
	</div>
	@if (count($posts) === 0)
		<div class="text-center text-secondary">No posts found.</div>
	@endif
	@foreach ($posts as $post)
		@include('partials.post', ['post' => $post])
	@endforeach
@endsection
