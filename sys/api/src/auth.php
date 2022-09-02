<?php
function auth($token) 
        {
        $keycloak_host=exec("host sso_keycloak | awk '{printf $4}'");
        $ch = curl_init("http://".$keycloak_host.":8080/realms/testing/.well-known/openid-configuration");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER,0);
        $data = json_decode(curl_exec($ch));
        curl_close($ch); 
        if (property_exists($data,'error')) {
            return "NOAUTH";
        }
        $myheader="Authorization: Bearer ".$token;
        $ch = curl_init($data->userinfo_endpoint); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        $myheader
        ));
        $data = curl_exec($ch);
        curl_close($ch); 
        return $data;
    }

