<?php
require_once("./src/http/Routes.php");


$routes = new src\http\Routes; 

$routes->get("/","HomeController@index");

$routes->post("/inserir","UserController@inserirUser");
$routes->post("/login","UserController@login");
$routes->put("/edite","UserController@editeUser");
$routes->get("/pegar","UserController@pegarUser");
$routes->delete("/remove","UserController@removeUser");