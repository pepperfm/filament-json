@props([
    'items' => [],
    'depth' => 1,
    'maxDepth' => 3,
])

@php
    $isNestingEnabled = $depth < $maxDepth;
@endphp

<div class="fj-scope">
    @foreach ($items as $nestedKey => $nestedValue)
        <div class="fj-pair">
            <span class="fj-pair-key">{{ is_string($nestedKey) ? $nestedKey : $loop->index }}</span>

            <div class="fj-pair-value">
                @if (is_array($nestedValue) || $nestedValue instanceof \Illuminate\Contracts\Support\Arrayable)
                    @if ($isNestingEnabled)
                        <div class="fj-nested">
                            @include('filament-json::_partials.nested', [
                                'items' => $nestedValue,
                                'depth' => $depth + 1,
                                'maxDepth' => $maxDepth,
                            ])
                        </div>
                    @else
                        <span class="fj-force-muted">[Data truncated]</span>
                    @endif
                @else
                    <span class="fj-code">{{ $applyLimit($nestedValue) }}</span>
                @endif
            </div>
        </div>
    @endforeach
</div>
