<?php
    //criando a const da url
    const API_BASE = "http://localhost/php%20apis/api/?";
    //caso passe os valores na url
    if(isset($_GET['option']))
    {
        $option = $_GET['option'];

        if($option == 'number'){
            $max = $_GET['max'] ?? "";
            $min = $_GET['min'] ?? "";
            $quantidade = $_GET['quantidade'] ?? "";
            
            $option = "option=number&min={$min}&max={$max}&quantidade={$quantidade}";
            
        }
        if($option == 'status'){
            $option = 'option=status';
            
        }

    }else{
        $option = "";
    }

    $response = getdados($option);
//a option que deve ser passada
    
    //$option = 'status';
    
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