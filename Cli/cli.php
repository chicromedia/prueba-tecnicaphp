<?php
declare( strict_types = 1 );

use App\Library\Bootstrap\Cli;
use Phalcon\Migrations\Console\Color;

define( "BASE_PATH", dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
const APP_PATH = BASE_PATH . 'App/';
const CLI_PATH = BASE_PATH . 'Cli/';

try
{
    /**
     * Set Environment
     */
    require_once APP_PATH . "Config/env.php";
    /**
     * Auto Loader
     */
    require_once CLI_PATH . "Config/loader.php";

    $cli = new Cli();
    $cli->setup();
    $cli->run();
}
catch ( Exception $e )
{
    echo Color::colorize( $e->getMessage(), Color::FG_RED );
    exit( 1 );
}
