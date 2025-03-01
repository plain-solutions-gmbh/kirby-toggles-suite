<?php

namespace Plain\Toggles;

/**
 * Extend from src/Option/Option.php
 * 
 * @package   Plain Toggles Suite
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://plain-solutions.net/
 * @copyright Roman Gsponer
 * @license   https://plain-solutions.net/terms
 */

use Kirby\Option\Option as KirbyOption;

use Kirby\Blueprint\Factory;
use Kirby\Blueprint\NodeIcon;
use Kirby\Blueprint\NodeText;
use Kirby\Cms\ModelWithContent;

class Option extends KirbyOption
{
    public function __construct(
        public string|int|float|null $value,
        public bool $disabled = false,
        public NodeIcon|null $icon = null,
        public NodeText|null $info = null,
        public NodeText|null $text = null,
        public NodeText|null $color = null,
        public NodeText|null $background = null,
        public NodeText|null $image = null
    ) {
        $this->text ??= new NodeText(["en" => $this->value]);
    }

    public static function factory(string|int|float|null|array $props): static
    {
        if (is_array($props) === false) {
            $props = ["value" => $props];
        }

        $props = Factory::apply($props, [
            "icon"          => NodeIcon::class,
            "info"          => NodeText::class,
            "text"          => NodeText::class,
            "color"         => NodeText::class,
            "background"    => NodeText::class,
            "image"         => NodeText::class
        ]);

        return new static(...$props);
    }

    /**
     * Renders all data for the option
     */
    public function render(ModelWithContent $model): array
    {
        return [
            "disabled" => $this->disabled,
            "value" => $this->value ?? "",
            "icon" => $this->icon?->render($model),
            "info" => $this->info?->render($model),
            "text" => $this->text?->render($model),
            "color" => $this->color?->render($model),
            "background" => $this->background?->render($model),
            "image" => $this->image?->render($model),
        ];
    }
}
