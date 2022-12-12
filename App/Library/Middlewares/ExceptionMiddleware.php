<?php


namespace App\Library\Middlewares;

use App\Library\Http\HttpCode;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class ExceptionMiddleware implements MiddlewareInterface
{

    /**
     * @param Event $event
     * @param Micro $app
     * @return bool
     */
    public function beforeExecuteRoute( Event $event, Micro $app ): bool
    {
        if ( $app->request->isOptions() )
        {
            $app->response->setStatusCode( HttpCode::NO_CONTENT );
            $app->response->sendHeaders();
            return false;
        }
        return true;
    }

    /**
     * @param Event $event
     * @param Micro $app
     * @return bool
     */
    public function beforeNotFound( Event $event, Micro $app ): bool
    {
        if ( $app->request->isOptions() )
        {
            $app->response->setStatusCode( HttpCode::NO_CONTENT );
            $app->response->sendHeaders();
            return false;
        }

        $app->response->setStatusCode( HttpCode::NOT_FOUND );
        $app->response->setJsonContent( [
            "error" => HttpCode::getDescription( HttpCode::NOT_FOUND )
        ] );

        return false;
    }

    /**
     * @param Micro $application
     * @return bool
     */
    public function call( Micro $application ): bool
    {
        return true;
    }
}
