@props(['title', 'color' => 'gray'])

<div class="mb-10 border border-{{ $color }}-200 rounded-lg p-6 bg-{{ $color }}-50">
    <h3 class="text-lg font-bold text-{{ $color }}-700 border-b-2 border-{{ $color }}-300 mb-4 pb-2">
        {{ $title }}
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3">
        {{ $slot }}
    </div>
</div>
