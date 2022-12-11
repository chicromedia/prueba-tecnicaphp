<?php
declare( strict_types = 1 );

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces( [
    "App" => APP_PATH
] );

$loader->register();
