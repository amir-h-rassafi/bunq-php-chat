<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as DB;
use DI\Container;
use Symfony\Component\Yaml\Yaml;

// Load configuration
$config = Yaml::parseFile(__DIR__ . '/../config/config.yml');
$config['base_path'] = realpath(__DIR__ . '/..');

// Set up dependency injection
$container = new Container;
AppFactory::setContainer($container);

$container->set('config', $config);

$container->set('db', function ($container) {
    $config = $container->get('config')['database'];

    $db = new DB;
    $db->addConnection([
        'driver' => $config['driver'],
        'database' => $container->get('config')['database']['path'],
        'mode' => 666
    ]);
    $db->setAsGlobal();
    $db->bootEloquent();

    return $db;
});

// Initialize Slim App
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// // Register routes
(require '/var/www/app/src/Routes/api.php')($app);

$app->run();