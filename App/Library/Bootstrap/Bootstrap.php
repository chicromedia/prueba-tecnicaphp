<?php

namespace App\Library\Bootstrap;

use App\Providers\ConfigProvider;
use Phalcon\Cli\Console;
use Phalcon\Config;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Di\FactoryDefault\Cli as PhCli;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Micro;

abstract class Bootstrap
{
    /**
     * @var Console|Micro|null
     */
    protected $application = null;

    /** @var FactoryDefault|PhCli|null */
    protected $container = null;

    /** @var array */
    protected array $options = [];

    /** @var array */
    protected array $providers = [];

    /**
     * Constructor
     */
    final public function __construct() {}

    /**
     * @return mixed
     */
    abstract public function run();

    /**
     * Runs the application
     */
    public function setup(): void
    {
        $this->setupApplication();
        $this->registerServices();
        Di::setDefault( $this->container );
    }

    /**
     * Set up the application object in the container
     *
     * @return Bootstrap
     */
    protected function setupApplication(): Bootstrap
    {
        $this->application = new Micro( $this->container );
        $this->container->setShared( 'application', $this->application );
        return $this;
    }

    /**
     * Get service config the application
     *
     * @return Config
     */
    protected function getConfig(): Config
    {
        return $this->container->get( ConfigProvider::NAME );
    }

    /**
     * Registers available services
     *
     * @return void
     */
    private function registerServices()
    {
        /** @var ServiceProviderInterface $provider */
        foreach ( $this->providers as $provider )
        {
            ( new $provider() )->register( $this->container );
        }
    }
}
