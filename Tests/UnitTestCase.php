<?php

namespace Tests;

use App\Library\Bootstrap\Tests;
use Phalcon\Di;
use Phalcon\Escaper;
use Phalcon\Incubator\Test\UnitTestCase as Incubator;
use Phalcon\Mvc\Controller;
use Phalcon\Url;
use PHPUnit\Framework\IncompleteTestError;

abstract class UnitTestCase extends Incubator
{
    private bool $_loaded = false;

    protected function setUp(): void
    {
        $this->checkExtension( 'phalcon' );

        /** @var Tests */
        global $bootstrap;
        $this->setDI( $bootstrap->getContainer() );
        Di::setDefault( $this->di );

        $this->di->set( 'url', function ()
        {
            $url = new Url();
            $url->setBaseUri( '/' );
            return $url;
        } );

        $this->di->set( 'escaper', fn() => new Escaper() );

        $this->_loaded = true;
    }

    public function __destruct()
    {
        if ( !$this->_loaded )
        {
            throw new IncompleteTestError( "Please run parent::setUp()." );
        }
    }
}
