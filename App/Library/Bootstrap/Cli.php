<?php

namespace App\Library\Bootstrap;

use Cli\Library\Listeners\CliListener;
use Exception;
use Phalcon\Cli\Console;
use Phalcon\Di\FactoryDefault\Cli as PhCli;
use Phalcon\Events\Manager as EventsManager;

class Cli extends Bootstrap
{
    const COMMAND_TASK   = 1;
    const COMMAND_ACTION = 2;
    const COMMAND_PARAMS = 3;

    /**
     * Run the application
     * @return mixed
     */
    public function run()
    {
        return $this->application->handle( $this->options );
    }

    /**
     * @throws Exception
     */
    public function setup(): void
    {
        $this->container = new PhCli();
        $providers       = CLI_PATH . 'Config/providers.php';

        if ( !file_exists( $providers ) || !is_readable( $providers ) )
        {
            throw new Exception( "File providers {$providers} does not exist or is not readable." );
        }

        $this->providers = require_once $providers;
        $this->processArguments();

        parent::setup();
    }

    /**
     * Setup the application object in the container
     * @return void
     */
    protected function setupApplication(): Bootstrap
    {
        $this->application = new Console( $this->container );
        $this->container->setShared( 'console', $this->application );

        $eventsManager = new EventsManager();
        $eventsManager->attach( 'console', new CliListener() );
        $this->application->setEventsManager( $eventsManager );
        return $this;
    }

    /**
     * Parses arguments from the command line
     */
    private function processArguments()
    {
        $this->options = [];
        foreach ( $_SERVER[ 'argv' ] as $index => $arg )
        {
            switch ( $index )
            {
                case self::COMMAND_TASK:
                    $this->options[ 'task' ] = $arg;
                    break;
                case self::COMMAND_ACTION:
                    $this->options[ 'action' ] = $arg;
                    break;
                case self::COMMAND_PARAMS:
                    $arg                         = str_replace( "--", "", $arg );
                    $this->options[ 'params' ][] = $arg;
                    break;
            }
        }
    }
}
