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

function getUserDatabases($data)
    {
        $ResponseData=new stdClass;
        $ResponseData->databases=array();
        $groups=resolveGroup($data);
        $mongo=new MongoDB\Client("mongodb://mongo:mongo@master_mongodb:27017");
        $databases_db=(($mongo)->master->databases);
        foreach($groups->groups as $group){
                $t=array(
                'group'=>$group
                );
                $databases=$databases_db->find($t);
                foreach ($databases as $database) {
                        array_push($ResponseData->databases,$database);
        }

        }
    return $ResponseData;
    };

