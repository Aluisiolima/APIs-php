<?php
    namespace src\http;

    class Resquest
    {
        public function method()
        {
            return $_SERVER["REQUEST_METHOD"];
        }
    }