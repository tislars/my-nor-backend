<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My NOR</title>

    @vite('resources/css/app.css')
</head>

<body class="m-0">
    <header class="bg-gray-800 text-white mb-4">
        <nav class="max-w-7xl mx-auto flex items-center justify-between p-4">
            <h1 class="text-2xl font-bold">
                My NOR
            </h1>
            <div class="flex space-x-6">
                <a href="{{ route('racelogs.index') }}" class="text-gray-300 hover:text-white hover:underline transition">
                    Racelogs
                </a>
                <a href="{{ route('race-cars.index') }}" class="text-gray-300 hover:text-white hover:underline transition">
                    Race Cars
                </a>
                <a href="{{ route('leaderboards.index') }}"
                    class="text-gray-300 hover:text-white hover:underline transition">
                    Leaderboard
                </a>
            </div>
        </nav>
    </header>

    <main class="container px-4 mx-auto">
        {{ $slot }}
    </main>
</body>

</html>
