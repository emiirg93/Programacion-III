<?php

include_once "./clases/proveedor.php";

$caso = $_SERVER['REQUEST_METHOD'];

switch($caso)
{
    case "POST":
    proveedor::CargarProveedor();
    break;
    
    case "PUT":
    break;

    case "GET":
    $ingresado = $_GET['caso'];
    
    if($ingresado == "consultarProveedor"){
        proveedor::ConsultarProveedor();
    }
    else if ($ingresado == "proveedores")
    {
        proveedor::Proveedores();
    }
    break;

    case "DELETE":
    break;
}



?>