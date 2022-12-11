<?php
declare( strict_types=1 );

use Dotenv\Dotenv;

if ( !file_exists( BASE_PATH . '/vendor/autoload.php' ) )
{
    throw new \RuntimeException( 'Unable to locate autoloader. ' . 'Install dependencies from the project root directory to run test suite: `composer install`.' );
}

/**
 * Include Composer autoloader
 */
require BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv::createUnsafeImmutable( BASE_PATH );
$dotenv->load();

/**
 * Set the default locale
 */
setlocale( LC_ALL, 'en_US.utf-8' );

/**
 * Set timezone
 */
date_default_timezone_set( 'America/Santo_Domingo' );

/**
 * @const APP_START_TIME The start time of the application, used for profiling
 */
define( 'APP_START_TIME', microtime( true ) );

/**
 * @const APP_START_MEMORY The memory usage at the start of the application, used for profiling
 */
define( 'APP_START_MEMORY', memory_get_usage() );

/**
 * Set the MB extension encoding to the same character set
 */
if ( function_exists( 'mb_internal_encoding' ) )
{
    mb_internal_encoding( 'utf-8' );
}

/**
 * Set the mb_substitute_character to "none"
 */
if ( function_exists( 'mb_substitute_character' ) )
{
    mb_substitute_character( 'none' );
}
