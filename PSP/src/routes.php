<?php

include_once "../src/usuarioApi.php";
include_once "../src/MWparaAutentificar.php";
include_once "../src/articuloApi.php";
include_once "../src/MWGuardarInfoEnDB.php";

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {

    $container = $app->getContainer();
    $app->post('/usuario', function (Request $request, Response $response, array $args) use ($container) {
        $response->getBody()->write(usuarioApi::Alta($request, $response, $args));
    });

    $app->post('/login', function (Request $request, Response $response, array $args) use ($container) {
        $response->getBody()->write(usuarioApi::_login($request, $response, $args));
    });

    $app->get('/usuario', function (Request $request, Response $response, array $args) use ($container) {
        $response->getBody()->write(usuarioApi::ListaUsuarios($request, $response, $args));
    })->add(\MWparaAutentificar::class . ':VerificarUsuario');

    $app->post('/compra', function (Request $request, Response $response, array $args) use ($container) {
        $response->getBody()->write(articuloApi::AltaCompra($request, $response, $args));
    });

    $app->get('/compra', function (Request $request, Response $response, array $args) use ($container) {
        $response->getBody()->write(articuloApi::ListadoDeCompras($request, $response, $args));
    });

    $app->add(\MWGuardarInfoEnDB::class . ':GuardarDatosEnDB'); //middleware global
};
