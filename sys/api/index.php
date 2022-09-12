<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require './src/auth.php';
require './src/resolve.php';
require './src/etc.php';

$app = new Slim\App;

function CreateArray()
    {
    }

////////////
//HELLO
////////////
$app->get('/hello', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, this is the uniclient api resolver! No milf porn here were sorry, please refer to https://www.pornhub.com/");
});
$app->post('/hello', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, this is the uniclient api resolver! No milf porn here were sorry, please refer to https://www.pornhub.com/");
});


////////////
//RESOLVE
////////////
$app->post('/resolve/company',function(Request $request, Response $response){
    $req_data=json_decode(base64_decode($request->getBody()));
    $data=json_decode(auth($req_data->token));
    $response->getBody()->write(base64_encode(json_encode(resolveCompany($data))));
});
$app->post('/resolve/group',function(Request $request, Response $response){
    $data=json_decode(base64_decode($request->getBody()));
    $data=json_decode(auth($data->token));
    $response->getBody()->write(base64_encode(json_encode(resolveGroup($data))));
});
$app->post('/resolve/default',function(Request $request, Response $response){
    $req_data=json_decode(base64_decode($request->getBody()));
    $data=json_decode(auth($req_data->token));
    $response->getBody()->write(base64_encode(json_encode(getGroup($data))));
});


////////////
//ETC
////////////
$app->post('/etc/services',function(Request $request, Response $response){
    $data=json_decode(base64_decode($request->getBody()));
    $data=json_decode(auth($data->token));
    $response->getBody()->write(base64_encode(json_encode(getActiveServices($data))));
});
$app->post('/etc/databases',function(Request $request, Response $response){
    $data=json_decode(base64_decode($request->getBody()));
    $data=json_decode(auth($data->token));
    $response->getBody()->write(base64_encode(json_encode(getUserDatabases($data))));
});

////////////
//BIN
////////////
$app->post('/bin/create/database',function(Request $request, Response $response){
    $req_data=json_decode(base64_decode($request->getBody()));
    $data=json_decode(auth($req_data->token));
    $response->getBody()->write(base64_encode(json_encode(createUserDatabase($req_data))));
});

////////////
//SERVE
////////////
$app->post('/serve',function(Request $request, Response $response){
    $req_data=json_decode(base64_decode($request->getBody()));
    $data=json_decode(auth($req_data->token));
    $ResponseData=new stdClass;
    //$ResponseData->test_input=$data;
    $user_company=resolveCompany($data)->company;

    //resolve company api location
    $user_redis = new Redis();
    $user_redis->connect('master_api-cache', 6379);
    $ResponseData->api_location=$user_redis->get($user_company);
    if(!$ResponseData->api_location)
        {

            $pdo = new \pdo(
            //"mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master',$passwd[0] ,
            "mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master','master' ,
            [
            \pdo::ATTR_ERRMODE            => \pdo::ERRMODE_EXCEPTION,
            \pdo::ATTR_DEFAULT_FETCH_MODE => \pdo::FETCH_ASSOC,
            \pdo::ATTR_EMULATE_PREPARES   => false,
            ]); 

            $stmt = $pdo->prepare("select location from apis where company=?");
            $stmt->execute([$user_company]);
            $ResponseData->api_location=$stmt->fetch()['location'];

            $user_redis = new Redis();
            $user_redis->connect('master_api-cache', 6379);
            $user_redis->set($data->sub,$ResponseData->api_location);

        }

    //check if stack is up
            if($socket =@ fsockopen($ResponseData->api_location, 80, $errno, $errstr, 0)) {
                $ResponseData->PING="GOOD";
                fclose($socket);
            } else {
                $ResponseData->PING="BAD";
            }

    //command passthough to the api
        $ch = curl_init("http://".$ResponseData->api_location.":80".$req_data->path);
        curl_setopt($ch, CURLOPT_POST,1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,base64_encode(json_encode($req_data)));
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: text/plain'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER,0);
        $ResponseData->data = json_decode(base64_decode(curl_exec($ch)))->data;
        curl_close($ch); 
        
    //encapsulate result from the api
    //$req_data->test=$data;
    //$response->getBody()->write(json_encode($req_data));
    $ResponseData->input=$req_data;
    $response->getBody()->write(base64_encode(json_encode($ResponseData)));
});

$app->run();
