<?php
declare( strict_types=1 );

use App\Providers\ConfigProvider;
use App\Providers\DatabaseProvider;
use App\Providers\RouterProvider;

/**
 * Enabled providers. Order does matter
 */
return [
    ConfigProvider::class,
    DatabaseProvider::class,
    RouterProvider::class
];
