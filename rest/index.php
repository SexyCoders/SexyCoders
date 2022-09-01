<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';

//$username='libauth';
//$filename='/etc/uniclient/master_pass';
//$handle = fopen($filename, "r");
//$passwd = fscanf($handle,"%s");
//fclose($handle);
//

$app = new Slim\App;
//$app->add(new \Eko3alpha\Slim\Middleware\CorsMiddleware([
    //'*' => 'POST'
    //]));
$app->get('/hello', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, this is the uniclient api resolver! No milf porn here were sorry, please refer to https://www.pornhub.com/");

    return $response;
});

function auth($token) {
    $keycloak_host=system("host sso_keycloak | awk '{print $4}'");
    $ch = curl_init("http://".$keycloak_host.":8080/realms/testing/.well-known/openid-configuration"); // such as http://example.com/example.xml
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER,0);
    $data = json_decode(curl_exec($ch));
    curl_close($ch); 
    if (property_exists($data,'error')) {
        return "NOAUTH";
    }
$myheader="Authorization: Bearer ".$token;
    $ch = curl_init($data->userinfo_endpoint); // such as http://example.com/example.xml
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    $myheader
    ));
    $data = curl_exec($ch);
    curl_close($ch); 
    return $data;
    //return $token;
    //return $myheader;
    }

$app->post('/resolve/company',function(Request $request, Response $response){
    $ResponseData=new stdClass;
    $data=json_decode(base64_decode($request->getBody()));
    $t=auth($data->token);
    $response->getBody()->write(json_encode($t));
    //$user_redis = new Redis();
    //$user_redis->connect('master_company_cache', 6379);
    //$ResponseData->company=$user_redis->get($data['userid']);
    
    //if(!$ResponseData->company)
        //{
            //$pdo = new \pdo(
              //"mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master',$passwd[0] ,
              //"mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master',master ,
            //[
              //\pdo::ATTR_ERRMODE            => \pdo::ERRMODE_EXCEPTION,
              //\pdo::ATTR_DEFAULT_FETCH_MODE => \pdo::FETCH_ASSOC,
              //\pdo::ATTR_EMULATE_PREPARES   => false,
            //]); 

            //$stmt = $pdo->prepare("select company from users where userid=?");
            //$stmt->execute([$data['userid']]);
            //$ResponseData->company=$stmt->fetch();
        //}
    //$response->getBody()->write(base64_encode(json_encode($ResponseData)));
});

$app->run();
