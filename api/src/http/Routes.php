<?php
    namespace src\http;

    class Routes
    {
        private $routes = [];
        public function getRoutes()
        {
            return $this->routes;
        }
        public function get($path, $action)
        {
            $this->routes[] = [
                "path"      => $path,
                "action"    => $action,
                "method"    => "GET",
            ];
        }
        public function post($path, $action)
        {
            $this->routes[] = [
                "path"      => $path,
                "action"    => $action,
                "method"    => "POST"
            ];
        }
        public function put($path, $action)
        {
            $this->routes[] = [
                "path"      => $path,
                "action"    => $action,
                "method"    => "PUT"
            ];
        }
        public function delete($path, $action)
        {
            $this->routes[] = [
                "path"      => $path,
                "action"    => $action,
                "method"    => "DELETE"
            ];
        }
    }