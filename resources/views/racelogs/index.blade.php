<x-layout>
    <h1 class="text-2xl">Race Logs</h1>
    <table>
        <thead>
            <tr>
                <th>Race ID</th>
                <th>Track</th>
                <th>Session type</th>
                <th>Driver</th>
                <th>Position</th>
                <th>Fastest Lap</th>
                <th>Incidents</th>
                <th>ELO change</th>
                <th>ELO</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($raceLogs as $log)
                <tr>
                    <td>#{{ $log->race->id }}</td>
                    <td>{{ $log->race->track_name }}</td>
                    <td>{{ $log->race->session_type }}</td>
                    <td>{{ $log->driver->first_name . ' ' . $log->driver->last_name }}</td>
                    <td>{{ $log->position }}</td>
                    <td>{{ $log->fastest_lap }}</td>
                    <td>{{ $log->incidents }}</td>
                    @php($eloChange = $log->elo_change)
                    <td
                        class="border border-gray-300 px-4 py-2 text-white {{ $eloChange > 0 ? 'bg-green-500' : ($eloChange < 0 ? 'bg-red-500' : 'bg-gray-500') }}">
                        {{ $eloChange }}
                    </td>
                    <td>{{ number_format($log->driver->elo, 0) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No race logs available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-layout>
