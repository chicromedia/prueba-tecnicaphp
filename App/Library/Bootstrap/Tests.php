<?php
declare( strict_types=1 );

namespace App\Library\Bootstrap;

use App\Providers\DatabaseProvider;
use Phalcon\Db\Adapter\AdapterInterface;
use Phalcon\Mvc\Micro;

class Tests extends Bootstrap
{
    /**
     * Run the tests application
     * @return Micro
     */
    public function run(): Micro
    {
        $this->setUpDataBase();
        return $this->application;
    }

    private function setUpDataBase()
    {
        $config = $this->getConfig();
        $db     = $this->getPdoAdapter();

        $dbname = $config->path( 'database.dbname' ) . "_test";
        $db->execute( "CREATE DATABASE IF NOT EXISTS {$dbname}" );

        $database = $config->get( 'database' );
        $database->set( 'dbname', $dbname );
        $db->connect( $database->toArray() );
    }


    protected function getPdoAdapter(): AdapterInterface
    {
        return $this->container->get( DatabaseProvider::NAME );
    }
}
