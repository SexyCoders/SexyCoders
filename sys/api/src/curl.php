<?php
function curl($token,$dest,$method,$data)
        {
        switch($method)
                {
                case "POST":
                        $post_data = json_encode($data);

                        // Prepare new cURL resource
                        $crl = curl_init($dest);
                        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($crl, CURLINFO_HEADER_OUT, true);
                        curl_setopt($crl, CURLOPT_POST, true);
                        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

                        $myheader="Authorization: Bearer ".$token;
                        // Set HTTP Header for POST request
                        curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($post_data)),
                        $myheader
                        );

                        // Submit the POST request
                        $result = curl_exec($crl);
                        
                        curl_close($crl);
                return $result;        
                };
        };
