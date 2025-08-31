<x-app-layout>
    <div class="py-6 px-6">
        <h3 class="text-lg font-semibold mb-4">Latest Emails</h3>
        <table class="table-auto w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1">From</th>
                    <th class="px-2 py-1">Subject</th>
                    <th class="px-2 py-1">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emails as $m)
                    <tr>
                        <td class="border px-2 py-1">{{ $m['from'] }}</td>
                        <td class="border px-2 py-1">{{ $m['subject'] }}</td>
                        <td class="border px-2 py-1">{{ $m['date'] }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-2">No emails found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>