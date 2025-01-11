<x-layout>
    <h1 class="text-2xl">Leaderboard</h1>
    <x-table :headers="$headers" :rows="$rows" :rowClasses="$rowClasses" emptyMessage="No drivers available." />
</x-layout>
