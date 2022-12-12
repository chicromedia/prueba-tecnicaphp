<?php

namespace App\Library\Repositories;

use Phalcon\Di\DiInterface;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\Mvc\Model\Manager as ModelsManager;

abstract class AbstractRepository implements InjectionAwareInterface
{
    protected DiInterface $di;

    public function setDi( DiInterface $container ): void
    {
        $this->di = $container;
    }

    public function getDI(): DiInterface
    {
        return $this->di;
    }

    protected function getModelsManager(): ModelsManager
    {
        return $this->di->get( "modelsManager" );
    }
}
