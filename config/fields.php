<?php

use Plain\Toggles\FieldOptions;
use Plain\Helpers\License;
use Kirby\Toolkit\A;
use Kirby\Cms\App;
use Kirby\Filesystem\F;

$app = App::instance();

//Extend 'toggles' manually, cause mixin will be overwritten.
$type = F::load(
	$app->root('kirby') . '/config/fields/toggles.php',
	allowOutput: false
);

return ['toggles' => A::merge($type, [
	'props'	=> [
		'grow' => function (bool $grow = true) {
			if ($this->hasImages()) {
				return true;
			}
			return $grow;
		},
		'images' => function (array $images = []) {
			return $images;
		}
	],
	'computed' => [
		'options' => function (): array {
			return $this->getOptions();
		},
		'hasImages' => function (): bool {
			return $this->hasImages();
		},
		'images' => function (): array {
			return A::merge([
				'caption'		=> true,
				'ratio'			=> "4/1",
				'fit'			=> "contain",
				'spacing'		=> 1
			], $this->images);
		}
	],
	'methods' => [
		'hasImages' => function (): bool {
			$imageCount = A::filter(
				$this->options,
				fn($item) => !empty($item["image"] ?? '')
			);
			return count($imageCount) > 0;
		},
		'getOptions' => function () {
			$props   = FieldOptions::polyfill($this->props);
			$options = FieldOptions::factory($props['options']);
			return $options->render($this->model());
		}
	]
])];