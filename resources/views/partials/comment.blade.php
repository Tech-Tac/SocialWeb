@pushOnce('scripts')
	@include('partials.sendLike_script')
@endPushOnce
@pushOnce('scripts')
	@include('partials.sendComment_script')
@endPushOnce
<div class="card card-body shadow-sm my-3" id="comment_{{ $comment->id }}">
	<div class="header">
		<a class="fw-bold text-body-emphasis" href="{{ route('users.show', $comment->user) }}">{{ $comment->user->name }}</a>
		@if (Auth::check() && $comment->user->id === Auth::user()->id)
			<div class="dropdown float-end">
				<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{ route('comments.edit', $comment) }}">Edit</a></li>
					<li>
						<form action="{{ route('comments.destroy', $comment) }}" method="post">
							@csrf
							@method('DELETE')
							<button type="submit" class="dropdown-item">Delete</button>
						</form>
					</li>
				</ul>
			</div>
		@endif
		<span class="text-secondary float-end mx-3">{{ $comment->created_at->diffForHumans() }}</span>
	</div>
	<p>{{ $comment->content }}</p>
	@if ($comment->created_at != $comment->updated_at)
		<span class="text-secondary">edited</span>
	@endif
	@auth
		<div class="comments" id="comment_{{ $comment->id }}_replies">
			@foreach ($comment->replies as $reply)
				@include('partials.comment', ['comment' => $reply])
			@endforeach
		</div>
		<div class="row">
			<div class="col-auto">
				<button class="btn {{ in_array(Auth::user()->id, $comment->likes->pluck('user_id')->toArray()) ? 'btn-success' : 'btn-outline-success' }} btn-like"
					type="button" onclick="sendLike('comments',{{ $comment->id }}, this)">
					<i class="bi bi-heart-fill"></i>
					<span class="like-count">{{ $comment->likes->count() }}</span> Like
				</button>
			</div>
			<form action="{{ route('comments.store') }}" method="post" class="col"
				onsubmit="event.preventDefault();sendComment(this,document.getElementById('comment_{{ $comment->id }}_replies'))">
				@csrf
				<input type="hidden" name="post_id" value="{{ $comment->post->id }}">
				<input type="hidden" name="comment_id" value="{{ $comment->id }}">
				<div class="input-group">
					{{-- <textarea name="content" rows="1" class="form-control" required maxlength="2047" placeholder="Reply to {{ $comment->user->name }}"></textarea> --}}
					<input type="text" name="content" class="form-control" required maxlength="2047" placeholder="Reply to {{ $comment->user->name }}">
					<button class="btn btn-sm btn-primary" type="submit">
						<i class="bi bi-reply-fill"></i>
						Reply
					</button>
				</div>
			</form>
		</div>
	@endauth
</div>
