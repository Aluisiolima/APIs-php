<?php
    namespace src\model;

    use PDOException;
    class UserModel extends Database
    {
        public function inserirUser($data)
        {
            try {
                $pdo = $this->getConnect();
                $sql = "INSERT INTO user (nome,senha) VALUES (?,?);";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["senha"],
                ]);

                return [
                    "sucess" => "Um usuaria inserido com sucesso!!"
                ];
            }
            catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }
    }