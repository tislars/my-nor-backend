<div class="overflow-x-auto">
    <table class="table-auto border-collapse w-full">
        <thead>
            <tr>
                @foreach ($headers as $header)
                    <th class="border px-4 py-2 text-left">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        @if (is_array($cell) && isset($cell['class']))
                            <td class="border px-4 py-2 {{ $cell['class'] }}">{!! $cell['value'] !!}</td>
                        @else
                            <td class="border px-4 py-2">{!! $cell !!}</td>
                        @endif
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" class="border px-4 py-2 text-center">No data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>