<?php

namespace Plain\Toggles;

/**
 * Extend from src/Option/Options.php
 * 
 * @package   Plain Toggles Suite
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://plain-solutions.net/
 * @copyright Roman Gsponer
 * @license   https://plain-solutions.net/terms
 */

use Kirby\Option\Options as KirbyOptions;

class Options extends KirbyOptions
{
    public static function factory(array $items = []): static
    {
        $collection = new static();

        foreach ($items as $key => $option) {
            if (is_array($option) === false) {
                //$option needs to be an array
                $option = ["value" => $key, "text" => $option];
            } elseif (($option["value"] ?? "") === "") {
                //Value required a content in any case
                $option["value"] = $key;
            }

            $background = $option["background"] ?? "";
            $color = $option["color"] ?? "";

            //Background is set but not color (set contrast)
            // if (empty($background) && !empty($color)) {
            //     $background = static::getContrastColor(
            //         $color
            //     );
            // }
            
            //Color is set but not background (set contrast)
            if (empty($color) && !empty($background)) {
                $color = static::getContrastColor(
                        $background
                );
            }

            $option['background']   = !empty($background) ? $background : "var(--input-color-background)";
            $option['color']        = !empty($color) ? $color : "var(--input-color-text)";

            $option = Option::factory($option);
            $collection->__set($option->id(), $option);
        }

        return $collection;
    }

    static function getContrastColor(string $hexColor): string
    {

            // hexColor RGB
            $R1 = hexdec(substr($hexColor, 1, 2));
            $G1 = hexdec(substr($hexColor, 3, 2));
            $B1 = hexdec(substr($hexColor, 5, 2));

            // Black RGB
            $blackColor = "#333333";
            $R2BlackColor = hexdec(substr($blackColor, 1, 2));
            $G2BlackColor = hexdec(substr($blackColor, 3, 2));
            $B2BlackColor = hexdec(substr($blackColor, 5, 2));

            // Calc contrast ratio
            $L1 =
                0.2126 * pow($R1 / 255, 2.2) +
                0.7152 * pow($G1 / 255, 2.2) +
                0.0722 * pow($B1 / 255, 2.2);

            $L2 =
                0.2126 * pow($R2BlackColor / 255, 2.2) +
                0.7152 * pow($G2BlackColor / 255, 2.2) +
                0.0722 * pow($B2BlackColor / 255, 2.2);

            $contrastRatio = 0;
            if ($L1 > $L2) {
                $contrastRatio = (int) (($L1 + 0.05) / ($L2 + 0.05));
            } else {
                $contrastRatio = (int) (($L2 + 0.05) / ($L1 + 0.05));
            }

            // If contrast is more than 5, return black color
            if ($contrastRatio > 5) {
                return "#000";
            } else {
                // if not, return white color.
                return "#fff";
            }


    }
}
