<?php


require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;



$app = new Silex\Application();



//load routes from config/routes.yml
$app['routes'] = $app->extend(
    'routes',
    function (RouteCollection $routes, Silex\Application $app) {
        $loader     = new YamlFileLoader(new FileLocator(__DIR__ . '/config'));
        $collection = $loader->load('routes.yml');
        $routes->addCollection($collection);

        return $routes;
    }
);

//register logger
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/log/dev.log',
));


$app->register(
    new Silex\Provider\DoctrineServiceProvider(),
    array(
        'db.options' => array(
            'driver' => 'pdo_sqlite',
            'path'   => __DIR__ . '/db/app.db.sqlite',
        ),
    )
);

return $app;

//$app->run();