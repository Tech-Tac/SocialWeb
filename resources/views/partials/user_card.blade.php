<div class="card my-3">
  <div class="row g-0">
    <div class="col-auto mx-auto">
      <a href="{{ route('users.show', $user) }}" class="text-decoration-none text-reset">
        <img src="{{ asset('images/' . ($user->avatar ?? 'person.svg')) }}" class="img-thumbnail"
          style="height:12em;width:12em;" alt="User Avatar">
      </a>
    </div>
    <div class="col">
      <div class="card-body">
        <a href="{{ route('users.show', $user) }}" class="text-decoration-none text-reset">
          <h5 class="card-title">{{ $user->name }}</h5>
        </a>
        <p class="card-text text-truncate">{{ $user->about }}</p>
        <span class="card-text">
          @if ($user->online)
            <small class="text-success">
              <i class="bi bi-circle-fill"></i>
              Online
            </small>
          @else
            <small class="text-secondary">
              <i class="bi bi-x-circle"></i>
              @if ($user->last_seen)
                Last seen
                <time class="text-secondary" datetime="{{ $user->last_seen }}"
                  title="{{ $user->last_seen }}">{{ Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</time>
              @else
                Offline
              @endif
            </small>
          @endif
        </span>
        @if (Auth::check() && $user->id !== Auth::user()->id)
          <form action="{{ route('users.add_friend', $user) }}" class="text-end" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">
              @if (Auth::user()->friends->contains($user) || $user->friends->contains(Auth::user()))
                <i class="bi bi-person-check"></i>
                Friends
              @elseif (App\Models\Friendship::where([
                      'from_id' => $user->id,
                      'to_id' => Auth::user()->id,
                      'status' => 'pending',
                  ])->count() > 0)
                <i class="bi bi-person-plus"></i>
                Accept Friend Request
              @elseif (App\Models\Friendship::where([
                      'from_id' => Auth::user()->id,
                      'to_id' => $user->id,
                      'status' => 'pending',
                  ])->count() > 0)
                <i class="bi bi-person-plus"></i>
                Request Sent
              @else
                <i class="bi bi-person-plus"></i>
                Add Friend
              @endif
            </button>
          </form>
        @endif
      </div>
    </div>
  </div>
</div>
