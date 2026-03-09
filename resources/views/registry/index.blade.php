<x-app-layout>
    <div class="px-4 mt-4">
        @include('registry.partials.success', ['success' => session('success')])
    </div>

    <!-- Search Form -->
    <div class="px-4 mt-4">
        <form method="GET" action="{{ route('registry.index') }}" class="flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by reference, sender, recipient, or subject..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-md"
            >
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('registry.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="px-4 mt-6">
        <div class="overflow-y-scroll rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ref No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sender</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recipient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Files</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($registries as $registry)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $registry->reference_no }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $registry->date?->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $registry->sender ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $registry->recipient ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                {{ $registry->subject ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php $files = json_decode($registry->attachments ?? '[]') @endphp
                                {{ count($files) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('registry.show', $registry) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                <a href="{{ route('registry.edit', $registry) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                <form method="POST" action="{{ route('registry.destroy', $registry) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                No registries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $registries->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>
