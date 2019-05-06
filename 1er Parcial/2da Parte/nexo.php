<?php

include_once "./clases/vehiculo.php";
include_once "./clases/servicio.php";
include_once "./clases/turnos.php";

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
        else if($caso == "sacarTurno")
        {
            turnos::SacarTurno("./archivos/vehiculos.txt","./archivos/turnos.txt");
        }
        else if($caso == "turnos")
        {
            turnos::Turnos("./archivos/turnos.txt");
        }
        else if($caso == "inscripciones")
        {
            turnos::Inscripciones("./archivos/turnos.txt");
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