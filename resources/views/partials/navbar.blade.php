<nav class="navbar navbar-expand-md navbar-light text-bg-info bg-gradient shadow-sm sticky-top" data-bs-theme="light">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{ asset('logo.svg') }}" alt="Logo" height="32">
      {{ config('app.name', 'Laravel') }}
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="--bs-navbar-toggler-icon-bg:unset"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('users.index') }}">
            <i class="bi bi-person-fill"></i>
            Users
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('groups.index') }}">
            <i class="bi bi-people-fill"></i>
            Groups
          </a>
        </li>
      </ul>

      <form class="d-flex" role="search" action="{{ route('search') }}">
        <div class="input-group">
          <input class="form-control" name="q" type="search" required placeholder="Search..." aria-label="Search"
            value="{{ request()->get('q') }}">
          <button class="btn btn-light border border-start-0" type="submit">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ms-auto">

        <li class="nav-item" title="Theme">
          <button type="button" class="nav-link w-100 text-start px-md-3" id="theme_toggle" onclick="toggleTheme()">
            <i class="bi bi-sun-fill"></i>
            <span class="d-inline d-md-none">Theme</span>
          </button>
        </li>

        @auth
          <li class="nav-item" title="Notifications">
            <a href="{{ route('notifications') }}" class="nav-link w-100 text-start px-md-3">
              <i class="bi bi-bell-fill"></i>
              <span class="d-inline d-md-none">Notifications</span>
            </a>
          </li>
        @endauth

        <!-- Authentication Links -->
        @guest
          @if (Route::has('login'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">
                <i class="bi bi-door-open-fill"></i>
                {{ __('Login') }}
              </a>
            </li>
          @endif

          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">
                <i class="bi bi-person-plus-fill"></i>
                {{ __('Register') }}</a>
            </li>
          @endif
        @else
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
              data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              <img src="{{ asset('images/' . (Auth::user()->avatar ?? 'person.svg')) }}" alt="User avatar"
                class="rounded me-2" style="width:1lh;height:1lh;">
              {{ Auth::user()->name }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">
                  <i class="bi bi-person-circle"></i>
                  Profile
                </a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <i class="bi bi-door-closed-fill"></i>
                  {{ __('Logout') }}
                </a></li>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </ul>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
