<x-app-layout>
    <div class="py-6 px-6">
        <h3 class="text-lg font-semibold mb-4">Google Tasks</h3>
        <table class="table-auto w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 py-1">Title</th>
                    <th class="px-2 py-1">Status</th>
                    <th class="px-2 py-1">Due</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $t)
                    <tr>
                        <td class="border px-2 py-1">{{ $t['title'] }}</td>
                        <td class="border px-2 py-1">{{ $t['status'] }}</td>
                        <td class="border px-2 py-1">{{ $t['due'] }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-2">No tasks found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>