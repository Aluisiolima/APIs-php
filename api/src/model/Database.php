<?php
    namespace src\model;

    use PDOException;
    use PDO;

    class Database
    {
        private $db;
        private $user;
        private $password;
        private $host;
        private $port;

        public function __construct()
        {
            $this->db = getenv("DB_NAME");
            $this->user = getenv("USER");
            $this->password = getenv("SENHA");
            $this->host = getenv("HOST");
            $this->port = getenv("PORT");
        }
        protected function getConnect()
        {
            try {
                // Cria uma nova instância de PDO com os parâmetros do ambiente
                $pdo = new PDO(
                    "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db, 
                    $this->user, 
                    $this->password
                );

                // Configura o modo de erro para exceções
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $pdo;

            } catch (PDOException $e) {
                // Exibe uma mensagem de erro em caso de falha na conexão
                echo "Erro na conexão: " . $e->getMessage();
            }
        }
    }

 