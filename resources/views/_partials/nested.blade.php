@props([
    'items' => [],
])

<span class="whitespace-normal divide-x divide-gray-200 divide-solid dark:divide-gray-700">
@foreach ($items as $nestedKey => $nestedValue)
    <span class="inline-block mr-1">
        {{ $nestedKey }}:
        @if(is_array($nestedValue) || $nestedValue instanceof \Illuminate\Contracts\Support\Arrayable)
            @include('filament-json::_partials.nested', ['items' => $nestedValue])
        @else
            {{ $applyLimit($nestedValue) }}
        @endif
    </span>
@endforeach
</span>
