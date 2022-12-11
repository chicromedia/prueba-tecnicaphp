<?php

use App\Library\Bootstrap\Tests;

define( "BASE_PATH", dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
const APP_PATH  = BASE_PATH . 'App/';
const TEST_PATH = BASE_PATH . 'Tests/';

try
{
    /**
     * Set Environment
     */
    require_once APP_PATH . "Config/env.php";
    /**
     * Auto Loader
     */
    require_once TEST_PATH . "Config/loader.php";

    $bootstrap = new Tests();
    $bootstrap->setup();
    $bootstrap->run();
} catch ( Exception $ex )
{
    print $ex->getMessage();
}
