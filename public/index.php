<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;


$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$path = $request->getUri()->getPath();

if ($path === '/') {
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    $response = new HtmlResponse("<h1>Hello, {$name}!</h1><a href='/about'>About Us</a>");
    $response = $response->withHeader('X-Developer', 'Davydenko');
} elseif ($path === '/about') {        
        $response = new HtmlResponse('<h1>About Us</h1><a href="/">Home Page</a>');
        $response = $response->withHeader('X-Developer', 'Davydenko');
} else {        
    $response = new HtmlResponse('<h1>404 Not Found</h1><a href="/">Home Page</a>');
    $response = $response->withHeader('X-Developer', 'Davydenko');
    $response = $response->withStatus(404);
}

(new SapiEmitter)->emit($response); 