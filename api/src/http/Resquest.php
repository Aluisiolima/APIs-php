<?php
    namespace src\http;

    class Resquest
    {
        public function method()
        {
            return $_SERVER["REQUEST_METHOD"];
        }

        public function getAuth()
        {
            $auth = getallheaders();

            if (!isset($auth["Authorization"])) return ["error" => "Voce nao passou o token, tente fazer login!!!"];

            $authPartes = explode(" ", $auth["Authorization"]);
            if (count($authPartes) != 2) return ["error"=> "Esse token esta invalido, por favor faça login!!"];

            return $authPartes[1] ?? "";
        }

        public function getBody()
        {
            $body = json_decode(file_get_contents("php://input"), true) ?? "";

            $data = match (self::method()) {
                "GET" => $_GET,
                "POST", "PUT", "DELETE" => $body
            };
            
            return $data;
        }
    }