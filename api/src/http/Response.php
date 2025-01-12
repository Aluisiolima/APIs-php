<?php
    namespace src\http;

    class Response
    {
        public function json($data, $status = 200)
        {
            http_response_code($status);
            header("Content-Type: application/json");
            $json = [
                "status"=> $status,
                "data"=> $data
            ];
            echo json_encode($json);
        }
    }