@php
    /** @var ?int $characterLimit */
    $characterLimit = $getCharacterLimit();
    /** @var bool $asModal */
    $asModal = $getAsModal();
    /** @var bool $asDrawer */
    $asDrawer = $getAsDrawer();

    /** @var string $keyColumnLabel */
    $keyColumnLabel = $getKeyColumnLabel();
    /** @var string $valueColumnLabel */
    $valueColumnLabel = $getValueColumnLabel();

    /** @var \PepperFM\FilamentJson\Dto\ButtonConfigDto $buttonConfig */
    $buttonConfig = $getButtonConfig();
    /** @var \PepperFM\FilamentJson\Dto\ModalConfigDto $modalConfig */
    $modalConfig = $getModalConfig();

    $maxDepth = 2;
@endphp
@if($asModal || $asDrawer)
    <x-filament::modal
        :id="$modalConfig->id"
        :icxon="$modalConfig->icon"
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

        <div class="my-2 text-sm tracking-tight divide-y divide-gray-200 dark:divide-white/10">
            <table class="w-full table-auto divide-y divide-gray-200 dark:divide-white/5">
                <thead>
                    <tr>
                        <th class="px-3 py-2 w-1/2 text-center text-sm font-medium text-gray-700 dark:text-gray-200">
                            {{ $keyColumnLabel }}
                        </th>
                        <th class="px-3 py-2 w-1/2 text-center text-sm font-medium text-gray-700 dark:text-gray-200">
                            {{ $valueColumnLabel }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                @foreach($getState() as $key => $value)
                    <tr class="divide-x divide-gray-200 dark:divide-white/5 rtl:divide-x-reverse">
                        <td class="font-mono py-2 ">{{ $key }}</td>
                        <td class="font-mono whitespace-normal p-2 border-b border-gray-300 dark:border-white">
                            @if(is_array($value) || $value instanceof \Illuminate\Contracts\Support\Arrayable)
                                <div class="nested-value-container p-2 border border-gray-200 dark:border-gray-600 rounded-md mt-2">
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
    <div class="my-2 text-sm tracking-tight">
        @foreach($getState() as $key => $value)
            <p class="my-3">
            <span
                class="inline-block py-2 pr-1 mr-1 font-bold text-gray-700 whitespace-normal rounded-md dark:text-gray-200 bg-gray-500/10">
                {{ $key }} :
            </span>
                @if(is_array($value) || $value instanceof \Illuminate\Contracts\Support\Arrayable)
                    @include('filament-json::_partials.nested', ['items' => $value])
                @else
                    <span class="whitespace-normal">{{ $applyLimit($value) }}</span>
                @endif
            </p>
        @endforeach
    </div>
@endif
