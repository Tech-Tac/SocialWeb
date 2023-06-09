@extends('layouts.app')

@section('content')
	@include('partials.post', ['post' => $post])

	<div class="comments" id="post_{{ $post->id }}_comments">
		<h4>Comments</h4>
		@foreach ($post->comments as $comment)
			@include('partials.comment', ['comment', $comment])
		@endforeach
	</div>
	@auth
		<form action="{{ route('comments.store') }}" method="POST"
			onsubmit="event.preventDefault();sendComment(this,document.getElementById('post_{{ $post->id }}_comments'))">
			@csrf
			<input type="hidden" name="post_id" value="{{ $post->id }}">
			<div class="input-group mt-2">
				<textarea name="content" rows="1" class="form-control" required maxlength="2047" placeholder="Leave a comment"></textarea>
				<button class="btn btn-primary" type="submit">
					<i class="bi bi-send-fill"></i>
					Send
				</button>
			</div>
		</form>
	@endauth
@endsection
