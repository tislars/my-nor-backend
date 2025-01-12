<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My NOR</title>

    @vite('resources/css/app.css')
</head>

<body class="text-center px-8 py-12">
    <h1 class="text-2xl mb-4">Welcome to your NOR dashboard</h1>

    <a href="{{ route('auth.steam') }}"
        class="bg-sky-950 rounded-md px-4 py-2 text-white inline-block hover:bg-sky-900 transition-colors">
        Login
    </a>
</body>

</html>
