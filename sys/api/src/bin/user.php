<?php

//!include 

function createUser($data)
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

                $company_hash = md5($data->username.time()); 
                
                $stmt = $pdo->prepare("insert into users values (?,?,'test','[]',?)");
                $ResponseData->result = $stmt->execute([$data->userid, $data->username, $company_hash, 
            ]);

            // }
    return $ResponseData;
    };



    //TODO 
        //? 1 debug callback αν παιζει
        //? 2 να ελεγχει αν  υπαρχει το group του user (resolveGroup), αν οχι τοτε  το φτιάχνει (callback access endpoint για createGroup)
        //? 3 OPERATIONS για το access table 
        //? 4 Θα χτυπαει ενα api για να κανει check αν εχει τα permission και υστερα θα τρεχει