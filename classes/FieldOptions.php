<?php

namespace Plain\Toggles;

/**
 * 
 * Extend from src/Field/FieldOptions.php
 * 
 * @package   Plain Toggles Suite
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://plain-solutions.net/
 * @copyright Roman Gsponer
 * @license   https://plain-solutions.net/terms
 */

use Kirby\Field\FieldOptions as KirbyFieldOptions;

class FieldOptions extends KirbyFieldOptions
{
    public static function factory(array $props, bool $safeMode = true): static
    {
        
        $options = match ($props["type"]) {
            "query" => OptionsQuery::factory($props),
            "api" => OptionsApi::factory($props),
            default => Options::factory($props["options"] ?? [])
        };

        return new static($options, $safeMode);
    }

}
