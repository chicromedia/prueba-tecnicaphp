<?php
declare( strict_types=1 );

namespace App\Providers;

use Phalcon\Config;
use Phalcon\Config\Adapter\Json;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Exception;

/**
 * Read the configuration
 */
class ConfigProvider implements ServiceProviderInterface
{

    const NAME = 'config';

    /**
     * @param DiInterface $di
     * @throws Exception
     */
    public function register( DiInterface $di ): void
    {
        $configPath = APP_PATH . 'Config/config.json';
        if ( !file_exists( $configPath ) || !is_readable( $configPath ) )
        {
            throw new Exception( 'Config file does not exist: ' . $configPath );
        }

        $config   = $this->getJsonConfig( $configPath );
        $composer = $this->getJsonConfig( BASE_PATH . 'composer.json' );

        $extra = new Config( [
            "application" => [
                "version" => $composer->path( 'version' )
            ],
            "database" => [
                'adapter' => getenv( 'DB_ADAPTER' ),
                'host' => getenv( 'DB_HOST' ),
                'dbname' => getenv( 'DB_NAME' ),
                'username' => getenv( 'DB_USERNAME' ),
                'password' => getenv( 'DB_PASSWORD' ),
                'port' => getenv( 'DB_PORT' )
            ]
        ] );

        $config->merge( $extra );
        $di->setShared( self::NAME, fn() => $config );
    }

    private function getJsonConfig( string $filePath ): Json
    {
        return new Json( $filePath );
    }
}
