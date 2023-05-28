<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

	<!-- Scripts -->
	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
	@auth
		<script defer>
			const keepOnlineTimer = setInterval(function() {
				fetch("{{ route('home') }}");
			}, 60 * 1000);

			setTimeout(function() {
				clearInterval(keepOnlineTimer);
			}, 30 * 60 * 1000);
		</script>
	@endauth
    <script defer>
        function toast(text, type, options) {
            const toasts = document.getElementById("toasts");

            const toast = document.createElement("div");
            toast.classList.add("toast");
            if(type){
                toast.classList.add("text-bg-" + type );
            }

            const flex = document.createElement("div");
            flex.classList.add('d-flex');

            const body = document.createElement("div");
            body.classList.add("toast-body");
            body.appendChild(document.createTextNode(text));

            const close = document.createElement("button");
            close.classList.add("btn-close");
            close.classList.add("m-auto");
            close.classList.add("me-2");
            close.setAttribute("data-bs-dismiss","toast");

            flex.appendChild(body);
            flex.appendChild(close);
            toast.appendChild(flex);
            toasts.appendChild(toast);

            const bsToast = new bootstrap.Toast(toast, options);
            bsToast.show();
        }
    </script>
	@stack('scripts')
</head>

<body>
	<div id="app">
		<nav class="navbar navbar-expand-md text-bg-info bg-gradient shadow-sm sticky-top">
			<div class="container">
				<a class="navbar-brand" href="{{ url('/') }}">
					{{ config('app.name', 'Laravel') }}
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="{{ __('Toggle navigation') }}">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav me-auto">
						<li class="nav-item">
							<a class="nav-link icon-link" href="{{ route('users.index') }}">
								<i class="bi bi-person-fill"></i>
								Users
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link icon-link" href="{{ route('groups.index') }}">
								<i class="bi bi-people-fill"></i>
								Groups
							</a>
						</li>
					</ul>

					<form class="d-flex" role="search" action="{{ route('search') }}">
						<input class="form-control me-2" name="q" type="search" required placeholder="Search" aria-label="Search" value="{{ request()->get('q') }}">
						<button class="btn btn-outline-success" type="submit">
							Search
						</button>
					</form>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ms-auto">
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
								<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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

		<main class="py-4">
			@yield('content')
		</main>
		<div class="toast-container position-fixed bottom-0 start-0 p-3" id="toasts">
			@if (Session::has('message'))
				<div class="toast text-bg-{{ Session::get('alert-type', 'primary') }}" id="message_toast" role="alert" aria-live="assertive" aria-atomic="true">
					<div class="d-flex">
						<div class="toast-body">
							{{ Session::get('message') }}
						</div>
						<button type="button" class="btn-close m-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
					</div>
				</div>
				<script defer>
					window.addEventListener("load", function() {
						const toast = bootstrap.Toast.getOrCreateInstance(document.getElementById("message_toast"));
						toast.show();
					});
				</script>
			@endif
			@stack('toasts')
		</div>
	</div>
</body>

</html>
