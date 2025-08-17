@props([
    'items' => [],
    'depth' => 0,
    'initiallyCollapsed' => 1,
    'maxDepth' => 3,
    'applyLimit' => null,
])

@php
    $isAssoc = is_array($items) && !array_is_list($items);
@endphp

<ul role="tree" class="fj-tree">
    @foreach ($items as $k => $v)
        @php
            $hasChildren = is_array($v) || $v instanceof \Illuminate\Contracts\Support\Arrayable;
            $canNestFurther = $hasChildren && ($depth < $maxDepth);
        @endphp

        <li
            role="treeitem"
            class="fj-tree-item"
            data-fj-node
            x-data="{ open: {{ $depth < $initiallyCollapsed ? 'true' : 'false' }} }"
            :aria-expanded="open.toString()"
            @fj-expand-all.window="open = true"
            @fj-collapse-all.window="open = false"
        >
            <div class="fj-tree-row" style="--fj-depth: {{ $depth }};">
                @if($hasChildren && $canNestFurther)
                    <button type="button" class="fj-tree-toggle" @click="open = !open" aria-label="Toggle">
                        <span class="fj-tree-caret-wrap" :class="{ 'fj-rotate': open }">
                            <x-filament::icon icon="heroicon-m-chevron-right" class="fj-tree-caret"/>
                        </span>
                    </button>
                @else
                    <span class="fj-tree-spacer"></span>
                @endif

                <span class="fj-tree-key">{{ is_string($k) ? $k : $loop->index }}</span>
                <span class="fj-tree-sep">:</span>

                @if ($hasChildren)
                    @if ($canNestFurther)
                        <span class="fj-tree-hint">{{ $isAssoc ? '{…}' : '[…]' }}</span>
                    @else
                        <span class="fj-force-muted">[Data truncated]</span>
                    @endif
                @else
                    <span class="fj-tree-val fj-code">
                        {{ $applyLimit ? $applyLimit($v) : $v }}
                    </span>
                @endif
            </div>

            @if($hasChildren && $canNestFurther)
                <div x-show="open" x-collapse>
                    <div class="fj-nested">
                        @include('filament-json::_partials.tree', [
                            'items' => $v,
                            'depth' => $depth + 1,
                            'initiallyCollapsed' => $initiallyCollapsed,
                            'maxDepth' => $maxDepth,
                            'applyLimit' => $applyLimit,
                        ])
                    </div>
                </div>
            @endif
        </li>
    @endforeach
</ul>
