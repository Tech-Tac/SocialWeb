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
			if (type) {
				toast.classList.add("text-bg-" + type);
			}
			toast.setAttribute("role", "alert");

			const flex = document.createElement("div");
			flex.classList.add('d-flex');

			const body = document.createElement("div");
			body.classList.add("toast-body");
			body.appendChild(document.createTextNode(text));

			const close = document.createElement("button");
			close.classList.add("btn-close");
			close.classList.add("m-auto");
			close.classList.add("me-2");
			close.setAttribute("data-bs-dismiss", "toast");
			close.setAttribute("aria-label", "close");

			flex.appendChild(body);
			flex.appendChild(close);
			toast.appendChild(flex);
			toasts.appendChild(toast);

			const bsToast = new bootstrap.Toast(toast, options);
			bsToast.show();
		}

		function toggleTheme() {
			const themeIcon = document.querySelector("#theme_toggle .bi");

			if (localStorage.getItem("theme") === "light") {
				localStorage.setItem("theme", "dark");
			} else {
				localStorage.setItem("theme", "light");
			}

			themeIcon.className = "bi bi-" + (localStorage.getItem("theme") === "dark" ? "sun" : "moon") + "-fill";
			document.documentElement.setAttribute("data-bs-theme", localStorage.getItem("theme"));
		}

		document.documentElement.setAttribute("data-bs-theme", localStorage.getItem("theme"));
		window.addEventListener("load", function() {
			document.querySelector("#theme_toggle .bi").className = "bi bi-" + (localStorage.getItem("theme") === "dark" ? "sun" : "moon") + "-fill";
		});
	</script>
	@stack('scripts')
</head>

<body>
	<div id="app">
		@include('partials.navbar')

		<main class="py-4">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-10">
						@yield('content')
					</div>
				</div>
			</div>
		</main>
		<div class="toast-container position-fixed bottom-0 start-0 p-3" id="toasts">
			@if (Session::has('message'))
				<script defer>
					window.addEventListener("load", function() {
						toast("{{ Session::get('message') }}"
							@if (Session::has('alert-type'))
								, "{{ Session::get('alert-type') }}"
							@endif );
					});
				</script>
			@endif
			@stack('toasts')
		</div>
	</div>
</body>

</html>
