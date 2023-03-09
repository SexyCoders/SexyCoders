<?php
function getAllProjects()
    {
        $ResponseData=new stdClass;
        $ResponseData->data=array();
        $mongo=new MongoDB\Client("mongodb://mongo:mongo@master_mongodb:27017");
        $db=(($mongo)->master->projects);
        $projects=$db->find();
            foreach ($projects as $project) {
                array_push($ResponseData->data,$project);
                }
    return $ResponseData;
    };


