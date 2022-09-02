<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';

$app = new Slim\App;

////////////
//HELLO
////////////
$app->get('/hello', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, this is the uniclient api! Lots of good stuff but no milf porn sorry! (You can always visit https://www.pornhub.com/ 😉)");
});
$app->post('/hello', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, this is the uniclient api! Lots of good stuff but no milf porn sorry! (You can always visit https://www.pornhub.com/ 😉)");
});


$app->run();
