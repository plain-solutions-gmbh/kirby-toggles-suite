<?php

namespace Plain\Toggles;

/**
 * Extends the core toggles field with colors and images
 *
 * @package   Plain Toggles Suite
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://github.com/plain-solutions-gmbh/
 * @copyright Roman Gsponer
 * @license   MIT
 */

use Kirby\Form\Field\TogglesField as KirbyTogglesField;
use Kirby\Reflection\Attributes\Prop;
use Kirby\Toolkit\A;

class TogglesField extends KirbyTogglesField
{
    /**
     * Settings for the option images (caption, ratio, fit, spacing, background)
     */
    #[Prop]
    protected array $images = [];

    /**
     * Options with images always span the full width
     */
    public function grow(): bool
    {
        return $this->hasImages() === true ? true : parent::grow();
    }

    public function hasImages(): bool
    {
        $images = A::filter(
            $this->options(),
            fn ($item) => empty($item['image'] ?? '') === false
        );

        return count($images) > 0;
    }

    public function images(): array
    {
        return A::merge([
            'caption' => true,
            'ratio'   => '4/1',
            'fit'     => 'contain',
            'spacing' => 1
        ], $this->images);
    }

    public function props(): array
    {
        return [
            ...parent::props(),
            'hasImages' => $this->hasImages()
        ];
    }

    /**
     * Resolves the options with the extended
     * option classes (color, background, image)
     */
    protected function fetchOptions(): array
    {
        $props   = FieldOptions::polyfill(['options' => $this->options ?? []]);
        $options = FieldOptions::factory($props['options']);
        return $options->render($this->model());
    }
}
