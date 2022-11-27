<?php

function getUserDatabases($data)
    {
        $ResponseData=new stdClass;
        $ResponseData->databases=array();
        $groups=resolveGroup($data)->groups;
        $mongo=new MongoDB\Client("mongodb://mongo:mongo@master_mongodb:27017");
        $databases_db=(($mongo)->master->databases);
        
        //get all databases where user is owner
        //get all databases where user is in group and group has read permissions, or where 'others' have read permissions
        //BUT user is not owner to avoid duplicates with the above query
        $matcher=array(
            '$or'=>array(
            array('owner'=>array('$ne'=>$data->sub)),
            array('$or'=>
                array(
                    array('$and'=>array(array('group'=>array('$in'=>$groups)),array('permissions.g'=>array('$regex'=>'r')))),
                    array('permissions.o'=>array('$regex'=>'r'))
                )),
        ));
        $databases=$databases_db->find($matcher);
        foreach ($databases as $database) {
            array_push($ResponseData->databases,$database);
            }

    return $ResponseData;
    };

function createUserDatabase($req_data)
    {
        //$db_name = $args['db_name'];
        //$command = $args['command'];
        //$req_data=json_decode(base64_decode($request->getBody()));
        $data=$req_data->data;

        //injecting default group of user
        $t=new stdClass;
        $t->sub=$data->user;
        $data->group=getGroup($t)->default_group;
        
        //injecting default permissions
        $data->permissions=new stdClass;
        $data->permissions->u='rwx';
        $data->permissions->g='r-x';
        $data->permissions->o='r-x';


        $ResponseData=new stdClass;
        $ResponseData->error=0;
        //$ResponseData->test=$data;
        $mongo=new MongoDB\Client("mongodb://mongo:mongo@master_mongodb:27017");
        //$db_name=$data->database_id;
        $db=(($mongo)->master->databases);
        $mongo_data=array(
            'date'=>$data->date,
            'user'=>$data->user,
            'database_name'=>$data->database_name,
            'database_id'=>$data->database_id,
            'group'=>$data->group,
            'permissions'=>array(
                'u'=>$data->permissions->u,
                'g'=>$data->permissions->g,
                'o'=>$data->permissions->o,
            ),
            'db_fields'=>$data->db_fields,
        );
        //$ResponseData->check=$mongo_data;
        $t=$db->insertOne($mongo_data);
        if($t->getInsertedCount()!=1)
            $ResponseData->error=1;
        //$ResponseData->testing_something=$ResponseData->t->getInsertedCount();
        //$response->getBody()->write(base64_encode(json_encode($ResponseData)));
    return $ResponseData;
    }