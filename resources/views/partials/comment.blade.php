@pushOnce('scripts')
  @include('partials.sendLike_script')
@endPushOnce
@pushOnce('scripts')
  @include('partials.sendComment_script')
@endPushOnce
<div class="comment card card-body shadow-sm my-3" id="comment_{{ $comment->id }}">
  <div class="header row align-items-center mb-3">
    <div class="col-auto">
      <img src="{{ asset('images/' . ($comment->user->avatar ?? 'person.svg')) }}" alt="User avatar" class="rounded"
        style="width: 2.5em;height:2.5em;">
    </div>
    <div class="col p-0">
      <a class="fw-bold text-body-emphasis" href="{{ route('users.show', $comment->user) }}">
        {{ $comment->user->name }}
        @if ($comment->user->id === $comment->post->user->id)
          <span class="badge text-bg-secondary" title="Original Poster">OP</span>
        @endif
      </a>

      <time class="text-secondary float-end" datetime="{{ $comment->created_at }}"
        title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</time>
    </div>
    <div class="dropdown col-auto">
      <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
      <ul class="dropdown-menu">
        <li>
          <a class="dropdown-item" href="{{ route('posts.show', $comment->post) . ('#comment_' . $comment->id) }}">
            <i class="bi bi-eye-fill"></i>
            Show
          </a>
        </li>
        @auth
          <li><a class="dropdown-item" href><i class="bi bi-flag-fill"></i> Report</a></li>
        @endauth
        @if (Auth::check() && $comment->user->id === Auth::user()->id)
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="{{ route('comments.edit', $comment) }}"><i class="bi bi-pencil-square"></i>
              Edit</a></li>
          <li>
            <form action="{{ route('comments.destroy', $comment) }}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit" class="dropdown-item"><i class="bi bi-trash-fill"></i> Delete</button>
            </form>
          </li>
        @endif
      </ul>
    </div>
  </div>
  <p class="comment-content">
    @php
      echo Str::inlineMarkdown($comment->content, ['html_input' => 'escape']);
    @endphp
  </p>
  @if ($comment->created_at != $comment->updated_at)
    <time class="text-secondary" datetime="{{ $comment->updated_at }}" title="{{ $comment->updated_at }}">edited
      {{ $comment->updated_at->diffForHumans() }}</time>
  @endif

  <details class="comment-replies" id="comment_{{ $comment->id }}_replies">
    <summary class="mb-2">Replies</summary>
    @foreach ($comment->replies as $reply)
      @include('partials.comment', ['comment' => $reply])
    @endforeach
  </details>
  @if (Auth::check() &&
          (!$comment->post->group ||
              in_array(Auth::user()->id, $comment->post->group->memberships->pluck('user_id')->toArray())))
    <div class="row">
      <div class="col-auto">
        <button
          class="btn btn-sm {{ in_array(Auth::user()->id, $comment->likes->pluck('user_id')->toArray()) ? 'btn-success' : 'btn-outline-success' }} btn-like"
          type="button" onclick="sendLike('comments',{{ $comment->id }}, this)">
          <i class="bi bi-heart-fill"></i>
          <span class="like-count">{{ $comment->likes->count() }}</span> Like
        </button>
      </div>
      <form action="{{ route('comments.store') }}" method="post" class="col ps-0"
        onsubmit="event.preventDefault();sendComment(this,document.getElementById('comment_{{ $comment->id }}_replies'))">
        @csrf
        <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
        <div class="input-group">
          {{-- <textarea name="content" rows="1" class="form-control form-control-sm" required maxlength="2047"
					placeholder="Reply to {{ $comment->user->name }}" id="comment_{{ $comment->id }}_reply_input">></textarea>
				--}}
          <input type="text" name="content" class="form-control form-control-sm" required maxlength="2047"
            placeholder="Reply to {{ $comment->user->name }}" id="comment_{{ $comment->id }}_reply_input">
          <button class="btn btn-sm btn-primary" type="submit">
            <i class="bi bi-reply-fill"></i>
            Reply
          </button>
        </div>
      </form>
    </div>
  @endif
</div>
