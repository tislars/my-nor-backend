<x-layout>
    <h1 class="text-2xl">Leaderboard</h1>
    <x-table :headers="$headers" :rows="$rows" emptyMessage="No drivers available." />
    {{ $drivers->links() }}
</x-layout>
