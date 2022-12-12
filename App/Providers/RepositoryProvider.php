<?php
declare( strict_types=1 );

namespace App\Providers;

use App\Library\Repositories\UserRepository;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Read the configuration
 */
class RepositoryProvider implements ServiceProviderInterface
{
    /**
     * @throws ReflectionException
     */
    public function register( DiInterface $di ): void
    {
        foreach ( $this->getRepositories() as $repository )
        {
            $class = new ReflectionClass( $repository );
            $di->setShared( lcfirst( $class->getShortName() ), $class->newInstanceArgs() );
        }
    }

    private function getRepositories(): array
    {
        return [
            UserRepository::class
        ];
    }
}
