<?php

$data = [];

// request 

    if(isset($_GET['option']))
    {
        $option = $_GET['option'];
        if($_GET['option'] == 'status')
        {
            $data['status'] = 'success';
            $data['dado'] = 'aqui vc recebera os dados e trata ele';
        }
        if($option == 'number')
        {
            $max = $_GET['max'] ?? "";
            $min = $_GET['min'] ?? "";
            $quantidade = $_GET['quantidade'] ?? "";
           
            response( randomNumber($data,$max,$min,$quantidade));
        }
    }else{
        $data['status'] = 'ERROR';
    }


//response

    function response($data_response)
    {
        header("Content-Type: application/json");
        echo json_encode($data_response);
    }
    function randomNumber(array $data, int $max = 100, int $min = 0, int $quant = 10)
    {

        $data['status'] = 'success';
        for ($i=0; $i < $quant ; $i++) { 
            $data["dado{$i}"] = rand($min,$max);
        }
        
        return $data;
    }