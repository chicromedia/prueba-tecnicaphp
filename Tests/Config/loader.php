<?php
declare( strict_types=1 );

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces( [
    "Tests" => TEST_PATH,
    "Cli" => CLI_PATH
] );

$loader->register();
