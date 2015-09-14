<?php
use vsc\infrastructure\vsc;

$iStart		= microtime(true);
$sContent 	= '';

date_default_timezone_set('UTC');

error_reporting (E_ALL); ini_set('display_errors', 1);

chdir(dirname(__FILE__) . '/../');
if ( file_exists('vendor/autoload.php') ) {
    $loader = include_once 'vendor/autoload.php';
    if ( file_exists('vendor' . DIRECTORY_SEPARATOR . 'vsc' . DIRECTORY_SEPARATOR . 'vsc' . DIRECTORY_SEPARATOR . 'vsc.inc.php') ) {
        include_once 'vendor' . DIRECTORY_SEPARATOR . 'vsc' . DIRECTORY_SEPARATOR . 'vsc' . DIRECTORY_SEPARATOR . 'vsc.inc.php';
    } else {
        throw new RuntimeException('Unable to load vsc library. Run `php composer.phar install`.');
    }
} else {
    throw new RuntimeException('Unable to load the autoloader. Run `php composer.phar install`.');
}

ob_start();
try {
    echo \vsc\getErrorHeaderOutput (); // in the case of a fatal error we have this as fallback
    ob_start ();
    // here be dragons

    /* @var \vsc\application\dispatchers\RwDispatcher $oDispatcher */
    $oDispatcher = vsc::getEnv()->getDispatcher();

    $oRequest = vsc::getEnv()->getHttpRequest();

    // load the sitemap
    $oDispatcher->loadSiteMap ('src/res/map.php');

    /* @var \vsc\application\processors\ProcessorA $oProcessor  */
    // get the controller
    $oProcessor			= $oDispatcher->getProcessController ($oRequest);

    /* @var \vsc\application\controllers\FrontControllerA $oFrontController */
    // get the front controller
    $oFrontController 	= $oDispatcher->getFrontController ();

    // get the response
    $oResponse 			= $oFrontController->getResponse ($oRequest, $oProcessor);

    // output the response
    $sContent = $oResponse->getOutput();
} catch (Exception $e) {
    \vsc\_e ($e);
}
$aErr = \vsc\cleanBuffers();
echo $sContent;
