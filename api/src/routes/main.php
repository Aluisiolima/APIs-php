<?php
require_once("./src/http/Routes.php");


$routes = new src\http\Routes; 

$routes->get("/","HomeController@index");