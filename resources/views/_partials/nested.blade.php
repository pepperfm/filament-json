@props([
    'items' => [],
    'depth' => 1,
    'maxDepth' => 3,
])

@php
    $isNestingEnabled = $depth < $maxDepth;
@endphp

<div>
    @foreach ($items as $nestedKey => $nestedValue)
        <div
            @class([
                'block' => !$isNestingEnabled,
                'flex' => $isNestingEnabled,
                'justify-center p-4 my-2 shadow border border-gray-300 dark:border-gray-600 rounded-md',
           ])
        >
            @if($loop->index !== $nestedKey)
                <pre
                    @class([
                        'block border-b border-gray-200 dark:border-gray-600' => !$isNestingEnabled,
                   ])
                >{{ $nestedKey }}: </pre>
            @endif
            @if (is_array($nestedValue) || $nestedValue instanceof \Illuminate\Contracts\Support\Arrayable)
                @if ($isNestingEnabled)
                    <div class="p-2 border border-gray-200 dark:border-gray-600 rounded-md mt-2">
                        @include('filament-json::_partials.nested', [
                            'items' => $nestedValue,
                            'depth' => $depth + 1,
                            'maxDepth' => $maxDepth,
                        ])
                    </div>
                @else
                    <span class="text-gray-500">[Data truncated]</span>
                @endif
            @else
                <pre>{{ $applyLimit($nestedValue) }}</pre>
            @endif
        </div>
    @endforeach
</div>
