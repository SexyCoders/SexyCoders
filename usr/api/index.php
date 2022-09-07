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

//get databases

$app->post('/databases/{db_name}/{command}', function (Request $request, Response $response, array $args) {
    $db_name = $args['db_name'];
    $command = $args['command'];
    $req_data=json_decode(base64_decode($request->getBody()));
    $ResponseData=new stdClass;
    $mongo=new MongoDB\Client("mongodb://mongo:mongo@".$req_data->company."_mongodb:27017");
    $db=(($mongo)->databases->$db_name);

    switch ($command) {
        case 'GET':
            $t=array();
            $t1=array(
                'limit'=>$req_data->count,
                'skip'=>($req_data->pos-1)
            );
            $res=$db->find($t,$t1);
            //$res=$db->find($t);
            $ResponseData->data=array();
            foreach($res as $r)
                {
                    array_push($ResponseData->data,$r);
                }
            break;
    }
    $response->getBody()->write(base64_encode(json_encode($ResponseData)));
});

//create database

$app->post('/databases/create', function (Request $request, Response $response, array $args) {
    //$db_name = $args['db_name'];
    //$command = $args['command'];
    $req_data=json_decode(base64_decode($request->getBody()));
    $ResponseData=new stdClass;
    $ResponseData->test=$req_data;
    //$mongo=new MongoDB\Client("mongodb://mongo:mongo@".$req_data->company."_mongodb:27017");
    //$db=(($mongo)->databases->$db_name);

    //switch ($command) {
        //case 'GET':
            //$t=array();
            //$t1=array(
                //'limit'=>$req_data->count,
                //'skip'=>($req_data->pos-1)
            //);
            //$res=$db->find($t,$t1);
            ////$res=$db->find($t);
            //$ResponseData->data=array();
            //foreach($res as $r)
                //{
                    //array_push($ResponseData->data,$r);
                //}
            //break;
    //}
    $response->getBody()->write(base64_encode(json_encode($ResponseData)));
});


$app->run();
