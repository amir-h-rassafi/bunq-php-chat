<?php

namespace App\Routes;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Utils\Pager;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserChatManager;
use Parsedown;

//TODO review and LOCK for race conditions
//FIX MODELS for better SOLID HANDLING

function extractPager($queryParam): Pager {
    $page = $queryParam['page'] ?? 1;
    $size = $queryParam['size'] ?? 20;
    return new Pager($page, $size);
};

return function (App $app) {


    //run readme.md
    $app->get('/', function (Request $request, Response $response, array $args) use ($app) {
        $markdown = file_get_contents("/var/www/app/readme.md");
        $parsedown = new Parsedown();
        $html = $parsedown->text($markdown);
        $template = file_get_contents("/var/www/app/public/template.html");
        $output = str_replace("{{content}}", $html, $template);
        $response->getBody()->write($output);
        return $response;
    });

    //we need to authorization

    //user management
    $app->get('/user/list', function (Request $request, Response $response, array $args) use ($app) {
        
        $pager = extractPager($request->getQueryParams());

        $response->getBody()->write((new UserRepository($app->getContainer()->get('db')))->getUsersJson($pager));
        
        return $response;
    });

    $app->get('/user/add', function (Request $request, Response $response, array $args) use ($app) {

        $username = $request->getQueryParams()['username'];
        
        $user = (new UserRepository($app->getContainer()->get('db')))->addUser($username);
        
        $response->getBody()->write($user->toJson());
        
        return $response;
    });

    $app->post('/user/{sender-id}/send/{receiver-id}', function (Request $request, Response $response, array $args) use ($app) {
        
        $senderId = $args['sender-id'];
        $receiverId = $args['receiver-id'];
        $text = json_decode($request->getBody(), true)['text'];
        
        $message = (new UserChatManager($app->getContainer()->get('db'), $senderId))->sendMessage($receiverId, $text);
        $response->getBody()->write(json_encode(["status" => "Success"]));
        
        return $response;
    });

    $app->get('/user/{id}/chats', function (Request $request, Response $response, array $args) use ($app) {
        $userId = $args['id'];
        $pager = extractPager($request->getQueryParams());
        $chats = (new UserChatManager($app->getContainer()->get('db'), $userId))->getChatsJson($pager);
        $response->getBody()->write($chats);
        return $response;
    });

    $app->get('/chat/{id}', function (Request $request, Response $response, array $args) use  ($app) {
        $chatId = $args['id'];
        $pager = extractPager($request->getQueryParams());
        $messages = (new UserChatManager($app->getContainer()->get('db')))->getChatMessages($chatId, $pager);
        $response->getBody()->write($messages);
        return $response;
    });

};
