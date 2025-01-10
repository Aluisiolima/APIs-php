<?php
    namespace src\core;

    class Core
    {
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

                    [$controller, $action] = explode("@", $route["action"]);
                    $controller = $prefixoController . $controller;
                    $extendController = new $controller();
                    $extendController->$action();
                    return;
                }
            }
        }
    }