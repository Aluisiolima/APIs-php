<?php 
    namespace src\services;

    use src\model\UserModel;
    use src\utils\Validate;
    use src\http\JWT;
    use PDOException;
    use Exception;
    class UserServices
    {
        private $validate;
        private $userModel;
        private $jwt;
        public function __construct()
        {
            $this->validate = new Validate();
            $this->userModel = new UserModel();
            $this->jwt = new JWT();
        }
        public function inserirUser($data, $auth)
        {
            try{
                if(isset($auth["error"])) return ["unauthorized" => "Voce nao passou um Token por favor faça login!!!"];

                $token = $this->jwt->verify($auth);
                if(!$token) return ["unauthorized"=> "Seu token e Invalido  por favor faça login!!!"];

                $dados = $this->validate->validate([
                    "nome"  => $data["nome"]  ?? "",
                    "senha" => $data["senha"] ?? "",
                ]);

                $dados["senha"] = password_hash($dados["senha"], PASSWORD_DEFAULT);

                $user = $this->userModel->inserirUser($dados);

                return $user;
            }catch (Exception $e){
                return ["error" => $e->getMessage()];
            } catch (PDOException $e){
                return ["error" => $e->getMessage()];
            }
        }
        public function login($data)
        {
            try{
                $dados = $this->validate->validate([
                    "id"    => $data["id"]      ?? "",
                    "nome"  => $data["nome"]    ?? "",
                    "senha" => $data["senha"]   ?? "",
                ]);

                $user = $this->userModel->login($dados);
                if(isset($user["error"])) return ["error"=> $user["error"]];

                $token = $this->jwt->generate($user);
                return ["token" => $token];
            } catch (Exception $e){
                return ["error"=> $e->getMessage()];
            } catch (PDOException $e){
                return ["error"=> $e->getMessage()];
            }
        }
        public function pegar()
        {
            try{
                $user = $this->userModel->pegar();
                
                return $user;
            } catch (Exception $e){
                return ["error"=> $e->getMessage()];
            } catch (PDOException $e){
                return ["error"=> $e->getMessage()];
            }
        }
    }