@pushOnce('scripts')
	@include('partials.sendLike_script')
@endPushOnce
@pushOnce('scripts')
	@include('partials.sendComment_script')
@endPushOnce
<div class="post card my-4 shadow" id="post_{{ $post->id }}">
	<div class="card-header">
		@if ($post->group)
			<a class="fw-bold text-body-emphasis" href="{{ route('groups.show', $post->group) }}">{{ $post->group->name }}</a> >
		@endif
		<a class="fw-bold text-body-emphasis" href="{{ route('users.show', $post->user) }}">{{ $post->user->name }}</a>:
		@if ($post->user->id === Auth::user()->id)
			<div class="dropdown float-end">
				<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
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
		<span class="text-secondary float-end mx-3">{{ $post->created_at->diffForHumans() }}</span>
		<br>
		<h5 class="card-title d-inline">{{ $post->title }}</h5>
		@if ($post->created_at != $post->updated_at)
			<span class="text-secondary">edited</span>
		@endif
	</div>
	<div class="card-body">
		<p>{{ $post->content }}</p>
	</div>
	<div class="card-footer">
		@auth
			<button class="btn {{ in_array(Auth::user()->id, $post->likes->pluck('user_id')->toArray()) ? 'btn-success' : 'btn-outline-success' }} btn-like"
				type="button" onclick="sendLike('posts',{{ $post->id }}, this)">
				<i class="bi bi-heart-fill"></i>
				<span class="like-count">{{ $post->likes->count() }}</span> Like
			</button>
		@endauth
		<a class="btn btn-primary" href="{{ route('posts.show', $post) }}">
			<i class="bi bi-chat-square-fill"></i>
			View
		</a>
	</div>
</div>
