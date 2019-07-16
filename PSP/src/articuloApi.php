<?php

include_once "../src/AutentificadorJWT.php";
include_once "../src/articulo.php";

class articuloApi extends articulo
{

    public function AltaCompra($request, $response, $args)
    {
        $objRespuesta = new stdClass();

        $arrayDatos = $request->getParsedBody();

        $nombre = $arrayDatos['articulo'];
        $precio = $arrayDatos['precio'];
        $token = $arrayDatos['token'];
        $fecha = date("d-m-Y");

        $usuario = AutentificadorJWT::ObtenerData($token);

        $articulo = new articuloApi();

        $idCompra = $articulo->CrearID();

        $articulo->TrabajarConFoto("../src/IMGCompras/", $nombre, $idCompra);

        $articulo = articulo::constructorFalso($usuario->id, $idCompra, $nombre, $fecha, $precio);

        if ($articulo->InsertarBD()) {
            $objRespuesta->respuesta = "Se ha realizado la compra correctamente.";
        } else {
            $objRespuesta->respuesta = "No se ha podido realizar la compra.";
        }
        return $objRespuesta->respuesta;
    }

    public function TrabajarConFoto($ruta, $nombre, $idCompra)
    {
        $nombreViejo = $_FILES['foto']['tmp_name'];

        $nombreNuevo = articuloApi::changeImgName($_FILES['foto']['name'], $ruta, $nombre, $idCompra);

        move_uploaded_file($nombreViejo, $nombreNuevo);
    }

    public static function changeImgName($nameImg, $path, $nombreArticulo, $idCompra)
    {
        $arrayNameImg = explode('.', $nameImg);
        //$date = new \DateTime('America/Argentina/Buenos_Aires');
        //$date = new \DateTime('+5 day');
        //$fecha = $date->format('d-m-Y');
        $arrayNameImg[0] = $path . $idCompra . "." . $nombreArticulo;
        $nameImg = $arrayNameImg[0] . "." . $arrayNameImg[1];
        return $nameImg;
    }

    public function ListadoDeCompras($request, $response, $args)
    {
        $objRespuesta = new stdClass();

        $arrayDatos = $request->getParsedBody();
        $token = $arrayDatos['token'];

        $usuario = AutentificadorJWT::ObtenerData($token);

        if ($usuario->perfil == "admin") {
            $arrayArticulos = articulo::TodasLasCompras();
            $objRespuesta->respuesta = articulo::MostrarTodos($arrayArticulos);
        } else {
            $compras = articulo::ComprasUsuario($usuario->id);
            $objRespuesta->respuesta = articulo::MostrarTodos($compras);
        }

        return $objRespuesta->respuesta;

    }

    public function CrearID()
    {
        $arrayCompras = articulo::TodasLasCompras();
        $max = 0;
        $id;

        foreach ($arrayCompras as $compra) {
            if ($compra->idCompra > $max) {
                $max = $compra->idCompra;
                $id = $max;
            }
        }

        $id = $id + 1;

        return $id;
    }
}
