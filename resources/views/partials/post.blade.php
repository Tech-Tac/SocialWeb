@pushOnce('scripts')
  @include('partials.sendLike_script')
@endPushOnce
@pushOnce('scripts')
  @include('partials.sendComment_script')
@endPushOnce
<div class="post card my-4 shadow" id="post_{{ $post->id }}">
  <div class="card-header">
    <div class="row px-1 gap-2">
      <div class="col-auto p-0">
        <a href="{{ route('users.show', $post->user) }}">
          <img src="{{ asset('images/' . ($post->user->avatar ?? 'person.svg')) }}" alt="User avatar" class="rounded"
            style="width: 3em;height:3em;">
        </a>
      </div>
      <div class="col p-0 pe-5">
        @if ($post->group)
          <a class="fw-bold text-body-emphasis"
            href="{{ route('groups.show', $post->group) }}">{{ $post->group->name }}</a>
          &gt;
        @endif
        <a class="fw-bold text-body-emphasis" href="{{ route('users.show', $post->user) }}">{{ $post->user->name }}</a>

        <time class="text-secondary float-end" datetime="{{ $post->created_at }}"
          title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</time>
        <br>
        <h5 class="card-title d-inline">{{ $post->title }}</h5>
        @if ($post->created_at != $post->updated_at)
          <span class="text-secondary fs-6">
            edited <time datetime="{{ $post->updated_at }}"
              title="{{ $post->updated_at }}">{{ $post->updated_at->diffForHumans() }}</time>
          </span>
        @endif
      </div>
      <div class="dropdown position-absolute end-0 top-0 me-2 mt-2 col-auto p-0">
        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="{{ route('posts.show', $post) }}"><i class="bi bi-eye-fill"></i> Show</a>
          </li>
          @auth
            <li><a class="dropdown-item" href><i class="bi bi-flag-fill"></i> Report</a></li>
          @endauth
          @if (Auth::check() && $post->user->id === Auth::user()->id)
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('posts.edit', $post) }}"><i class="bi bi-pencil-square"></i>
                Edit</a></li>
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
    <div class="post-content">
      @php
        echo Str::markdown($post->content, ['html_input' => 'escape']);
      @endphp
    </div>
  </div>
  <div class="card-footer">
    @auth
      <button
        class="btn {{ in_array(Auth::user()->id, $post->likes->pluck('user_id')->toArray()) ? 'btn-success' : 'btn-outline-success' }} btn-like"
        type="button" onclick="sendLike('posts',{{ $post->id }}, this)">
        <i class="bi bi-heart-fill"></i>
        <span class="like-count">{{ $post->likes->count() }}</span> Like
      </button>
    @endauth
    <span class="dropdown">
      <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-people-fill"></i>
        Likers
      </button>
      <ul class="dropdown-menu">
        @foreach ($post->likes as $like)
          <li style="min-width: max-content">
            <a class="dropdown-item" href="{{ route('users.show', $like->user) }}">
              <img src="{{ asset('images/' . ($like->user->avatar ?? 'person.svg')) }}" alt="User avatar"
                class="rounded me-1" style="width: 1.5em;height:1.5em;">
              <span>{{ $like->user->name }}</span>
              <time class="text-body-secondary float-end display-inline-block ms-3" datetime="{{ $like->created_at }}"
                title="{{ $like->created_at }}">{{ $like->created_at->diffForHumans() }}</time>
            </a>
          </li>
        @endforeach
      </ul>
    </span>
    @if (!isset($full) || $full !== true)
      <button class="btn btn-primary" onclick="viewPost({{ $post->id }})">
        <i class="bi bi-chat-square-fill"></i>
        Comments
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
