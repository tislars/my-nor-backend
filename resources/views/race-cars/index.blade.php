<x-layout>
    <h1 class="text-2xl">Race Cars</h1>
    <x-table
        :headers="$headers"
        :rows="$rows"
        emptyMessage="No race cars available."
    />
    {{ $raceCars->links() }}
</x-layout>
