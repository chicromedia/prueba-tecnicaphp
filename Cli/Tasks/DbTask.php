<?php

namespace Cli\Tasks;

use App\Providers\ConfigProvider;
use Cli\Library\Db\Synchronize;
use Exception;
use Phalcon\Cli\Task;
use Phalcon\Config;
use Phalcon\Migrations\Console\Color;

class DbTask extends Task
{
    public function mainAction()
    {
        $this->dispatcher->forward( [
            "task" => "main",
            "action" => "help",
        ] );
    }

    /**
     * @throws Exception
     */
    public function synchronizeAction()
    {
        $synchronize = new Synchronize( $this->getDI() );
        $options     = new Config( $synchronize->getOptions() );

        /** @var Config $config */
        $config   = $this->di->get( ConfigProvider::NAME );
        $cacheDir = BASE_PATH . $config->path( 'application.cacheDir' );
        if ( is_dir( $cacheDir ) )
        {
            exec( "rm -rf {$cacheDir}metaData/*.php" );
        }

        $host   = $options->path( 'config.database.host' );
        $dbname = $options->path( 'config.database.dbname' );

        echo Color::colorize( "Synchronizing {$dbname} in {$host}" . PHP_EOL );
        $synchronize::run( $synchronize->getOptions() );
    }

    /**
     * @throws Exception
     */
    public function migrateAction()
    {
        echo Color::colorize( "Generating a migration" . PHP_EOL );
        $synchronize = new Synchronize( $this->getDI() );
        $synchronize::generate( $synchronize->getOptions() );
    }
}
