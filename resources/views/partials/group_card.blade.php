<div class="card my-3">
  <div class="row g-0">
    <div class="col-auto">
      <a href="{{ route('groups.show', $group) }}" class="text-decoration-none text-reset">
        <img src="{{ asset('images/' . ($group->icon ?? 'group.svg')) }}" class="img-thumbnail"
          style="height:10em;width:10em;" alt="Group Icon">
      </a>
    </div>
    <div class="col">
      <div class="card-body">
        <a href="{{ route('groups.show', $group) }}" class="text-decoration-none text-reset">
          <h5 class="card-title">{{ $group->name }}</h5>
        </a>
        <p class="card-text text-truncate">{{ $group->description }}</p>
        <p>{{ $group->members->count() }} members, {{ $group->posts->count() }} posts</p>
        @auth
          @if (in_array(Auth::user()->id, $group->memberships->pluck('user_id')->toArray()))
            <form action="{{ route('groups.leave', $group) }}" class="text-end" method="post">
              @csrf
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-check-circle"></i>
                Joined
              </button>
            </form>
          @else
            <form action="{{ route('groups.join', $group) }}" class="text-end" method="post">
              @csrf
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-plus-circle"></i>
                Join
              </button>
            </form>
          @endif
        @endauth
      </div>
    </div>
  </div>
</div>
