<nav class="navbar navbar-expand-md navbar-light text-bg-info bg-gradient shadow-sm sticky-top" data-bs-theme="light">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}">
			{{ config('app.name', 'Laravel') }}
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
			aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
			<span class="navbar-toggler-icon"></span>
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
					<input class="form-control" name="q" type="search" required placeholder="Search" aria-label="Search" value="{{ request()->get('q') }}">
					<button class="btn btn-outline-success" type="submit">
						<i class="bi bi-search"></i>
						Search
					</button>
				</div>
			</form>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ms-auto">

				<li class="nav-item mx-2" title="Toggle theme">
					<button class="nav-link px-3" id="theme_toggle" onclick="toggleTheme()">
						<i class="bi bi-sun-fill"></i>
					</button>
				</li>

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
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
							v-pre>
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
									onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
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
