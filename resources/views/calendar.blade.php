<x-app-layout>
    <div class="py-6 px-6">
        <h3 class="text-lg font-semibold mb-4">Upcoming Calendar Events</h3>
        <table class="table-auto w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1">Summary</th>
                    <th class="px-2 py-1">Start</th>
                    <th class="px-2 py-1">End</th>
                    <th class="px-2 py-1">Creator</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $e)
                    <tr>
                        <td class="border px-2 py-1">{{ $e['summary'] }}</td>
                        <td class="border px-2 py-1">{{ $e['start'] }}</td>
                        <td class="border px-2 py-1">{{ $e['end'] }}</td>
                        <td class="border px-2 py-1">{{ $e['creator'] }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-2">No events found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>