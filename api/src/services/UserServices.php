<?php 
    namespace src\services;

    use src\model\UserModel;
    use src\utils\Validate;
    use PDOException;
    use Exception;
    class UserServices
    {
        private $validate;
        private $userModel;
        public function __construct()
        {
            $this->validate = new Validate();
            $this->userModel = new UserModel();
        }
        public function inserirUser($data)
        {
            try{
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
    }