<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-bold text-gray-700">Registry: {{ $registry->reference_no }}</h1>
            <a area-label="back" title="Back" href="{{ route('registry.index') }}">
                <x-solar-backspace-bold class="w-6 h-6 text-gray-700"/>
            </a>
        </div>
    </x-slot>
    <div class="px-4 mt-4">
        @include('registry.partials.success', ['success' => session('success')])
    </div>

    <!-- Details -->
    <div class="px-4 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-sm font-medium text-gray-500">Reference No</h3>
            <p class="mt-1 text-lg text-gray-900">{{ $registry->reference_no }}</p>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Date</h3>
            <p class="mt-1 text-lg text-gray-900">{{ $registry->date?->format('Y-m-d') ?? '-' }}</p>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Sender</h3>
            <p class="mt-1 text-lg text-gray-900">{{ $registry->sender ?? '-' }}</p>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">Recipient</h3>
            <p class="mt-1 text-lg text-gray-900">{{ $registry->recipient ?? '-' }}</p>
        </div>
        <div class="md:col-span-2">
            <h3 class="text-sm font-medium text-gray-500">Subject</h3>
            <p class="mt-1 text-lg text-gray-900">{{ $registry->subject ?? '-' }}</p>
        </div>
        <div class="md:col-span-2">
            <h3 class="text-sm font-medium text-gray-500">Remarks</h3>
            <p class="mt-1 text-lg text-gray-900">{{ $registry->remarks ?? '-' }}</p>
        </div>
    </div>

    <!-- Files -->
    <div class="px-4 mt-8">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Attachments</h2>

        @if(count($files) > 0)
            <div class="grid sm:grid-cols-2 gap-2">
                @foreach($files as $file)
                    <div class="flex justify-between items-center rounded-lg bg-slate-200 border border-transparent hover:border-slate-300 py-2 px-4">
                        <p>{{ Str::after($file, '_') }}</p>
                        <div class="flex items-center justify-between gap-2">
                            <form method="GET" action="{{ route('registry.file.download', [$registry, basename($file)]) }}">
                                @csrf
                                <button aria-label="download file" type="submit" title="download file">
                                    <x-solar-download-square-bold class="w-6 h-6 text-green-600" />
                                </button>
                            </form>
                            <form method="POST" action="{{ route('registry.file.destroy', $registry) }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="filename" value="{{ $file }}">
                                <button title="delete file" aria-label="delete file" type="submit" onclick="return confirm('Delete this file?')">
                                    <x-solar-file-remove-bold class="w-6 h-6 text-red-700" />
                                </button>
                            </form>
                            <a aria-label="view file" title="view file" target="_blank" href="{{ route('registry.file.view', [$registry, basename($file)]) }}">
                                <x-solar-eye-bold class="w-6 h-6 text-blue-600"/>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No attachments.</p>
        @endif
    </div>

    <!-- Actions -->
    <div class="px-4 mt-8 flex gap-3">
        <a href="{{ route('registry.edit', $registry) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
            Edit
        </a>
        <form method="POST" action="{{ route('registry.destroy', $registry) }}">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this entry?')" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                Delete
            </button>
        </form>
    </div>
</x-app-layout>
