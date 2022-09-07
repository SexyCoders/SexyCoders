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
    $data=$req_data->data;

    //injecting default group of user
    $ch = curl_init("http://master_api:80/resolve/default");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,base64_encode(json_encode($req_data)));
    $data->group=json_decode(base64_decode(curl_exec($ch)))->default_group;
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    //injecting default permissions
    $data->permissions=new stdClass;
    $data->permissions->u='rwx';
    $data->permissions->g='r-x';
    $data->permissions->o='r-x';


    $ResponseData=new stdClass;
    $ResponseData->test=$data;
    $ResponseData->status=$status;
    $mongo=new MongoDB\Client("mongodb://mongo:mongo@".$req_data->company."_mongodb:27017");
    $db_name=$data->database_id;
    $db=(($mongo)->databases->$db_name);
    $db->insert($data);
    $response->getBody()->write(base64_encode(json_encode($ResponseData)));
});


$app->run();
