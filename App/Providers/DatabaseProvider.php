<?php
declare( strict_types=1 );

namespace App\Providers;

use PDO;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
class DatabaseProvider implements ServiceProviderInterface
{
    const NAME = 'db';

    public function register( DiInterface $di ): void
    {
        $pdoAdapter = 'Phalcon\\Db\\Adapter\\Pdo\\' . getenv( 'DB_ADAPTER' );

        $di->setShared( self::NAME, fn() => new $pdoAdapter( [
            'host' => getenv( 'DB_HOST' ),
            'dbname' => getenv( 'DB_NAME' ),
            'username' => getenv( 'DB_USERNAME' ),
            'password' => getenv( 'DB_PASSWORD' ),
            'port' => getenv( 'DB_PORT' ),
            'options' => [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                PDO::ATTR_CASE => PDO::CASE_NATURAL,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS
            ]
        ] )
        );
    }
}
