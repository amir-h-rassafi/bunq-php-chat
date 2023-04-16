<?php

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

class Test extends TestCase
{
    public function testExample()
    {
        $app = new App();
        // Register your routes here
    
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);
    
        // Configure the mock request and response as needed
    
        $response = $app->handle($request);
    
        // Perform assertions on the response object
        $this->assertSame(200, $response->getStatusCode());
    }    
    
}
