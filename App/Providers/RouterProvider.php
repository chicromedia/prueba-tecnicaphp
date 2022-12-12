<?php
declare( strict_types=1 );

namespace App\Providers;

use App\Controllers\UserController;
use App\Library\Middlewares\ExceptionMiddleware;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection as MicroCollection;

class RouterProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     */
    public function register( DiInterface $di ): void
    {
        /** @var Micro $application */
        $application = $di->getShared( 'application' );
        /** @var Manager $eventsManager */
        $eventsManager = $di->getShared( 'eventsManager' );

        $this->attachRoutes( $application );
        $this->attachMiddleware( $application, $eventsManager );
        $application->setEventsManager( $eventsManager );
    }

    /**
     * Attaches the middleware to the application
     * @param Micro $application
     * @param Manager $eventsManager
     */
    private function attachMiddleware( Micro $application, Manager $eventsManager )
    {
        foreach ( $this->getMiddleware() as $class => $function )
        {
            $eventsManager->attach( 'micro', new $class() );
            $application->{$function}( new $class() );
        }
    }

    /**
     * Attaches the routes to the application; lazy loaded
     * @param Micro $app
     */
    private function attachRoutes( Micro $app )
    {
        $collection = new MicroCollection();
        $collection->setHandler( UserController::class, true )
            ->setPrefix( '/users' )
            ->post( "/create", "create" )
            ->put( "/update", "update" )
            ->delete( "/delete/{id}", "delete" );

        $app->mount( $collection );
    }

    /**
     * Returns the array for the middleware with the action to attach
     * @return array
     */
    private function getMiddleware(): array
    {
        return [
            ExceptionMiddleware::class => 'before'
        ];
    }

}
