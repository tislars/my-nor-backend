<x-layout>
    <h1 class="text-2xl">Race Logs</h1>
    <x-table
        :headers="$headers"
        :rows="$rows"
        :rowClasses="[]"
        emptyMessage="No race cars available." />
        {{ $raceLogs->links() }}
</x-layout>