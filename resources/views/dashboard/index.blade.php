<x-layout>
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

    <div class="mb-6">
        <h2 class="text-xl font-semibold">Overview</h2>
        <p>Total races completed: <strong>{{ $totalRaces }}</strong></p>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold">Fastest Laps by Track</h2>
        @if (!empty($trackData))
            <x-table :headers="['Track', 'Fastest Lap']" :rows="array_map(
                fn($track) => [
                    ['value' => $track['track'], 'class' => ''],
                    ['value' => $track['fastest_lap'], 'class' => ''],
                ],
                $trackData,
            )" />
        @else
            <p>No track data available.</p>
        @endif
    </div>
</x-layout>
