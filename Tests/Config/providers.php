<?php
declare( strict_types=1 );

use App\Providers\ConfigProvider;
use App\Providers\DatabaseProvider;
use App\Providers\RepositoryProvider;
use App\Providers\RouterProvider;
use Tests\Providers\RequestProvider;

/**
 * Enabled providers. Order does matter
 */
return [
    ConfigProvider::class,
    DatabaseProvider::class,
    RequestProvider::class,
    RouterProvider::class,
    RepositoryProvider::class
];
