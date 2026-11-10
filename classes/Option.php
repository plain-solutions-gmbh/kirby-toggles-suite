<?php

namespace Plain\Toggles;

/**
 * Extend from src/Option/Option.php
 * 
 * @package   Plain Toggles Suite
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://github.com/plain-solutions-gmbh/
 * @copyright Roman Gsponer
 * @license   MIT
 */

use Kirby\Option\Option as KirbyOption;
use Kirby\Toolkit\HtmlString;

use Kirby\Cms\ModelWithContent;
use Kirby\Toolkit\A;

class Option extends KirbyOption
{
    public function __construct(
        public string|int|float|null $value,
        public bool $disabled = false,
        public string|null $icon = null,
        public HtmlString|string|array|null $info = null,
        HtmlString|string|array|null $text = null,
        public string|array|null $color = null,
        public string|array|null $background = null,
        public string|array|null $image = null,
        public bool $resolve = true
    ) {
        $this->text = $text ?? ['en' => $this->value];
    }


     /**
     * Renders all data for the option
     */
    public function render(ModelWithContent $model, bool $safeMode = true): array
    {

        return A::merge(
            parent::render($model, $safeMode),
            [
                "color" => $this->color,
                "background" => $this->background,
                "image" => $this->image,
            ]
        );
       
    }
}
