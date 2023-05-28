<form class="post border bg-body rounded p-1 my-3" id="post_new" action="{{ route('posts.store') }}" method="POST">
	@csrf
	@if (isset($group))
		<input type="hidden" name="group" value="{{ $group->id }}">
	@endif
	<div class="card">
		<div class="card-header"><b>{{ Auth::user()->name }}</b>:
			<input type="text" class="form-control" required name="title" maxlength="255" placeholder="Post Tile">
		</div>
		<div class="card-body">
			<textarea name="content" rows="3" maxlength="2047" required class="form-control" placeholder="Post content"></textarea>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-success">
				<i class="bi bi-send-fill"></i>
				Post
			</button>
		</div>
	</div>
</form>
