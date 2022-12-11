<?php
declare( strict_types = 1 );

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces( [
    "Cli" => CLI_PATH
] );

$loader->register();
