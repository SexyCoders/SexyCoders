<?php
function callback($path, $data) 
        {
            
        $api_host=exec("host master_api | awk '{printf $4}'");
        $ch = curl_init("http://".$api_host.":80".$path);
        $data = base64_encode(json_encode($data));

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER,0);
        $data = curl_exec($ch);
        curl_close($ch); 
        

        return $data;
    }

