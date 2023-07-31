<form class="post card bg-body my-4 shadow" id="post_new"
	action="{{ isset($post) ? route('posts.update', $post) : route('posts.store') }}" method="POST"
	onsubmit="if(this.isDisabled){event.preventDefault();}else{this.isDisabled=true;}">
	@if (isset($post))
	@method('PUT')
	@endif
	@csrf
	@if (isset($group))
	<input type="hidden" name="group" value="{{ $group->id }}">
	@endif
	<div class="card-header">
		@if (isset($group))
		<a class="fw-bold text-body-emphasis" href="{{ route('groups.show', $group) }}">{{ $group->name }}</a> &gt;
		@endif
		<a class="fw-bold text-body-emphasis" href="{{ route('users.show', Auth::user()) }}">{{ Auth::user()->name }}</a>
		<input type="text" class="form-control" required name="title" maxlength="255" placeholder="Post Tile"
			value="{{ isset($post) ? $post->title : '' }}">
	</div>
	<div class="card-body position-relative">
		<span tabindex="0" role="button" class="fs-5 position-absolute end-0 p-2 me-4" title="Markdown supported"
			data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-title="Markdown Supported"
			data-bs-content="You can write Markdown in this field.">
			<i class="bi bi-markdown"></i></span>
		<textarea name="content" rows="3" maxlength="2047" required class="form-control"
			placeholder="Post content">{{ isset($post) ? $post->content : '' }}</textarea>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-success">
			<i class="bi bi-send-fill"></i>
			Post
		</button>
	</div>
</form>