<?php

namespace Cli\Providers;

use Phalcon\Cli\Dispatcher;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class CliDispatcherProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     */
    public function register( DiInterface $di ): void
    {
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace( "Cli\Tasks" );
        $dispatcher->setDefaultTask( 'main' );

        $di->set( 'dispatcher', fn() => $dispatcher );
    }
}
