@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-left text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
