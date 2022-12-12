<?php

namespace Tests\Integration;

use App\Library\Repositories\UserRepository;
use App\Providers\RepositoryProvider;
use Tests\FunctionalTestCase;

class TestRepositoryProvider extends FunctionalTestCase
{
    public function testUserRepository_shouldReceivedInstance_whenIsRegisterRepositoryProvider()
    {
        ( new RepositoryProvider() )->register( $this->di );

        $repository = $this->di->get( "userRepository" );

        $this->assertInstanceOf( UserRepository::class, $repository );
    }
}
