@extends('layouts.app')

@section('content')
	<form class="post card my-4 shadow" id="post_edit" action="{{ route('posts.update', $post) }}" method="POST">
		@csrf
		@method('PUT')
		<div class="card-header">
			@if ($post->group)
				<a class="fw-bold text-body-emphasis" href="{{ route('groups.show', $post->group) }}">{{ $post->group->name }}</a> >
			@endif
			<a class="fw-bold text-body-emphasis" href="{{ route('users.show', Auth::user()) }}">{{ Auth::user()->name }}</a>:
			<input type="text" class="form-control" required name="title" maxlength="255" placeholder="Post Tile" value="{{ $post->title }}">
		</div>
		<div class="card-body">
			<textarea name="content" rows="3" maxlength="2047" required class="form-control" placeholder="Post content">{{ $post->content }}</textarea>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-success">
				<i class="bi bi-check-lg"></i>
				Save
			</button>
		</div>
	</form>
@endsection
