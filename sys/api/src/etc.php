<?php
function getActiveServices($data)
    {
        $ResponseData=new stdClass;
        $ResponseData->services=array();
        $groups=resolveGroup($data);
        $mongo=new MongoDB\Client("mongodb://mongo:mongo@master_mongodb:27017");
        $services_db=(($mongo)->master->services);
        foreach($groups->groups as $group){
                $t=array(
                'group'=>$group
                );
                $services=$services_db->find($t);
                foreach ($services as $service) {
                        array_push($ResponseData->services,$service);
        }

        }
    return $ResponseData;
    };

function checkUserExists($data)
    {
        $ResponseData=new stdClass;
        // $user_redis = new Redis();
        // $user_redis->connect('master_group-cache', 6379);
        // $ResponseData->groups=json_decode($user_redis->get($data->sub));
        // if(!$ResponseData->user_exists)
            // {

                $flag = 0;
                $pdo = new \pdo(
                //"mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master',$passwd[0] ,
                "mysql:host=master_database; dbname=master; charset=utf8mb4; port=3306",'master','master' ,
                [
                \pdo::ATTR_ERRMODE            => \pdo::ERRMODE_EXCEPTION,
                \pdo::ATTR_DEFAULT_FETCH_MODE => \pdo::FETCH_ASSOC,
                \pdo::ATTR_EMULATE_PREPARES   => false,
                ]); 

                $stmt = $pdo->prepare("select exists(select * from users where userid =?) as exists_flag");
                $stmt->execute([$data->sub]);
                $ResponseData->user_exists=json_decode($stmt->fetch()['exists_flag']);
                $ResponseData->test=$data->sub;


                if ($ResponseData->user_exists == null) {
                    $ResponseData->user_exists = "NOEXIST";
                    // $flag =  1;
                }
                else {
                    $ResponseData->user_exists = "TRUE";
                }

                // if (!$flag) {
                //     $user_redis = new Redis();
                //     $user_redis->connect('master_group-cache', 6379);
                //     $user_redis->set($data->sub,json_encode($ResponseData->user_exists));    
                // }
            // }    
    return $ResponseData;
    };
