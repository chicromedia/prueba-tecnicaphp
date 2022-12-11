<?php
declare( strict_types=1 );

namespace App\Library\Bootstrap;

use Exception;
use Phalcon\Di\FactoryDefault;

class Api extends Bootstrap
{
    /**
     * Run the application
     * @return mixed
     */
    public function run()
    {
        return $this->application->handle( $_SERVER[ 'REQUEST_URI' ] );
    }

    /**
     * @throws Exception
     */
    public function setup(): void
    {
        $this->container = new FactoryDefault();
        $providers       = APP_PATH . 'Config/providers.php';

        if ( !file_exists( $providers ) || !is_readable( $providers ) )
        {
            throw new Exception( "File providers {$providers} does not exist or is not readable." );
        }

        $this->providers = require_once $providers;
        parent::setup();
    }
}
