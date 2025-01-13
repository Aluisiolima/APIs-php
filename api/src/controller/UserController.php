<?php 
    namespace src\controller;

    use src\http\Response;
    use src\http\Resquest;
    use src\services\UserServices;

    class UserController
    {
        private $userServices;
        public function __construct()
        {
            $this->userServices = new UserServices();
        }
        public function inserirUser(Resquest $resquest, Response $response)
        {
            $auth = $resquest->getAuth();
            $body = $resquest->getBody();

            $user = $this->userServices->inserirUser($body, $auth);

            if (isset($user["unauthorized"])) {
                $response->json(["error"=> $user["unauthorized"]], 401);
                return;
            }
            if (isset($user["error"])) {
                $response->json(["error"=> $user["error"]], 400);
                return;
            }

            $response->json($user, 200);
        }
        public function login(Resquest $resquest, Response $response)
        {
            $body = $resquest->getBody();

            $user = $this->userServices->login($body);

            if (isset($user["error"])) {
                $response->json(["error"=> $user["error"]], 400);
                return;
            }

            $response->json($user, 200);
        }
        public function pegarUser(Resquest $resquest, Response $response)
        {
            $user = $this->userServices->pegar();

            if (isset($user["error"])) {
                $response->json(["error"=> $user["error"]], 400);
                return;
            }

            $response->json($user, 200);
        }
    }