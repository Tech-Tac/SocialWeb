@pushOnce('scripts')
	@include('partials.sendLike_script')
@endPushOnce
@pushOnce('scripts')
	@include('partials.sendComment_script')
@endPushOnce
<div class="post card my-4 shadow" id="post_{{ $post->id }}">
	<div class="card-header">
		<div class="row">
			<div class="col-auto">
				<img src="{{ asset('images/' . ($post->user->avatar ?? 'person.svg')) }}" alt="User avatar" class="rounded" style="width: 3em;height:3em;">
			</div>
			<div class="col p-0">
				@if ($post->group)
					<a class="fw-bold text-body-emphasis" href="{{ route('groups.show', $post->group) }}">{{ $post->group->name }}</a>
					>
				@endif
				<a class="fw-bold text-body-emphasis" href="{{ route('users.show', $post->user) }}">{{ $post->user->name }}</a>

				<time class="text-secondary float-end" datetime="{{ $post->created_at }}" title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</time>
				<br>
				<h5 class="card-title d-inline">{{ $post->title }}</h5>
				@if ($post->created_at != $post->updated_at)
					<span class="text-secondary fs-6">
						edited <time datetime="{{ $post->updated_at }}" title="{{ $post->updated_at }}">{{ $post->updated_at->diffForHumans() }}</time>
					</span>
				@endif
			</div>
			<div class="dropdown col-auto">
				<button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{ route('posts.show', $post) }}"><i class="bi bi-eye-fill"></i> Show</a></li>
					@auth
						<li><a class="dropdown-item" href><i class="bi bi-flag-fill"></i> Report</a></li>
					@endauth
					@if (Auth::check() && $post->user->id === Auth::user()->id)
						<li>
							<hr class="dropdown-divider">
						</li>
						<li><a class="dropdown-item" href="{{ route('posts.edit', $post) }}"><i class="bi bi-pencil-square"></i> Edit</a></li>
						<li>
							<form action="{{ route('posts.destroy', $post) }}" method="post">
								@csrf
								@method('DELETE')
								<button type="submit" class="dropdown-item"><i class="bi bi-trash-fill"></i> Delete</button>
							</form>
						</li>
					@endif
				</ul>
			</div>
		</div>

	</div>
	<div class="card-body">
		<div class="post-content" {{-- @if (!isset($full) || $full !== true) style=" display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;" @endif --}}>
			@php
				echo Str::markdown($post->content, ['html_input' => 'escape']);
			@endphp
		</div>
	</div>
	<div class="card-footer">
		@auth
			<button class="btn {{ in_array(Auth::user()->id, $post->likes->pluck('user_id')->toArray()) ? 'btn-success' : 'btn-outline-success' }} btn-like"
				type="button" onclick="sendLike('posts',{{ $post->id }}, this)">
				<i class="bi bi-heart-fill"></i>
				<span class="like-count">{{ $post->likes->count() }}</span> Like
			</button>
		@endauth
		@if (!isset($full) || $full !== true)
			<button class="btn btn-primary" onclick="viewPost({{ $post->id }})">
				<i class="bi bi-chat-square-fill"></i>
				View
			</button>
		@endif
	</div>
</div>

@if (!isset($full) || $full !== true)
	@pushOnce('scripts')
		@include('partials.viewPost_script')
	@endPushOnce

	@pushOnce('content')
		<div class="modal fade" id="post_view" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5">Post</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body py-0" id="view_body">
					</div>
				</div>
			</div>
		</div>
	@endPushOnce
@endif
