<?php
    namespace src\controller;

    use src\http\Response;
    class NotFoundController
    {
        private $res;
        public function __construct()
        {
            $this->res = new Response();
        }
        public function index()
        {
            $this->res->json([
                "error" => "Essa Route nao existe!!"
            ], 404);
            return;
        }
    }