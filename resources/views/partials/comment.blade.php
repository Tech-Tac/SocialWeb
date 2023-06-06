@pushOnce('scripts')
	@include('partials.sendLike_script')
@endPushOnce
@pushOnce('scripts')
	@include('partials.comment_script')
@endPushOnce
<div class="card card-body my-2" id="comment_{{ $comment->id }}">
	<a class="fw-bold text-black" href="{{ route('users.show', $comment->user) }}">{{ $comment->user->name }}</a>
	<p>{{ $comment->content }}</p>
	@auth
		<div class="comments" id="comment_{{ $comment->id }}_replies">
			@foreach ($comment->replies as $reply)
				@include('partials.comment', ['comment' => $reply])
			@endforeach
		</div>
		<div class="row">
			<div class="col-auto">
				<button class="btn {{ in_array(Auth::user()->id, $comment->likes->pluck('user_id')->toArray()) ? 'btn-success' : 'btn-outline-success' }} btn-like" type="button"
					onclick="sendLike('comments',{{ $comment->id }}, this)">
					<i class="bi bi-heart-fill"></i>
					<span class="like-count">{{ $comment->likes->count() }}</span> Like
				</button>
			</div>
			<form action="{{ route('comments.store') }}" method="post" class="col" onsubmit="event.preventDefault();comment(this,document.getElementById('comment_{{ $comment->id }}_replies'))">
				@csrf
				<input type="hidden" name="post_id" value="{{ $comment->post->id }}">
				<input type="hidden" name="comment_id" value="{{ $comment->id }}">
				<div class="input-group">
					<textarea name="content" rows="1" class="form-control" required maxlength="2047" placeholder="Reply to {{ $comment->user->name }}"></textarea>
					<button class="btn btn-sm btn-primary" type="submit">
						<i class="bi bi-reply-fill"></i>
						Reply
					</button>
				</div>
			</form>
		</div>
	@endauth
</div>
