<?php

require_once '../vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/usuarioApi.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group('/usuario', function () {

    //$this->get('/', \usuarioApi::class . ':traerTodos');

    //$this->get('/{id}', \usuarioApi::class . ':traerUno');

    $this->post('/', \usuarioApi::class . ':CargarUno');

    //$this->delete('/', \usuarioApi::class . ':BorrarUno');

    //$this->put('/', \usuarioApi::class . ':ModificarUno');

});

$app->run();
