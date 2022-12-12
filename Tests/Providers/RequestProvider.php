<?php
declare( strict_types=1 );

namespace Tests\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Tests\Mocks\RequestMock;

class RequestProvider implements ServiceProviderInterface
{

    const NAME = 'request';

    public function register( DiInterface $di ): void
    {
        $di->set( self::NAME, fn() => new RequestMock( [
            "method" => "GET",
            "body" => [],
            "query" => ""
        ] ) );
    }
}
