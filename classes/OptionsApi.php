<?php

namespace Plain\Toggles;

/**
 * Extend from src/Option/OptionsApi.php
 * 
 * @package   Plain Toggles Suite
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://plain-solutions.net/
 * @copyright Roman Gsponer
 * @license   https://plain-solutions.net/terms
 */

use Kirby\Option\OptionsApi as KirbyOptionsApi;

use Kirby\Cms\ModelWithContent;
use Kirby\Cms\Nest;
use Kirby\Content\Field;
use Kirby\Exception\NotFoundException;
use Kirby\Query\Query;

class OptionsApi extends KirbyOptionsApi
{
    public function __construct(
        public string $url,
        public string|null $query,
        public string|null $text = null,
        public string|null $value = null,
        public string|null $icon = null,
        public string|null $color = null,
        public string|null $background = null,
        public string|null $image = null
    ) {
    }

    public static function factory(string|array $props): static
    {

        return new static(
            url: $props["url"],
            query: $props["query"] ?? ($props["fetch"] ?? null),
            text: $props["text"] ?? null,
            value: $props["value"] ?? null,
            icon: $props["icon"] ?? null,
            color: $props["color"] ?? null,
            background: $props["background"] ?? null,
            image: $props["image"] ?? null
        );
    }

    public function resolve(
        ModelWithContent $model,
        bool $safeMode = true
    ): Options {
        // use cached options if present
        // @codeCoverageIgnoreStart
        if ($this->options !== null) {
            return $this->options;
        }
        // @codeCoverageIgnoreEnd

        // apply property defaults
        $this->defaults();

        // load data from URL and convert from JSON to array
        $data = $this->load($model);

        // @codeCoverageIgnoreStart
        if ($data === null) {
            throw new NotFoundException(
                "Options could not be loaded from API: " .
                    $model->toSafeString($this->url)
            );
        }
        // @codeCoverageIgnoreEnd

        // turn data into Nest so that it can be queried
        // or field methods applied to the data
        $data = Nest::create($data);

        // optionally query a substructure inside the data array
        $data = Query::factory($this->query)->resolve($data);
        $options = [];

        // create options by resolving text and value query strings
        // for each item from the data
        foreach ($data as $key => $item) {
            // convert simple `key: value` API data
            if (is_string($item) === true) {
                $item = new Field(null, $key, $item);
            }

            $safeMethod = $safeMode === true ? "toSafeString" : "toString";

            $options[] = [
                // value is always a raw string
                "value" => $model->toString($this->value, ["item" => $item]),
                "icon" => $model->toString($this->icon, ["item" => $item]),
                "color" => $model->toString($this->color, ["item" => $item]),
                "background" => $model->toString($this->background, [
                    "item" => $item,
                ]),
                "text" => $model->$safeMethod($this->text, ["item" => $item]),
                "image" => $model->$safeMethod($this->image, ["item" => $item]),
            ];
        }

        // create Options object and render this subsequently
        return $this->options = Options::factory($options);
    }
}
