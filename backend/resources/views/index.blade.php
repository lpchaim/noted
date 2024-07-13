<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<link rel="icon" type="image/svg+xml" href="/vite.svg" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Noted</title>
	<base href="http://127.0.0.1:8000/">

	@vite('resources/css/app.css')
	@vite('resources/js/app.js')
</head>

<body
	hx-ext="client-side-templates,response-targets"
	hx-headers='{
		"X-Requested-With": "XMLHttpRequest",
		"X-XSRF-TOKEN": "{{ csrf_token() }}"
	}'
	hx-target-401="find .login"
>
	<div id="app" class="container">
		<span class="text-3xl font-bold underline">Heya!</span>

		<div id="notes"
			hx-get="/api/notes"
			hx-trigger="load"
			hx-target="find .ok"
		>
			<div class="ok"></div>
			<div class="error"></div>
		</div>
	</div>

	<div class="login"></div>
</body>

</html>