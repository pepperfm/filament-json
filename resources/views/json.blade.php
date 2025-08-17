@php
    use PepperFM\FilamentJson\Enums\RenderModeEnum;
    use PepperFM\FilamentJson\Enums\ContainerModeEnum;

    $characterLimit = $getCharacterLimit();
    $asModal = $getAsModal();
    $asDrawer = $getAsDrawer();

    $keyColumnLabel = $getKeyColumnLabel();
    $valueColumnLabel = $getValueColumnLabel();

    /** @var \PepperFM\FilamentJson\Dto\ButtonConfigDto $buttonConfig */
    $buttonConfig = $getButtonConfig();
    /** @var \PepperFM\FilamentJson\Dto\ModalConfigDto $modalConfig */
    $modalConfig = $getModalConfig();

    /** @var RenderModeEnum $renderMode */
    $renderMode = $getRenderMode();
    /** @var int $initiallyCollapsed */
    $initiallyCollapsed = $getInitiallyCollapsed();
    /** @var bool $expandAllToggle */
    $expandAllToggle = $getExpandAllToggle();
    /** @var bool $copyJsonAction */
    $copyJsonAction = $getCopyJsonAction();
    /** @var int $maxDepth */
    $maxDepth = $getMaxDepth();
    /** @var bool $showHeaders */
    $showHeaders = $getShowHeaders();

    $showExpandCollapse = $renderMode === RenderModeEnum::Tree && $expandAllToggle;
    $showCopy = $copyJsonAction;

    $stateForJs = $getState();

    /** @var ContainerModeEnum|null $containerMode */
    $containerMode = method_exists($this, 'getContainerMode') ? $this->getContainerMode() : null;
    $isInlineContainer = $containerMode === ContainerModeEnum::Inline;

    $rawJson = is_string($stateForJs)
        ? $stateForJs
        : json_encode($stateForJs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
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

        <div
            class="fj fj-scope"
            x-data="{
                raw: @js($stateForJs),
                async copyJson() {
                    const text = typeof this.raw === 'string'
                        ? this.raw
                        : JSON.stringify(this.raw, null, 2);

                    try {
                        if (navigator.clipboard && (location.protocol === 'https:' || location.hostname === 'localhost')) {
                            await navigator.clipboard.writeText(text);
                        } else {
                            const ta = document.createElement('textarea');
                            ta.value = text;
                            ta.style.position = 'fixed';
                            ta.style.inset = '0';
                            document.body.appendChild(ta);
                            ta.focus(); ta.select();
                            document.execCommand('copy');
                            ta.remove();
                        }
                        new FilamentNotification()
                            .title('Copied!')
                            .icon('heroicon-o-clipboard-document-check')
                            .success()
                            .send()
                    } catch (e) {
                        new FilamentNotification()
                            .title('Copy failed!')
                            .danger()
                            .send()
                    }
                }
            }"
        >
            @if ($showExpandCollapse || $showCopy)
                <div class="fj fj-scope flex items-center justify-end gap-2">
                    @if ($showExpandCollapse)
                        <x-filament::button size="xs" color="gray" x-on:click="$dispatch('fj-expand-all')">
                            Expand all
                        </x-filament::button>
                        <x-filament::button size="xs" color="gray" x-on:click="$dispatch('fj-collapse-all')">
                            Collapse all
                        </x-filament::button>
                    @endif

                    @if ($showCopy)
                        <x-filament::button size="xs" color="gray" x-on:click="copyJson()">
                            Copy JSON
                        </x-filament::button>
                    @endif
                </div>
            @endif

            @includeWhen($renderMode === RenderModeEnum::Tree, 'filament-json::_partials.tree', [
                'items' => $getState(),
                'depth' => 0,
                'initiallyCollapsed' => $initiallyCollapsed,
                'applyLimit' => $applyLimit,
            ])

            @if ($renderMode === RenderModeEnum::Table)
                <table class="fj-table">
                    <thead>
                    <tr>
                        <th class="fj-thead-th w-1/2">{{ $keyColumnLabel }}</th>
                        <th class="fj-thead-th w-1/2">{{ $valueColumnLabel }}</th>
                    </tr>
                    </thead>
                    <tbody class="fj-body">
                    @foreach ($getState() as $key => $value)
                        <tr class="fj-row">
                            <td class="fj-cell px-3 py-2">{{ $key }}</td>
                            <td class="fj-cell">
                                @if (is_array($value) || $value instanceof \Illuminate\Contracts\Support\Arrayable)
                                    <div class="fj-nested">
                                        @include('filament-json::_partials.nested', [
                                            'items' => $value,
                                            'depth' => 1,
                                            'maxDepth' => $maxDepth,
                                            'applyLimit' => $applyLimit,
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
            @endif
        </div>
    </x-filament::modal>
@else
    <div
        class="fj fj-scope"
        x-data="{
            text: @js($rawJson),
            async copyJson() {
                try {
                    if (navigator.clipboard && (location.protocol === 'https:' || location.hostname === 'localhost')) {
                        await navigator.clipboard.writeText(this.text);
                    } else {
                        const ta = document.createElement('textarea');
                        ta.value = this.text;
                        ta.style.position = 'fixed'; ta.style.inset = '0';
                        document.body.appendChild(ta); ta.focus(); ta.select();
                        document.execCommand('copy'); ta.remove();
                    }
                    new FilamentNotification()
                        .title('Copied!')
                        .icon('heroicon-o-clipboard-document-check')
                        .success()
                        .send()
                } catch (e) {
                    new FilamentNotification().title('Copy failed!').danger().send()
                }
            }
        }"
    >
        @if ($copyJsonAction)
            <pre
                class="fj-code fj-raw fj-raw-interactive"
                role="button"
                tabindex="0"
                aria-label="Copy JSON"
                title="Click to copy"
                x-on:click="copyJson()"
                x-on:keydown.enter.prevent="copyJson()"
                x-on:keydown.space.prevent="copyJson()"
            >{{ $rawJson }}</pre>
        @else
            <pre class="fj-code fj-raw">{{ $rawJson }}</pre>
        @endif
    </div>
@endif
