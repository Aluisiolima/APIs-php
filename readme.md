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
├── .htaccess
└── index.php
```

### Arquivo `Model/Database.php`
Esse arquivo é responsável por configurar a conexão com o banco de dados.

Exemplo:
```php

```

### Diretório `Controllers/`
Contém as classes responsáveis por gerenciar as requisições e respostas da API.

Exemplo de controlador `UserController`:
```php

```

### Diretório `Services/`
Contém as classes responsáveis por gerenciar as verficacoes e validacoes da API, essa a area para as regras de negocio.

Exemplo de controlador `UserServices`:
```php

```

### Diretório `Models/`
Contém as classes que representam as entidades do sistema. Cada classe se comunica diretamente com o banco de dados.

Exemplo de modelo `UserModel`:
```php

```


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



