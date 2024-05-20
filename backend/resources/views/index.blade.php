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

<body hx-ext="client-side-templates,response-targets">
	<div id="app">
		<span class="text-3xl font-bold underline">Heya!</span>

		<div id="notes"
			hx-get="/api/notes"
			hx-trigger="load"
			hx-target="closest .ok"
			hx-target-error="closest .error"
		>
			<div class="ok"></div>
			<div class="error"></div>
		</div>
	</div>
</body>

</html>