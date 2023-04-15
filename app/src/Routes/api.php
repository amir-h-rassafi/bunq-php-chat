<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Welcome to the chat application!");
        return $response;
    });

    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->get('/messages', function (Request $request, Response $response, array $args) {
            // Your code here

            return $response;
        });

        $group->post('/messages', function (Request $request, Response $response, array $args) {
            // Your code here

            return $response;
        });
    });
};
