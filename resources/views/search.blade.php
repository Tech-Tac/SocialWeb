@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<h3>Users
					<small class="float-end text-muted">{{ $users->count() }}</small>
				</h3>
				@if ($users->count() === 0)
					<div class="text-center text-muted">No users found.</div>
				@endif
				@foreach ($users as $user)
					@include('partials.user_card', ['user' => $user])
				@endforeach

				<h3>Groups
					<small class="float-end text-muted">{{ $groups->count() }}</small>
				</h3>
				@if ($groups->count() === 0)
					<div class="text-center text-muted">No users found.</div>
				@endif
				@foreach ($groups as $group)
					<div class="card my-3">
						<div class="row g-0">
							<div class="col-auto">
								<a href="{{ route('groups.show', $group) }}" class="text-decoration-none text-reset"><img src="https://placehold.co/512" class="img-thumbnail" style="height:12em;width:12em;"
										alt="group Avatar"></a>
							</div>
							<div class="col">
								<div class="card-body">
									<a href="{{ route('groups.show', $group) }}" class="text-decoration-none text-reset">
										<h5 class="card-title">{{ $group->name }}</h5>
									</a>
									<p class="card-text">{{ $group->description }}</p>
									<p>{{ count($group->members) }} members</p>
									@if (Auth::check())
										@if (in_array(Auth::user()->id, $group->members))
											<form action="{{ route('groups.leave', $group) }}" class="text-end" method="post">
												@csrf
												<button class="btn btn-primary" type="submit">
													<i class="bi bi-check-circle"></i>
													Joined
												</button>
											</form>
										@else
											<form action="{{ route('groups.join', $group) }}" class="text-end" method="post">
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
					<small class="float-end text-muted">{{ $posts->count() }}</small>
				</h3>
				@if ($posts->count() === 0)
					<div class="text-center text-muted">No posts found.</div>
				@endif
				@foreach ($posts as $post)
					@include('partials.post', ['post' => $post])
				@endforeach
			</div>
		</div>
	</div>
@endsection
