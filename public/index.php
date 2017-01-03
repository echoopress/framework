<?php
/*
 * index.php
 */
define('START_TIME', microtime(true));
define('DEBUG', true);
define('SITE_PATH',__DIR__.'/');
define('SYSTEM_PATH',__DIR__.'/../system/');
require_once SYSTEM_PATH.'vendor/autoload.php';

$app = new \Echoopress\Framework\Application();

//$app->get('/', function() {
//    return 'home page';
//});

//$app->get('/', 'Homepage\HomeController::indexAction');
//$app->get('/welcome/{name}', 'Homepage\HomeController::welcomeAction');
$app->get('/', 'Homepage');
//$app->get('/page', 'page');

$app->run();