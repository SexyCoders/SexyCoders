<?php
function getGroup($data)
    {
        $ResponseData=new stdClass;
        $pdo = new \pdo(
        //"mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master',$passwd[0] ,
        "mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master','master' ,
        [
        \pdo::ATTR_ERRMODE            => \pdo::ERRMODE_EXCEPTION,
        \pdo::ATTR_DEFAULT_FETCH_MODE => \pdo::FETCH_ASSOC,
        \pdo::ATTR_EMULATE_PREPARES   => false,
        ]); 

        $stmt = $pdo->prepare("select default_group from users where userid=?");
        $stmt->execute([$data->sub]);
        $ResponseData->default_group=$stmt->fetch()['default_group'];
    return $ResponseData;
    };


function resolveCompany($data)
    {
        $ResponseData=new stdClass;
        $user_redis = new Redis();
        $user_redis->connect('master_company-cache', 6379);
        $ResponseData->company=$user_redis->get($data->sub);
        if(!$ResponseData->company)
            {

                $pdo = new \pdo(
                //"mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master',$passwd[0] ,
                "mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master','master' ,
                [
                \pdo::ATTR_ERRMODE            => \pdo::ERRMODE_EXCEPTION,
                \pdo::ATTR_DEFAULT_FETCH_MODE => \pdo::FETCH_ASSOC,
                \pdo::ATTR_EMULATE_PREPARES   => false,
                ]); 

                $stmt = $pdo->prepare("select company from users where userid=?");
                $stmt->execute([$data->sub]);
                $ResponseData->company=$stmt->fetch()['company'];

                $user_redis = new Redis();
                $user_redis->connect('master_company-cache', 6379);
                $user_redis->set($data->sub,$ResponseData->company);
            }    
    return $ResponseData;
    };

function resolveGroup($data)
    {
        $ResponseData=new stdClass;
        $user_redis = new Redis();
        $user_redis->connect('master_group-cache', 6379);
        $ResponseData->groups=json_decode($user_redis->get($data->sub));
        if(!$ResponseData->groups)
            {

                $pdo = new \pdo(
                //"mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master',$passwd[0] ,
                "mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master','master' ,
                [
                \pdo::ATTR_ERRMODE            => \pdo::ERRMODE_EXCEPTION,
                \pdo::ATTR_DEFAULT_FETCH_MODE => \pdo::FETCH_ASSOC,
                \pdo::ATTR_EMULATE_PREPARES   => false,
                ]); 

                $stmt = $pdo->prepare("select groups from users where userid=?");
                $stmt->execute([$data->sub]);
                $ResponseData->groups=json_decode($stmt->fetch()['groups']);

                $user_redis = new Redis();
                $user_redis->connect('master_group-cache', 6379);
                $user_redis->set($data->sub,json_encode($ResponseData->groups));
            }    
    return $ResponseData;
    };

