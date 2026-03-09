@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                @if(is_array($error))
                    @foreach($error as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                @else
                    <li>{{ $error }}</li>
                @endif
            @endforeach
        </ul>
    </div>
@endif
