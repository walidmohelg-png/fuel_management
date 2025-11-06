@props(['label', 'value' => '-'])

<div class="flex flex-col md:flex-row justify-between items-start border-b border-gray-100 py-2">
    <span class="font-medium text-gray-700">{{ $label }}:</span>
    <span class="text-gray-900">{{ $value ?? '-' }}</span>
</div>
