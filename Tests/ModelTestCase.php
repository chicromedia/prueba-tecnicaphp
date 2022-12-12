<?php

namespace Tests;

use App\Library\Bootstrap\Tests;
use App\Providers\DatabaseProvider;
use Phalcon\Db\Adapter\AdapterInterface;
use Phalcon\Di;
use Phalcon\Incubator\Test\ModelTestCase as Incubator;
use Phalcon\Migrations\Migrations;
use Phalcon\Mvc\Model\Manager as PhModelManager;
use Phalcon\Mvc\Model\MetaData\Memory as PhMetadataMemory;
use PHPUnit\Framework\IncompleteTestError;

abstract class ModelTestCase extends Incubator
{
    private bool $_loaded = false;

    protected function setUp(): void
    {
        $this->setUpPhalcon();

        /** @var Tests */
        global $bootstrap;
        $this->setDI( $bootstrap->getContainer() );
        Di::setDefault( $this->di );

        $this->di->set( 'modelsManager', fn() => new PhModelManager() );
        $this->di->set( 'modelsMetadata', fn() => new PhMetadataMemory() );

        $this->setDb();
        $this->_loaded = true;
    }

    protected function make( string $class )
    {
        $repository = new $class();
        if ( is_a( $repository, Di\InjectionAwareInterface::class ) )
        {
            $repository->setDI( $this->di );
        }
        return $repository;
    }

    protected function tearDown(): void
    {
        /** @var AdapterInterface $db */
        $db = $this->getDI()->get( DatabaseProvider::NAME );
        foreach ( $db->listTables() as $table )
        {
            if ( $table !== Migrations::MIGRATION_LOG_TABLE )
            {
                $this->truncateTable( $table );
            }
        }
        parent::tearDown();
    }

    public function __destruct()
    {
        if ( !$this->_loaded )
        {
            throw new IncompleteTestError( "Please run parent::setUp()." );
        }
    }
}
