@include('partials.post', ['post' => $post, 'no_view' => true])

<div class="comments" id="post_{{ $post->id }}_comments">
	<h4>Comments</h4>
	@foreach ($post->comments as $comment)
		@include('partials.comment', ['comment' => $comment])
	@endforeach
	@if (count($post->comments) === 0)
		<p class="text-center text-secondary empty-comments">No comments.</p>
	@endif
</div>
<br>
@auth
	<form class="sticky-bottom row border-top bg-body py-3" style="box-shadow: 0 -0.75rem 0.75rem -0.5rem rgba(0, 0, 0, 0.25)" action="{{ route('comments.store') }}"
		method="POST" onsubmit="event.preventDefault();sendComment(this,document.getElementById('post_{{ $post->id }}_comments'))">
		@csrf
		<input type="hidden" name="post_id" value="{{ $post->id }}">
		<div class="input-group col">
			{{-- <textarea name="content" rows="1" class="form-control" required maxlength="2047" autofocus placeholder="Leave a comment" id="post_comment_input"></textarea> --}}
			<input type="text" name="content" class="form-control" required maxlength="2047" autofocus placeholder="Leave a comment" id="post_comment_input">
			<button class="btn btn-primary" type="submit">
				<i class="bi bi-send-fill"></i>
				Send
			</button>
		</div>
	</form>
@endauth
