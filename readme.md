# Documentação da API em PHP utilizando POO

## Visão Geral
Essa é uma API desenvolvida em PHP para fins de estudo, com uma arquitetura baseada em Programação Orientada a Objetos (POO) e organizada seguindo os padrões da PSR-4. Todo o gerenciamento das rotas e operações da API é realizado por um único arquivo `index.php` localizado na raiz do projeto, como a finalidade e php puro não iremos usa composer então todos os arquivo que devem ser inseridos sao listados em `includes.php` tambem da na raiz

## Tecnologias Utilizadas
- **PHP**: Linguagem de programação principal.
- **MySQL**: Banco de dados relacional para armazenamento de informações.
- **Apache**: Um servidor para a ultizacao do mod-rewrite
- **Insomnia**: Ferramentas para testes de rotas.

## Estrutura do Projeto
O projeto segue a seguinte estrutura de diretórios:

```
api/
├── Model/
│   ├── Database.php
|   ├── UserModel.php
├── Controllers/
│   ├── UserController.php
│   ├── HomeController.php
│   ├── NotFoundController.php
├── Services/
│   ├── UserServices.php
├── includes.php
├── loadEnv.php
├── .htaccess
└── index.php
```

### Arquivo `Model/Database.php`
Esse arquivo é responsável por configurar a conexão com o banco de dados.

Exemplo:
```php
  namespace src\model;

  use PDOException;
  use PDO;

    class Database
    {
        
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

```
voce pode verifica essa class [aqui](./api/src/model/Database.php)

### Diretório `Controllers/`
Contém as classes responsáveis por gerenciar as requisições e respostas da API.

Exemplo de controlador `UserController`:
```php
namespace src\controller;

    use src\http\Response;
    use src\http\Resquest;
    use src\services\UserServices;

    class UserController
    {
       
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
    }
```
voce pode verifica essa class [aqui](./api/src/controller/UserController.php)

### Diretório `Services/`
Contém as classes responsáveis por gerenciar as verficacoes e validacoes da API, essa a area para as regras de negocio.

Exemplo de controlador `UserServices`:
```php
namespace src\services;

    use src\model\UserModel;
    use src\utils\Validate;
    use src\http\JWT;
    use PDOException;
    use Exception;
    class UserServices
    {
        
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
    }
```
voce pode verifica essa class [aqui](./api/src/services/UserServices.php)

### Diretório `Models/`
Contém as classes que representam as entidades do sistema. Cada classe se comunica diretamente com o banco de dados.

Exemplo de modelo `UserModel`:
```php

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
    }

```
voce pode verifica essa class [aqui](./api/src/model/UserModel.php)


### Arquivo `index.php`
Este é o ponto de entrada principal da API. Ele gerencia as rotas e inicializa os componentes necessários.

Exemplo:
```php
    error_reporting(E_ALL); // Relatar todos os erros
    ini_set('display_errors', 1); // Exibir erros na saída
    ini_set('log_errors', 1); // Registrar erros em um arquivo
    require_once(__DIR__."/includes.php");

    $core = new src\core\Core();

    $core->dispache($routes->getRoutes());
```

## Como Usar a API
1. Configure o banco de dados no arquivo `.env` com as variaveis em `.env.example` e configure com as variavel adquadas para seu ambiente.
2. Crie a tabela `user` no MySQL:

```sql
CREATE TABLE `user` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(200) NOT NULL
);
```

3. Iniciando a api:
- Mova os arquivos para o repositorio do seu servidor Apache `/var/www/html/` ou o do seu servidor instalado 

4. Acesse as rotas no navegador ou utilizando ferramentas como Postman ou Insomnia:
  - `GET: localhost:8080/`: e vera  `Hello word` corfimando que sua aplicacao funcionando.


---

## 📝 **Endpoints**

### **Exemplo de Estrutura**  
| Método | Rota              | Descrição                   | Autenticação |
|--------|-------------------|-----------------------------|--------------|
| GET    | `/pegar`          | Lista todos os produtos     | Não          |
| POST   | `/inserir`        | Adiciona um novo produto    | Sim          |
| PUT    | `/edite`          | Atualiza um produto         | Sim          |
| DELETE | `/remove`         | Remove um produto específico| Sim          |


