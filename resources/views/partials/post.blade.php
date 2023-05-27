@pushOnce('scripts')
	@include('partials.sendLike_script')
@endPushOnce
<div class="post card p-2 my-3 shadow-sm" id="post_{{ $post->id }}">
	<div class="card">
		<div class="card-header">
			@if ($post->group)
				<a class="fw-bold text-black" href="{{ route('groups.show', $post->group) }}">{{ $post->group->name }}</a> >
			@endif
			<a class="fw-bold text-black" href="{{ route('users.show', $post->user) }}">{{ $post->user->name }}</a>:
			@if ($post->user->id === Auth::user()->id)
				<div class="dropdown float-end">
					<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
						Actions
					</button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="{{ route('posts.edit', $post) }}">Edit</a></li>
						<li>
							<form action="{{ route('posts.destroy', $post) }}" method="post">
								@csrf
								@method('DELETE')
								<button type="submit" class="dropdown-item">Delete</button>
							</form>
						</li>
					</ul>
				</div>
			@endif
			<h5 class="card-title">{{ $post->title }}</h5>
			<span class="text-muted float-end">{{ $post->created_at }}</span>
		</div>
		<div class="card-body">
			<p>{{ $post->content }}</p>
		</div>
		<div class="card-footer">
			@auth
				<button class="btn {{ in_array(Auth::user()->id, $post->likes->pluck('user_id')->toArray()) ? 'btn-success' : 'btn-outline-success' }} btn-like" type="button"
					onclick="sendLike('posts',{{ $post->id }}, this)">
					<i class="bi bi-heart-fill"></i>
					<span class="like-count">{{ $post->likes->count() }}</span> Like
				</button>
			@endauth
			<a class="btn btn-primary" href="{{ route('posts.show', $post) }}">
				<i class="bi bi-share-fill"></i>
				Share
			</a>
		</div>
	</div>
	@foreach ($post->comments as $comment)
		@include('partials.comment', ['comment', $comment])
	@endforeach
	@auth
		<form action="{{ route('comments.store') }}" method="POST">
			@csrf
			<input type="hidden" name="post_id" value="{{ $post->id }}">
			<div class="input-group mt-2">
				<input type="text" name="content" class="form-control" required maxlength="2047" placeholder="Leave a comment">
				<button class="btn btn-primary" type="submit">
					<i class="bi bi-send-fill"></i>
					Send
				</button>
			</div>
		</form>
	@endauth
</div>
