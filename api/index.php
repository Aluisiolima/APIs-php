<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', 1); 
    ini_set('log_errors', 1);
    require_once(__DIR__."/includes.php");

    $core = new src\core\Core();

    $core->dispache($routes->getRoutes());
