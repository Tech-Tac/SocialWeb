@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="text-center">
					<img src="https://placehold.co/512" class="img-thumbnail" style="height:12em;width:12em;" alt="Group Icon">
					<br><br>
					<h4>{{ $group->name }}</h4>
					<p>{{ $group->description }}</p>
					<p>{{ count($group->memberships) }} members</p>
					@if (in_array(Auth::user()->id, $group->memberships->pluck('user_id')->toArray()))
						<form action="{{ route('groups.leave', $group) }}" method="post">
							@csrf
							<button class="btn btn-primary" type="submit">
								<i class="bi bi-check-circle"></i>
								Joined
							</button>
						</form>
					@else
						<form action="{{ route('groups.join', $group) }}" method="post">
							@csrf
							<button class="btn btn-primary" type="submit">
								<i class="bi bi-plus-circle"></i>
								Join
							</button>
						</form>
					@endif
				</div>
				@includeWhen(Auth::check() && in_array(Auth::user()->id, $group->memberships->pluck('user_id')->toArray()), 'partials.new_post')
				<hr>
				@foreach ($group->posts->sortByDesc("created_at") as $post)
					@include('partials.post', ['post', $post])
				@endforeach
			</div>
		</div>
	</div>
@endsection
