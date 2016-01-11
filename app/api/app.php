<?php

$app = require __DIR__.'/bootstrap.php';
$app['debug'] = true;

//Allow PHP's built-in server to serve our static content in local dev:
$filename = dirname(__DIR__).preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
$app['monolog']->addInfo("kikou file:".$filename);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$app->get('/', function () use ($app) {
 	return $app->sendFile(dirname(__DIR__).'/index.html');
 });

$app['monolog']->addInfo("server loaded");

$app->run();

?>