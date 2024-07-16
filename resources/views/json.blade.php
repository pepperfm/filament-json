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

    <div class="my-2 text-sm tracking-tight divide-y divide-gray-200 dark:divide-white/10">
        <table
            class="w-full table-auto divide-y divide-gray-200 dark:divide-white/5"
        >
            <thead>
            <tr>
                <th class="px-3 py-2 w-1/2 text-center text-sm font-medium text-gray-700 dark:text-gray-200">Key</th>
                <th class="px-3 py-2 w-1/2 text-center text-sm font-medium text-gray-700 dark:text-gray-200">Value</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-white/5">
            @foreach($getState() as $key => $value)
                <tr class="divide-x divide-gray-200 dark:divide-white/5 rtl:divide-x-reverse">
                    <td class="font-mono py-2">
                        {{ $key }}
                    </td>
                    <td class="font-mono whitespace-normal p-2">
                        @include('filament-json::_partials.nested', ['items' => $value])
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
            <span class="inline-block py-2 pr-1 mr-1 font-bold text-gray-700 whitespace-normal rounded-md dark:text-gray-200 bg-gray-500/10">
                {{ $key }} :
            </span>
            @include('filament-json::_partials.nested', ['items' => $value])
            {{--@if(is_array($value) || $value instanceof \Illuminate\Contracts\Support\Arrayable)
                @include('filament-json::_partials.nested', ['items' => $value])
            @else
                <span class="whitespace-normal">{{ $applyLimit($value) }}</span>
            @endif--}}
        </p>
    @endforeach
</div>
@endif
