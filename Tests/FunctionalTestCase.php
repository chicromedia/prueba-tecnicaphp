<?php

namespace Tests;

use App\Library\Bootstrap\Tests;
use App\Providers\DatabaseProvider;
use Exception;
use Phalcon\Db\Adapter\AdapterInterface;
use Phalcon\Di;
use Phalcon\Escaper as PhEscaper;
use Phalcon\Incubator\Test\FunctionalTestCase as Incubator;
use Phalcon\Migrations\Migrations;
use Phalcon\Mvc\Micro;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\IncompleteTestError;
use Tests\Mocks\RequestMock;

/**
 * @method void sendGet( string $url, array $options = [] )
 * @method void sendPost( string $url, array $options = [] )
 * @method void sendPut( string $url, array $options = [] )
 * @method void sendDelete( string $url, array $options = [] )
 */
abstract class FunctionalTestCase extends Incubator
{
    /** @var Micro */
    protected    $application;
    private bool $_loaded = false;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->checkExtension( "phalcon" );

        /** @var Tests */
        global $bootstrap;
        $this->setDI( $bootstrap->getContainer() );
        Di::setDefault( $this->di );

        $this->di->set( 'escaper', fn() => new PhEscaper() );

        if ( $this->di->has( 'application' ) )
        {
            $this->application = $this->di->get( 'application' );
        }

        $this->_loaded = true;
    }

    /**
     * @param string $method
     * @param mixed $data
     * @return void
     */
    protected function request( string $method, $data )
    {
        $this->di->setShared( 'request', new RequestMock( array_merge( [ "method" => $method ], $data ) ) );
    }

    public function __call( $name, $arguments )
    {
        [ $url, $options ] = $arguments;
        $method = str_replace( "send", "", $name );
        $this->request( strtoupper( $method ), $options ?: [] );
        $this->dispatch( $url );
    }

    /**
     * @param bool $associative
     * @return mixed
     */
    protected function getJsonBody( bool $associative = false )
    {
        return json_decode( $this->getContent(), $associative );
    }

    /**
     * Assert response header contains statusCode
     *
     * @param int $expected
     */
    public function assertResponseCode( $expected )
    {
        $actualValue = $this->application->response->getHeaders()->get( "Status" );
        if ( empty( $actualValue ) || !str_contains( $actualValue, $expected ) )
        {
            throw new ExpectationFailedException(
                sprintf(
                    'Failed asserting response code is "%s", actual response status is "%s"',
                    $expected,
                    $actualValue
                )
            );
        }
        $this->assertStringContainsString( $expected, $actualValue );
    }

    /**
     * Assert response content contains string
     *
     * @param string $expected
     */
    public function assertResponseContentContains( $expected )
    {
        $this->assertStringContainsString( $expected, $this->getContent() );
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
