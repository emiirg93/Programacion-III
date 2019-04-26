<?php

include_once "./clases/proveedor.php";
include_once "./clases/pedidos.php";

$caso = $_SERVER['REQUEST_METHOD'];

switch($caso)
{
    case "POST":

    $ingresado = $_POST['caso'];

    if($ingresado == "cargarProveedor"){
        proveedor::CargarProveedor();
    }
    else if($ingresado == "hacerPedido"){
        pedidos::hacerPedido();
    }
    else if($ingresado == "modificarProveedor"){
        proveedor::Modificar();
    }
    
    break;

    case "PUT":
    break;

    case "GET":

    $ingresado = $_GET['caso'];
    
    if($ingresado == "consultarProveedor")
    {
        proveedor::ConsultarProveedorNom();
    }
    else if ($ingresado == "proveedores")
    {
        proveedor::Proveedores();
    }
    else if($ingresado == "listarPedidos")
    {
        pedidos::ListarPedidos();
    }
    else if($ingresado == "listarPedidoProveedor")
    {
        pedidos::listarPedidoProveedor();
    }
    else if($ingresado == "fotosBack")
    {
        proveedor::ListarFotosBack();
    }
    break;

    case "DELETE":
    break;
}



?>