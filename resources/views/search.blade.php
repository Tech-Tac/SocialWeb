@extends('layouts.app')

@section('content')
	<h3>Users
		<small class="float-end text-secondary">{{ $users->count() }}</small>
	</h3>
	@if ($users->count() === 0)
		<div class="text-center text-secondary">No users found.</div>
	@endif
	@foreach ($users as $user)
		@include('partials.user_card', ['user' => $user])
	@endforeach

	<h3>Groups
		<small class="float-end text-secondary">{{ $groups->count() }}</small>
	</h3>
	@if ($groups->count() === 0)
		<div class="text-center text-secondary">No users found.</div>
	@endif
	@foreach ($groups as $group)
		<div class="card my-3">
			<div class="row g-0">
				<div class="col-auto">
					<a href="{{ route('groups.show', $group) }}" class="text-decoration-none text-reset"><img src="https://placehold.co/512" class="img-thumbnail"
							style="height:12em;width:12em;" alt="group Avatar"></a>
				</div>
				<div class="col">
					<div class="card-body">
						<a href="{{ route('groups.show', $group) }}" class="text-decoration-none text-reset">
							<h5 class="card-title">{{ $group->name }}</h5>
						</a>
						<p class="card-text">{{ $group->description }}</p>
						<p>{{ $group->members->count() }} members, {{ $group->posts->count() }} posts</p>
						@if (Auth::check())
							@if (in_array(Auth::user()->id, $group->memberships->pluck('user_id')->toArray()))
								<form action="{{ route('groups.leave', $group) }}" method="post" class="text-end">
									@csrf
									<button class="btn btn-primary" type="submit">
										<i class="bi bi-check-circle"></i>
										Joined
									</button>
								</form>
							@else
								<form action="{{ route('groups.join', $group) }}" method="post" class="text-end">
									@csrf
									<button class="btn btn-primary" type="submit">
										<i class="bi bi-plus-circle"></i>
										Join
									</button>
								</form>
							@endif
						@endif
					</div>
				</div>
			</div>
		</div>
	@endforeach

	<h3>
		Posts
		<small class="float-end text-secondary">{{ $posts->count() }}</small>
	</h3>
	@if ($posts->count() === 0)
		<div class="text-center text-secondary">No posts found.</div>
	@endif
	@foreach ($posts as $post)
		@include('partials.post', ['post' => $post])
	@endforeach
@endsection
