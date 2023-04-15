<?php

namespace App\Routes;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Models\User;
use App\Repositories\UserRepository;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, array $args) use ($app) {
        $response->getBody()->write(json_encode(["Hello"=>"World - Welcome to simple chat!"]));
        return $response;
    });

    //we need to authorization

    //user management
    $app->get('/users/list', function (Request $request, Response $response, array $args) use ($app) {
        
        $count = $request->getQueryParams()['count'];
        if (empty($count)) {
            $count = 5;
        }

        $response->getBody()->write((new UserRepository($app->getContainer()->get('db')))->getUsersJson($count));
        
        return $response;
    });

    $app->get('/users/add', function (Request $request, Response $response, array $args) use ($app) {

        $username = $request->getQueryParams()['username'];
        
        $user = (new UserRepository($app->getContainer()->get('db')))->addUser($username);
        
        $response->getBody()->write($user->toJson());
        
        return $response;
    });

    $app->post('/messages/{user-id}/send/{to-user-id}', function (Request $request, Response $response, array $args) use ($app) {

    });

    //polling a chat session messages
    $app->get('/chat/{chat-id}', function (Request $request, Response $response, array $args) use ($app) {

    });

    $app->get('/chat/{user-id}/list', function (Request $request, Response $response, array $args) use  ($app) {
    
    });

};
