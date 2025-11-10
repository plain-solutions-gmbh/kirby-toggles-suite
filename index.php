<?php

use Kirby\Cms\App;

//Cause modification in Commit b0b92b6 (https://github.com/getkirby/kirby//commit/b0b92b6985f4e848f63a40904e1d346190dc5e7d)

if ( version_compare(App::version() ?? '0.0.0', '5.1.3', '>') === true ) {
    throw new Exception('Kirby Toggles Suite requires Kirby 5.1.3 or higher.');
}

@include_once __DIR__ . "/utils/load.php";

use Plain\Helpers\Plugin;

Plugin::load(
    "plain/toggles",
    autoloader: true
);
