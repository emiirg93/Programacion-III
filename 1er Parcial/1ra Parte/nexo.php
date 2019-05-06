<?php

include_once "./clases/vehiculo.php";
include_once "./clases/servicio.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $caso = $_POST['caso'];

        if($caso == "cargarVehiculo"){
           vehiculo::CargarVehiculo("./archivos/vehiculos.txt"); 
        }
        else if($caso == "cargarTipoServicio")
        {
            servicio::CargarServicio("./archivos/tiposServicio.txt");
        }

        break;
    case 'GET':

        $caso = $_GET['caso'];
        
        if($caso == "consultarVehiculo"){
            vehiculo::consultarVehiculo("./archivos/vehiculos.txt");
        }
        break;
    case 'PUT':
        # code...
        break;
    case 'DELETE':
        # code...
        break;
}

?>