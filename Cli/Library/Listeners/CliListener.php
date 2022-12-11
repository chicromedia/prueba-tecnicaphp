<?php

namespace Cli\Library\Listeners;

use Phalcon\Cli\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream as StreamAdapter;
use Phalcon\Logger\Formatter\Line;


class CliListener
{
    private string $format = "D, d M y H:i:s";

    public function __construct() {}

    public function beforeHandleTask( Event $event, $console )
    {
        /** @var Dispatcher $dispatcher */
        $dispatcher = $event->getData();
        $handler    = $dispatcher->getTaskName();
        $action     = $dispatcher->getActionName() ?: "main";

        if ( $handler )
        {
            $formatter = new Line();
            $formatter->setDateFormat( $this->format );

            $adapter = new StreamAdapter( 'php://stderr' );
            $adapter->setFormatter( $formatter );

            $logger = new Logger( 'cli', [ 'main' => $adapter ] );
            $logger->info( sprintf( "Running task %s:%s", $handler, $action ) );
        }
    }
}
