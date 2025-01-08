<x-layout>
    <h1 class="text-2xl">Leaderboard</h1>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Short name</th>
                <th>Name</th>
                <th>ELO</th>
                <th>Safety rating</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($drivers as $driver)
                <tr @class([
                    'bg-yellow-300' => $loop->index === 0,
                    'bg-gray-300' => $loop->index === 1,
                    'bg-amber-400' => $loop->index === 2,
                ])>
                    <td>#{{ $loop->index + 1 }}</td>
                    <td>{{ $driver->short_name }}</td>
                    <td>{{ $driver->first_name . ' ' . $driver->last_name }}</td>
                    <td>{{ number_format($driver->elo, 0) }}</td>
                    <td>...</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No drivers available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-layout>
