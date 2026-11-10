<?php

namespace Plain\Toggles;

/**
 * @package   Plain Toggles Suite
 * @author    Roman Gsponer <kirby@plain-solutions.net>
 * @link      https://github.com/plain-solutions-gmbh/
 * @copyright Roman Gsponer
 * @license   MIT
 */

use Kirby\Cms\Block;
use Kirby\Option\OptionsQuery as KirbyOptionsQuery;

use Kirby\Toolkit\Collection;
use Kirby\Cms\ModelWithContent;
use Kirby\Cms\StructureObject;
use Kirby\Cms\User;
use Kirby\Cms\File;
use Kirby\Cms\Page;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Toolkit\Obj;

//Extend from src/Option/OptionsQuery.php
class OptionsQuery extends KirbyOptionsQuery
{
    public function __construct(
        public string $query,
        public string|null $text = null,
        public string|null $value = null,
        public string|null $icon = null,
        public string|null $info = null,
        public string|null $color = null,
        public string|null $background = null,
        public string|null $image = null
    ) {
    }

    public static function factory(string|array $props): static
    {
        if (is_string($props) === true) {
            return new static(query: $props);
        }

        return new static(
            query: $props["query"] ?? $props["fetch"],
            text: $props["text"] ?? null,
            value: $props["value"] ?? null,
            icon: $props["icon"] ?? null,
            info: $props["info"] ?? null,
            color: $props["color"] ?? null,
            background: $props["background"] ?? null,
            image: $props["image"] ?? null
        );
    }

    protected function itemToDefaults(array|object $item): array
    {
        return match (true) {
            is_array($item), $item instanceof Obj => [
                "arrayItem",
                "{{ item.text }}",
                "{{ item.value }}",
                "{{ item.icon }}",
                "{{ item.color }}",
                "{{ item.background }}",
                "{{ item.image }}",
            ],
            $item instanceof StructureObject => [
                "structureItem",
                "{{ item.title }}",
                "{{ item.id }}",
                "{{ item.icon }}",
                "{{ item.color }}",
                "{{ item.background }}",
                "{{ item.image }}",
            ],
            $item instanceof Block => [
                "block",
                "{{ block.type }}: {{ block.id }}",
                "{{ block.id }}",
                "{{ block.content.icon }}",
                "{{ block.content.color }}",
                "{{ block.content.background }}",
                "{{ block.content.image }}",
            ],
            $item instanceof Page => [
                "page",
                "{{ page.title }}",
                "{{ page.id }}",
                "{{ page.icon }}",
                "{{ page.color }}",
                "{{ page.background }}",
                "{{ page.image }}",
            ],
            $item instanceof File => [
                "file",
                "{{ file.filename }}",
                "{{ file.id }}",
                "{{ file.icon }}",
                "{{ file.color }}",
                "{{ file.background }}",
                "{{ file.image }}",
            ],
            $item instanceof User => [
                "user",
                "{{ user.username }}",
                "{{ user.email }}",
                "{{ user.icon }}",
                "{{ user.color }}",
                "{{ user.background }}",
                "{{ user.image }}",
            ],
            default => [
                "item",
                "{{ item.value }}",
                "{{ item.value }}",
                "{{ item.icon }}",
                "{{ item.color }}",
                "{{ item.background }}",
                "{{ item.image }}",
            ]
        };
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

        // run query
        $result = $model->query($this->query);

        // the query already returned an options collection
        if ($result instanceof Options) {
            return $result;
        }

        // convert result to a collection
        if (is_array($result) === true) {
            $result = $this->collection($result);
        }

        if ($result instanceof Collection === false) {
            $type = is_object($result) === true ? $result::class : gettype($result);

            throw new InvalidArgumentException(
                message: "Invalid query result data: " . $type
            );
        }

        // create options array
        // text is only a raw string when using {< >}
        // or when the safe mode is explicitly disabled (select field)
        $safeMethod = $safeMode === true ? "toSafeHtmlString" : "toString";

        $options = $result->toArray(function ($item) use ($model, $safeMethod) {
            // get defaults based on item type
            [
                $alias,
                $text,
                $value,
                $icon,
                $color,
                $background,
                $image
            ] = $this->itemToDefaults($item);
            $data = ["item" => $item, $alias => $item];

            // value is always a raw string
            $value = $model->toString($this->value ?? $value, $data);
            $icon = $model->toString($this->icon ?? $icon, $data);
            $color = $model->toString($this->color ?? $color, $data);
            $background = $model->toString(
                $this->background ?? $background,
                $data
            );
            $image = $model->toString($this->image ?? $image, $data);
            $info = $this->info !== null ? $model->$safeMethod($this->info, $data) : null;

            $text = $model->$safeMethod($this->text ?? $text, $data);

            return compact("text", "value", "icon", "info", "color", "background", "image");
        });

        // ensure not to resolve Kirby queries again
        return $this->options = Options::factory($options, resolve: false);
    }
}
