<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Columns;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class JsonColumn extends TextColumn
{
    protected string $view = 'filament-json::json';

    protected bool|\Closure $isHtml = true;

    protected bool $asModal = false;

    protected bool $asDrawer = false;

    public function applyLimit(array|string|null $value): array|string|null|\Illuminate\Support\Stringable
    {
        if (is_string($value)) {
            $characterLimit = $this->getCharacterLimit();

            return $characterLimit ? str($value)->limit($characterLimit) : $value;
        }

        return $value;
    }

    public function asModal(bool $condition = true): static
    {
        $this->asModal = $condition;

        return $this;
    }

    public function asDrawer(bool $condition = true): static
    {
        $this->asModal = $condition;
        $this->asDrawer = $condition;

        return $this;
    }

    public function getAsModal(): bool
    {
        return $this->evaluate($this->asModal);
    }

    public function getAsDrawer(): bool
    {
        return $this->evaluate($this->asDrawer);
    }

    public function getState(): mixed
    {
        if (!$this->getRecord()) {
            return null;
        }
        $listLimit = $this->getListLimit();

        $state = ($this->getStateUsing !== null) ?
            $this->evaluate($this->getStateUsing) :
            $this->getStateFromRecord();

        if (is_string($state) && ($separator = $this->getSeparator())) {
            $state = explode($separator, $state);
            $state = (count($state) === 1 && blank($state[0])) ?
                [] :
                $state;
        }

        if (blank($state)) {
            $state = $this->getDefaultState();
        }

        if ($state instanceof Collection) {
            $state = $state->filter()->take($listLimit);
        }
        if (is_array($state)) {
            $state = collect($state)->filter()->take($listLimit);
        }

        return $state;
    }

    // public function formatState(mixed $state): HtmlString
    // {
    //     $html = '';
    //     $isHtml = $this->isHtml();
    //     /** @var \Illuminate\Support\Collection $stateCollection */
    //     $stateCollection = $this->getState()->sliding(1);
    //     // $listLimit = $this->getListLimit();
    //     // foreach (range(1, $listLimit) as $key => $listRow) {
    //     foreach ($this->getState() as $key => $item) {
    //         // $item = $stateCollection->get($key)->first();
    //         // $jsonKey = $stateCollection->get($key)->keys()->first();
    //         $newState = $this->evaluate($this->formatStateUsing ?? $item, [
    //             'state' => $item,
    //         ]);
    //
    //         if ($characterLimit = $this->getCharacterLimit()) {
    //             $newState = Str::limit($item, $characterLimit, $this->getCharacterLimitEnd());
    //         }
    //         if ($wordLimit = $this->getWordLimit()) {
    //             $newState = Str::words($item, $wordLimit, $this->getWordLimitEnd());
    //         }
    //         if ($isHtml && $this->isMarkdown()) {
    //             $newState = Str::markdown($item);
    //         }
    //
    //         $prefix = $this->getPrefix();
    //         $suffix = $this->getSuffix();
    //
    //         if (
    //             (($prefix instanceof Htmlable) || ($suffix instanceof Htmlable)) &&
    //             (!$isHtml)
    //         ) {
    //             $isHtml = true;
    //             $newState = e($newState);
    //         }
    //         if (filled($prefix)) {
    //             if ($prefix instanceof Htmlable) {
    //                 $prefix = $prefix->toHtml();
    //             } elseif ($isHtml) {
    //                 $prefix = e($prefix);
    //             }
    //
    //             $newState = $prefix . $newState;
    //         }
    //         if (filled($suffix)) {
    //             if ($suffix instanceof Htmlable) {
    //                 $suffix = $suffix->toHtml();
    //             } elseif ($isHtml) {
    //                 $suffix = e($suffix);
    //             }
    //
    //             $newState .= $suffix;
    //         }
    //         if (!empty($newState)) {
    //             $html .= "
    //                 <p>
    //                     <b>$key</b>: $newState
    //                     &nbsp;
    //                 </p>
    //             ";
    //         }
    //     }
    //
    //     return new HtmlString($html);
    // }
}
