<?php
declare( strict_types=1 );

use App\Providers\ConfigProvider;
use App\Providers\DatabaseProvider;
use Cli\Providers\CliDispatcherProvider;

/**
 * Enabled providers. Order does matter
 */
return [
    ConfigProvider::class,
    DataBaseProvider::class,
    CliDispatcherProvider::class
];
