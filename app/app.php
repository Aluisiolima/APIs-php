<?php
//criando a const da url
    const API_BASE = "http://localhost/php%20apis/api/?option=";
//a option que deve ser passada
    $option = "status";

    $response = getdados($option);
    echo "<h3>response</h3>";
    echo "<pre>";
    print_r($response);


//pegar esse dados 
    function getdados($url){
        $client = curl_init(API_BASE . $url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($client);
        return json_decode($response);
    }