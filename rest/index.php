<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require './src/auth.php';
require './src/resolve.php';
require './src/etc.php';

$app = new Slim\App;

////////////
//HELLO
////////////
$app->get('/hello', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, this is the uniclient api resolver! No milf porn here were sorry, please refer to https://www.pornhub.com/");
});

////////////
//RESOLVE
////////////
$app->post('/resolve/company',function(Request $request, Response $response){
    $data=json_decode(base64_decode($request->getBody()));
    $data=json_decode(auth($data->token));
    $response->getBody()->write(base64_encode(json_encode(resolveCompany($data))));
});
$app->post('/resolve/group',function(Request $request, Response $response){
    $data=json_decode(base64_decode($request->getBody()));
    $data=json_decode(auth($data->token));
    $response->getBody()->write(base64_encode(json_encode(resolveGroup($data))));
});

////////////
//ETC
////////////
$app->post('/etc/services',function(Request $request, Response $response){
    $data=json_decode(base64_decode($request->getBody()));
    $data=json_decode(auth($data->token));
    $response->getBody()->write(base64_encode(json_encode(getActiveServices($data))));
});
//$app->post('/etc/databases',function(Request $request, Response $response){
    //$data=json_decode(base64_decode($request->getBody()));
    //$data=json_decode(auth($data->token));
    //$response->getBody()->write(base64_encode(json_encode(getUserDatabases($data))));
//});



$app->run();
