<x-app-layout>
    <x-slot name="header">
        <h1>Export Data</h1>
    </x-slot>
    <div class="max-w-2xl mx-auto py-6">
        <form method="GET" action="{{ route('registry.export') }}" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">From Date</label>
                <input type="date" name="from_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">To Date</label>
                <input type="date" name="to_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <button type="submit" class="px-4 py-2 w-full bg-green-600 text-white rounded-md hover:bg-green-700">
                Download CSV
            </button>
        </form>
    </div>
</x-app-layout>
