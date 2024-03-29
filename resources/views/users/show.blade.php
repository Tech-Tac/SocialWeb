@extends('layouts.app')

@section('content')

	<div class="text-center">
		<img src="{{ asset('images/' . ($user->avatar ?? 'person.svg')) }}" class="img-thumbnail" style="height:12em;width:12em;" alt="User Avatar">
		<br><br>
		<h1>{{ $user->name }}</h1>
		@if ($user->online)
			<small class="text-success">
				<i class="bi bi-circle-fill"></i>
				Online
			</small>
		@else
			<small class="text-secondary">
				<i class="bi bi-x-circle"></i>
				@if ($user->last_seen)
					Last seen
					<time class="text-secondary" datetime="{{ $user->last_seen }}" title="{{ $user->last_seen }}">{{ Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</time>
				@else
					Offline
				@endif
			</small>
		@endif
		<p>
			{{ $user->about }}
		</p>

		<div>
			@if (Auth::check() && Auth::user()->id === $user->id)
				<a type="button" class="btn btn-primary" href="{{ route('users.edit') }}">
					<i class="bi bi-pencil-square"></i>
					Edit
				</a>
			@elseif (Auth::check())
				<form action="{{ route('users.add_friend', $user) }}" method="post">
					@csrf
					<button type="submit" class="btn btn-primary">
						@if (Auth::user()->friends->contains($user) || $user->friends->contains(Auth::user()))
							<i class="bi bi-person-check"></i>
							Friends
						@elseif (App\Models\Friendship::where(['from_id' => $user->id, 'to_id' => Auth::user()->id, 'status' => 'pending'])->count() > 0)
							<i class="bi bi-person-plus"></i>
							Accept Friend Request
						@elseif (App\Models\Friendship::where(['from_id' => Auth::user()->id, 'to_id' => $user->id, 'status' => 'pending'])->count() > 0)
							<i class="bi bi-person-plus"></i>
							Request Sent
						@else
							<i class="bi bi-person-plus"></i>
							Add Friend
						@endif
					</button>
				</form>
			@endif
		</div>
	</div>
	<br>
	<div>
		<h4>Friends</h4>
		@foreach ($user->friends as $friend)
			@include('partials.user_card', ['user' => $friend])
		@endforeach
	</div>
	<div>
		<h4>Posts</h4>
		@foreach ($user->posts as $post)
			@include('partials.post', ['post' => $post])
		@endforeach
	</div>

@endsection
