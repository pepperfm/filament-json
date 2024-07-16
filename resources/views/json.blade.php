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
