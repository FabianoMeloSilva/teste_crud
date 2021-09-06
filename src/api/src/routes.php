<?php
use core\Router;

$router = new Router();


$router->get('/', 'HomeController@index');

//Atualiza os dados de um desenvolvedor
$router->post('/developers/{id}', 'HomeController@edit');


//Retorna os dados de um desenvolvedor
$router->get('/developer/{id}', 'HomeController@getDev');


//Retorna todos os desenvolvedores 
$router->get('/developers', 'HomeController@lista');


//Adiciona um novo desenvolvedor
$router->post('/developers', 'HomeController@add');



//Apaga o registro de um desenvolvedor
$router->get('/developers/{id}', 'HomeController@delete');

