{{--
@php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\Enums\FontFamily;
    use Filament\Support\Enums\FontWeight;
    use Filament\Support\Enums\IconPosition;
    use Filament\Tables\Columns\TextColumn\TextColumnSize;

    $alignment = $getAlignment();
    $canWrap = $canWrap();
    $descriptionAbove = $getDescriptionAbove();
    $descriptionBelow = $getDescriptionBelow();
    $iconPosition = $getIconPosition();
    $isBadge = $isBadge();
    $isBulleted = $isBulleted();
    $isListWithLineBreaks = $isListWithLineBreaks();
    $isLimitedListExpandable = $isLimitedListExpandable();

    $url = $getUrl();

    if (!$alignment instanceof Alignment) {
        $alignment = filled($alignment) ? (Alignment::tryFrom($alignment) ?? $alignment) : null;
    }

    $arrayState = $getState();

    if ($arrayState instanceof \Illuminate\Support\Collection) {
        $arrayState = $arrayState->all();
    }

    $listLimit = 1;

    if (is_array($arrayState)) {
        if ($listLimit = $getListLimit()) {
            $limitedArrayStateCount = (count($arrayState) > $listLimit) ? (count($arrayState) - $listLimit) : 0;

            if (!$isListWithLineBreaks) {
                $arrayState = array_slice($arrayState, 0, $listLimit);
            }
        }

        $listLimit ??= count($arrayState);

        if ((!$isListWithLineBreaks) && (!$isBadge)) {
            $arrayState = implode(
                ', ',
                array_map(
                    static fn($value) => $value instanceof \Filament\Support\Contracts\HasLabel ? $value->getLabel() : $value,
                    $arrayState,
                ),
            );
        }
    }

    $arrayState = \Illuminate\Support\Arr::wrap($arrayState);

    /** @var \App\Filament\Admin\Resources\ActivityResource\Pages\ListActivities $page */
    $page = $this;

    $characterLimit = $getCharacterLimit();
@endphp
<div>
@foreach($getState() as $variable => $value)
@if(!empty($value))
    <p>
        <b>{{ $variable }}</b>: @if($characterLimit){{ str($value)->limit($characterLimit) }}@else{{ $value }}@endif
        &nbsp;
    </p>
@endif
@endforeach
</div>
--}}
@php
    // /** @var \App\Filament\Admin\Resources\ActivityResource\Pages\ListActivities $page */
    //     $page = $this;
        $characterLimit = $getCharacterLimit();
        $asModal = $getAsModal();
        $asDrawer = $getAsDrawer();
@endphp
@if($asModal)
<x-filament::modal :slide-over="$asDrawer" width="xl">
    <x-slot name="trigger">
        <x-filament::icon-button icon="heroicon-m-sparkles" />
    </x-slot>

    <div class="my-2 text-sm tracking-tight">
        @foreach($getState() as $key => $value)
            <p class="my-3">
            <span class="inline-block py-2 pr-1 mr-1 font-bold text-gray-700 whitespace-normal rounded-md dark:text-gray-200 bg-gray-500/10">
                {{ $key }} :
            </span>
            @if(is_array($value))
                <span class="whitespace-normal divide-x divide-gray-200 divide-solid dark:divide-gray-700">
                @foreach ($value as $nestedKey => $nestedValue)
                    <span class="inline-block mr-1">
                        {{ $nestedKey }}: {{ is_array($nestedValue) ? json_encode($nestedValue) : $applyLimit($nestedValue) }}
                    </span>
                @endforeach
                </span>
            @else
                <span class="whitespace-normal">{{ $applyLimit($value) }}</span>
            @endif
            </p>
        @endforeach
    </div>
</x-filament::modal>
@else
<div class="my-2 text-sm tracking-tight">
    @foreach($getState() as $key => $value)
        <p class="my-3">
            <span class="inline-block py-2 pr-1 mr-1 font-bold text-gray-700 whitespace-normal rounded-md dark:text-gray-200 bg-gray-500/10">
                {{ $key }} :
            </span>
            @if(is_array($value))
                <span class="whitespace-normal divide-x divide-gray-200 divide-solid dark:divide-gray-700">
                @foreach ($value as $nestedKey => $nestedValue)
                    <span class="inline-block mr-1">
                        {{ $nestedKey }}: {{ is_array($nestedValue) ? json_encode($nestedValue) : $applyLimit($nestedValue) }}
                    </span>
                @endforeach
                </span>
            @else
                <span class="whitespace-normal">{{ $applyLimit($value) }}</span>
            @endif
        </p>
    @endforeach
</div>
@endif
