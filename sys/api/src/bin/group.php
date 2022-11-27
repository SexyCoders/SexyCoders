<?php

function createGroup($data)
    {
        $ResponseData=new stdClass;
        // $user_redis = new Redis();
        // $user_redis->connect('master_group-cache', 6379);
        // $ResponseData->groups=json_decode($user_redis->get($data->sub));
        // if(!$ResponseData->user_exists)
            // {
                $pdo = new \pdo(
                //"mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master',$passwd[0] ,
                "mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master','master' ,
                [
                \pdo::ATTR_ERRMODE            => \pdo::ERRMODE_EXCEPTION,
                \pdo::ATTR_DEFAULT_FETCH_MODE => \pdo::FETCH_ASSOC,
                \pdo::ATTR_EMULATE_PREPARES   => false,
                ]); 

                $id_hash = md5($data->name.time()); 
                $stmt = $pdo->prepare("insert into groups values (?,?)");
                $ResponseData->result = $stmt->execute([$data->name,$id_hash]);
            // }
    return $ResponseData;
    };