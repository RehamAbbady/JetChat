
<?php
use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;


require __DIR__ . '/../vendor/autoload.php';

$container=new Container;

$settings=require __DIR__ . '/../App/settings.php';
$settings($container);
$app=SlimAppFactory::create($container);

$middleware=require __DIR__ . '/../App/middleware.php';
$middleware($app);

$routes=require __DIR__ . '/../App/routes.php';
$routes($app);


$app->run();