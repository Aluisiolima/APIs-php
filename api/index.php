<?php
    error_reporting(E_ALL); // Relatar todos os erros
    ini_set('display_errors', 1); // Exibir erros na saída
    ini_set('log_errors', 1); // Registrar erros em um arquivo
    require_once(__DIR__."/includes.php");

    $core = new src\core\Core();

    $core->dispache($routes->getRoutes());
