@php
    $characterLimit = $getCharacterLimit();
    $asModal = $getAsModal();
    $asDrawer = $getAsDrawer();
    $keyColumnLabel = $getKeyColumnLabel();
    $valueColumnLabel = $getValueColumnLabel();
    $buttonConfig = $getButtonConfig();
    $modalConfig = $getModalConfig();
    $maxDepth = 2;
@endphp

@if ($asModal || $asDrawer)
    <x-filament::modal
        :id="$modalConfig->id"
        :icon="$modalConfig->icon"
        :icon-color="$modalConfig->iconColor"
        :alignment="$modalConfig->alignment"
        :width="$modalConfig->width"
        :close-by-clicking-away="$modalConfig->closeByClickingAway"
        :close-by-escaping="$modalConfig->closedByEscaping"
        :close-button="$modalConfig->closedButton"
        :slide-over="$asDrawer && !$asModal"
    >
        <x-slot name="trigger">
            <x-filament::icon-button
                :color="$buttonConfig->color"
                :icon="$buttonConfig->icon"
                :label="$buttonConfig->label"
                :tooltip="$buttonConfig->tooltip"
                :size="$buttonConfig->size"
                :href="$buttonConfig->href"
                :tag="$buttonConfig->tag"
            />
        </x-slot>

        <div class="fj fj-scope">
            <table class="fj-table fj-body">
                <thead>
                <tr>
                    <th class="fj-thead-th fj-force-muted w-1/2">{{ $keyColumnLabel }}</th>
                    <th class="fj-thead-th fj-force-muted w-1/2">{{ $valueColumnLabel }}</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($getState() as $key => $value)
                    <tr class="fj-row">
                        <td class="fj-cell fj-force-fg px-3 py-2">{{ $key }}</td>
                        <td class="fj-cell fj-force-fg">
                            @if (is_array($value) || $value instanceof \Illuminate\Contracts\Support\Arrayable)
                                <div class="fj-nested">
                                    @include('filament-json::_partials.nested', [
                                        'items' => $value,
                                        'depth' => 1,
                                        'maxDepth' => $maxDepth,
                                    ])
                                </div>
                            @else
                                <span class="whitespace-normal">{{ $applyLimit($value) }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::modal>
@else
    <div class="fj fj-scope">
        @foreach ($getState() as $key => $value)
            <p class="my-3">
                <span class="fj-key-badge">{{ $key }} :</span>
                @if (is_array($value) || $value instanceof \Illuminate\Contracts\Support\Arrayable)
                    <span class="fj-nested inline-block align-top">
                        @include('filament-json::_partials.nested', ['items' => $value])
                    </span>
                @else
                    <span class="fj-force-fg whitespace-normal">{{ $applyLimit($value) }}</span>
                @endif
            </p>
        @endforeach
    </div>
@endif
