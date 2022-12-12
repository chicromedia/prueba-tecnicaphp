<?php
declare( strict_types=1 );

namespace App\Library\Bootstrap;

use App\Providers\DatabaseProvider;
use Cli\Library\Db\Synchronize;
use Exception;
use Phalcon\Db\Adapter\AdapterInterface;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;

class Tests extends Bootstrap
{
    /**
     * Run the tests application
     */
    public function run(): Micro
    {
        $setup = $this->getConfig()->get( "database" );
        $db    = $this->getPdoAdapter();

        $dbname = $setup->path( 'dbname' ) . "_test";
        $setup->set( "dbname", $dbname );

        $db->execute( "CREATE DATABASE IF NOT EXISTS {$dbname}" );
        $db->connect( $setup->toArray() );

        $synchronize = new Synchronize( $this->container );
        Synchronize::run( $synchronize->getOptions( true ) );

        return $this->application;
    }

    /**
     * @throws Exception
     */
    public function setup(): void
    {
        $this->container = new FactoryDefault();
        $providers       = TEST_PATH . 'Config/providers.php';

        if ( !file_exists( $providers ) || !is_readable( $providers ) )
        {
            throw new Exception( "File providers {$providers} does not exist or is not readable." );
        }

        $this->providers = require_once $providers;
        Di::setDefault( $this->container );

        parent::setup();
    }

    protected function getPdoAdapter(): AdapterInterface
    {
        return $this->container->get( DatabaseProvider::NAME );
    }
}
