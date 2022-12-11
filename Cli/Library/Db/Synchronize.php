<?php

namespace Cli\Library\Db;

use App\Providers\ConfigProvider;
use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Migrations\Migrations;

class Synchronize extends Migrations
{
    private ?DiInterface $di;

    public function __construct( ?DiInterface $di )
    {
        $this->di = $di;
    }

    public function getOptions(): array
    {
        /** @var Config $config */
        $config               = $this->di->getShared( ConfigProvider::NAME );
        $exportDataFromTables = $config->path( 'application.exportDataFromTables' );
        $migrationsDir        = APP_PATH . $config->path( 'application.migrationsDir' );
        $database             = $config->get( 'database' );

        return [
            "directory" => BASE_PATH,
            "version" => $config->path( 'application.version' ),
            "exportDataFromTables" => $exportDataFromTables->toArray(),
            "migrationsTsBased" => $config->path( 'application.migrationsTsBased' ),
            "migrationsDir" => $migrationsDir,
            'tableName' => "@",
            "migrationsInDb" => false,
            "skip-ref-schema" => true,
            "skip-foreign-checks" => true,
            "force" => true,
            "noAutoIncrement" => true,
            "config" => new Config( [
                "database" => new Config( [
                    'adapter' => $database->path( 'adapter' ),
                    'host' => $database->path( 'host' ),
                    'port' => $database->path( 'port' ),
                    'username' => $database->path( 'username' ),
                    'password' => $database->path( 'password' ),
                    'dbname' => $database->path( 'dbname' ),
                ] )
            ] )
        ];
    }
}
