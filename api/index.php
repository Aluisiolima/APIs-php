<?php

$data = [];

// request 

    if(isset($_GET['option']))
    {
        switch ($_GET['option']) {
            case 'status':
                $data['status'] = 200;
                $data['data'] = "OK success, no error => {$data['status']}";
                break;
            
            default:
                $data['status'] = 'ERROR';
                break;
        }
    }else{
        $data['status'] = 'ERROR';
    }

//mostra resultados 
 response($data);


//response

    function response($data_response)
    {
        header("Content-Type: application/json");
        echo json_encode($data_response);
    }