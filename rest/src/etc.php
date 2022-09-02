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

