@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="text-center">
					<h1>{{ config('app.name') }}</h1>
					<p>You can share and like posts and comment on them.</p>
					<p>
						We currently have {{ App\Models\User::count() }} users, {{ App\Models\Post::count() }} posts and {{ App\Models\Comment::count() }} comments.
						Join us now!
					</p>
					<br><br>
					@guest
						<div>
							<a href="{{ route('login') }}" class="btn btn-primary">
								<i class="bi bi-door-open-fill"></i>
								Login</a>
							<br><br>
							<a href="{{ route('register') }}" class="btn btn-success">
								<i class="bi bi-person-plus-fill"></i>
								Register</a>
						</div>
					@else
						<a href="{{ route('home') }}" class="btn btn-success">Home Page</a>
					@endguest
				</div>
			</div>
		</div>
	</div>
@endsection
