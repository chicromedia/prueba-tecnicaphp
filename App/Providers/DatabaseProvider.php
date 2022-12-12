<?php
declare( strict_types=1 );

namespace App\Providers;

use PDO;
use Phalcon\Config;
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
        /** @var Config $config */
        $config = $di->getShared( ConfigProvider::NAME )->get( 'database' );

        $di->setShared( self::NAME, function () use ( $config )
        {
            $pdoAdapter = 'Phalcon\\Db\\Adapter\\Pdo\\' . $config->path( 'adapter' );
            return new $pdoAdapter( [
                'host' => $config->path( 'host' ),
                'dbname' => $config->path( 'dbname' ),
                'username' => $config->path( 'username' ),
                'password' => $config->path( 'password' ),
                'port' => $config->path( 'port' ),
                'options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                    PDO::ATTR_CASE => PDO::CASE_NATURAL,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS
                ]
            ] );
        } );
    }
}
