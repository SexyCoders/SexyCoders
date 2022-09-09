<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';

$app = new Slim\App;

function getGroup($data_obj){
    $ch = curl_init("http://master_api:80/resolve/default");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,base64_encode(json_encode($data_obj)));
    $group=json_decode(base64_decode(curl_exec($ch)))->default_group;
    //$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
return $group;
}
function getCompany($data_obj){
    $ch = curl_init("http://master_api:80/resolve/company");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,base64_encode(json_encode($data_obj)));
    $company=json_decode(base64_decode(curl_exec($ch)))->company;
    //$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
return $company;
}

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

$app->post('/databases/{db_id}/{command}', function (Request $request, Response $response, array $args) {
    $db_id = $args['db_id'];
    $command = $args['command'];
    $req_data=json_decode(base64_decode($request->getBody()));
    $ResponseData=new stdClass;
    $mongo=new MongoDB\Client("mongodb://mongo:mongo@".$req_data->company."_mongodb:27017");
    $db=(($mongo)->databases->$db_id);

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
$app->run();
