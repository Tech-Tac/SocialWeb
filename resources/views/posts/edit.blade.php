@extends('layouts.app')

@section('content')
	<form class="post border bg-body rounded p-1 my-3" id="post_new" action="{{ route('posts.update', $post) }}" method="POST">
		@csrf
		@method('PUT')
		<div class="card">
			<div class="card-header"><b>{{ Auth::user()->name }}</b>:
				<input type="text" class="form-control" required name="title" maxlength="255" placeholder="Post Tile" value="{{ $post->title }}">
			</div>
			<div class="card-body">
				<textarea name="content" rows="3" maxlength="2047" required class="form-control" placeholder="Post content">{{ $post->content }}</textarea>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-success">
					<i class="bi bi-pencil-fill"></i>
					Edit
				</button>
			</div>
		</div>
	</form>
@endsection
