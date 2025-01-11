<x-layout>
    <h1 class="text-2xl">Fastest laps - {{ $track }}</h1>
    <x-table :headers="['Position', 'Driver', 'Lap time']" :rows="$leaderboard" />
</x-layout>
