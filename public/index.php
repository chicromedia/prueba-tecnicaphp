<?php


use App\Library\Bootstrap\Api;

error_reporting( E_ALL );

try
{
    define( 'BASE_PATH', dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
    define( 'APP_PATH', BASE_PATH . 'App/' );

    /**
     * Set Environment
     */
    require_once APP_PATH . "Config/env.php";

    /**
     * Auto Loader
     */
    require_once APP_PATH . "Config/loader.php";
    /**
     * Init MVC Application and send output to client
     */
    $bootstrap = new Api();
    $bootstrap->setup();
    $bootstrap->run();

} catch ( \Exception $e )
{
    echo json_encode( [
        "code" => $e->getCode(),
        "error" => $e->getMessage()
    ] );
}

