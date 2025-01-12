<?php
    namespace src\core;

    use src\http\Resquest;
    use src\http\Response;

    class Core
    {
        private $req;
        private $res;

        public function __construct()
        {
            $this->req = new Resquest();
            $this->res = new Response();
        }

        public function dispache($routes)
        {
            $url = "/";
            isset($_GET["url"]) && $url .= $_GET["url"];
            $url !== "/" && rtrim($url, "/");
            
            $prefixoController = "src\\controller\\";
            $routeFound = false;

            foreach ($routes as $route) {
                $padrao = "#^" . preg_replace("/{id}/", "([\w-]+)", $route["path"]) . "$#";

                if(preg_match($padrao, $url, $matches)) {
                    array_shift($matches);
                    $routeFound = true;

                    if($route["method"] !== $this->req->method()){
                        $this->res->json([
                            "erro" => "Nao existe esse method para essa route !!!"
                        ],400);
                        return;
                    }

                    [$controller, $action] = explode("@", $route["action"]);
                    $controller = $prefixoController . $controller;
                    $extendController = new $controller();
                    $extendController->$action();
                    return;
                }
            }
            if (!$routeFound) {
                $controller = $prefixoController . "NotFoundController";
                $extendController = new $controller();
                $extendController->index();
            }
        }
    }