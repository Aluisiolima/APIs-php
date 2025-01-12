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
            $body = $resquest->getBody();

            $user = $this->userServices->inserirUser($body);

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
    }