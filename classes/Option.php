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
use Kirby\Toolkit\A;

class Option extends KirbyOption
{
    public function __construct(
        public string|int|float|null $value,
        public bool $disabled = false,
        public string|null $icon = null,
        public string|array|null $info = null,
        string|array|null $text = null,
        public string|array|null $color = null,
        public string|array|null $background = null,
        public string|array|null $image = null
    ) {
        $this->text = $text ?? ['en' => $this->value];
    }


    /**
     * Renders all data for the option
     */
    public function render(ModelWithContent $model): array
    {

        return A::merge(
            Parent::render($model),
            [
                "color" => $this->color,
                "background" => $this->background,
                "image" => $this->image,
            ]
        );
       
    }
}
