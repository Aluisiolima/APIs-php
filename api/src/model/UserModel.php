<?php
    namespace src\model;

    use PDOException;
    use PDO;
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
        public function login($data)
        {
            try {
                $pdo = $this->getConnect();
                $sql = "SELECT * FROM user WHERE nome = ? AND id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["id"],
                ]);

                if ($stmt->rowCount() < 1) return ["error"=> "Nao existe User com esse paramentros"];

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!password_verify($data["senha"], $result["senha"])) {
                    return ["error" => "Sua senha está errada!!!"];
                }

                return [
                    "id"   => $result["id"],
                    "nome" => $result["nome"],
                ];

            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }
        public function pegar()
        {
            try {
                $pdo = $this->getConnect();
                $sql = "SELECT nome,id FROM user";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }
        public function edit($data, $id)
        {
            try {
                $pdo = $this->getConnect();
                $sql = "UPDATE user SET nome = ? WHERE id = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $id
                ]);
                
                return [
                    "sucess" => "user editado com sucesso!!"
                ];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }
        public function remove($id)
        {
            try {
                $pdo = $this->getConnect();
                $sql = "DELETE FROM user WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                
                return [
                    "sucess" => "User deletado com sucesso!!!!"
                ];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }
    }