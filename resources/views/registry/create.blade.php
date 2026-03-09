<x-app-layout>
    <x-slot name="header">
            <h1 class="font-bold text-gray-700">New Registry Entry</h1>
    </x-slot>

    <div class="px-4 mt-4">
        @include('registry.partials.error', ['errors' => $errors])
    </div>

    <form method="POST" action="{{ route('registry.store') }}" enctype="multipart/form-data" class="px-4 mt-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Reference No -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Reference No *</label>
                <input
                    type="text"
                    name="reference_no"
                    value="{{ old('reference_no') }}"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input
                    type="date"
                    name="date"
                    value="{{ old('date') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Sender -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sender</label>
                <input
                    type="text"
                    name="sender"
                    value="{{ old('sender') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Recipient -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recipient</label>
                <input
                    type="text"
                    name="recipient"
                    value="{{ old('recipient') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <!-- Subject -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
            <textarea
                name="subject"
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >{{ old('subject') }}</textarea>
        </div>

        <!-- Remarks -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
            <textarea
                name="remarks"
                rows="2"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >{{ old('remarks') }}</textarea>
        </div>

        <!-- File Upload -->
        <div class="mb-10">
            <label class="block text-sm font-medium text-gray-700 mb-2">Attachments</label>
            <div id="fileClickzone"
                class="flex flex-col items-center justify-center gap-3 text-center border-2 border-dashed border-gray-300 bg-gray-100 min-h-[180px] rounded-xl p-8 transition-all cursor-pointer hover:bg-gray-200">
                <x-solar-upload-square-bold class="w-8 h-8 " />
                <p class="text-gray-700 font-medium">Click to select files</p>
                <small class="text-gray-500">Max: 10MB per file</small>
                <small class="text-gray-500">Allowed: PDF, DOC, DOCX, JPG, JPEG, PNG</small>
                <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="hidden" />
            </div>
            @include('registry.partials.error', ['name' => 'files.*'])

            <!-- Files Preview -->
            <div id="filesList" class="mt-4 space-y-2"></div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('registry.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Save
            </button>
        </div>
    </form>
</x-app-layout>
