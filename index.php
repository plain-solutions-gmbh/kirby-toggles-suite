<?php

use Kirby\Cms\App;
use Kirby\Filesystem\F;

F::loadClasses([
    'Plain\Toggles\FieldOptions' => __DIR__ . '/classes/FieldOptions.php',
    'Plain\Toggles\Option' => __DIR__ . '/classes/Option.php',
    'Plain\Toggles\Options' => __DIR__ . '/classes/Options.php',
    'Plain\Toggles\OptionsQuery' => __DIR__ . '/classes/OptionsQuery.php',
]);

App::plugin('plain/toggles', [
    'fields' => require __DIR__ . '/config/fields.php',
]);


