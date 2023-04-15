<?php

namespace App\Routes;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserChatManager;
use Parsedown;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, array $args) use ($app) {
        $markdown = file_get_contents("/var/www/app/readme.md");
        $parsedown = new Parsedown();
        $html = $parsedown->text($markdown);
        $response->getBody()->write($html);
        return $response;
    });

    //we need to authorization

    //user management
    $app->get('/user/list', function (Request $request, Response $response, array $args) use ($app) {
        
        $count = $request->getQueryParams()['count'] ?? null;
        if (empty($count)) {
            $count = 5;
        }

        $response->getBody()->write((new UserRepository($app->getContainer()->get('db')))->getUsersJson($count));
        
        return $response;
    });

    $app->get('/user/add', function (Request $request, Response $response, array $args) use ($app) {

        $username = $request->getQueryParams()['username'];
        
        $user = (new UserRepository($app->getContainer()->get('db')))->addUser($username);
        
        $response->getBody()->write($user->toJson());
        
        return $response;
    });

    $app->post('/user/{id}/send/{peer-id}', function (Request $request, Response $response, array $args) use ($app) {
        $creatorId = $args['id'];
        $peerId = $args['peer-id'];
        $text = json_decode($request->getBody(), true)['text'];
        
        $message = (new UserChatManager($creatorId, $app->getContainer()->get('db')))->sendMessage($peerId, $text);
        $response->getBody()->write(json_encode(["status" => "Success"]));
        
        return $response;
    });

    $app->get('/user/{id}/chats', function (Request $request, Response $response, array $args) use ($app) {
        $userId = $args['id'];
        $count = $request->getQueryParams()['count'] ?? 100;
        $chats = (new UserChatManager($userId, $app->getContainer()->get('db')))->getChatsJson($count);
        $response->getBody()->write($chats);
        return $response;
    });

    $app->get('/chat/{id}', function (Request $request, Response $response, array $args) use  ($app) {
        $chatId = $args['id'];
        $count = $request->getQueryParams()['count'] ?? 100;
        $messages = (new UserChatManager(null, $app->getContainer()->get('db')))->getChatMessages($chatId, $count);
        $response->getBody()->write($messages);
        return $response;
    });

};
