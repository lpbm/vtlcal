<?php

date_default_timezone_set('UTC');
chdir(dirname(__FILE__) . '/../');
// Composer autoloading.
if ( file_exists('vendor/autoload.php') ) {
    $loader = include_once 'vendor/autoload.php';
} else {
    throw new RuntimeException('Unable to load the autoloader. Run `php composer.phar install`.');
}
