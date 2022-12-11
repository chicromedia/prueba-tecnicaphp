<?php
declare( strict_types=1 );

namespace App\Providers;

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
        $config->set( "application.version", $composer->path( 'version' ) );

        $di->setShared( self::NAME, fn() => $config );
    }

    private function getJsonConfig( string $filePath ): Json
    {
        return new Json( $filePath );
    }
}
