<?php

include_once "vehiculo.php";
include_once "turnos.php";

    class validaciones{
        
        public static function IngresoDatosVehiculo()
        {
            
            $tof = false;

            if(isset($_POST['marca'])&&isset($_POST['modelo'])&&isset($_POST['patente'])&&isset($_POST['precio'])){
                $tof = true;            
            }

            return $tof;

        }

        public static function IngresoDatosServicio()
        {
            
            $tof = false;

            if(isset($_POST['id'])&&isset($_POST['tipo'])&&isset($_POST['precio'])&&isset($_POST['demora'])){
                $tof = true;            
            }

            return $tof;

        }

        public static function IngresoDatosTurno()
        {
            
            $tof = false;

            if(isset($_GET['patente'])&&isset($_GET['fecha'])&&isset($_GET['tipo'])){

                $tof = true;            
            }

            return $tof;
        }

        public static function IngresoTipoTurno()
        {
            
            $tof = false;

            if($_GET['tipo'] == "10.000km"||$_GET['tipo'] == "20.000km"||$_GET['tipo'] == "50.000km"){  
                $tof = true;            
            }

            return $tof;

        }

        public static function PatenteExiste($patente,$path)
        {
            $tof = false;

            $arrayVehiculos = validaciones::ArrayObjetosVehiculo($path);

            foreach ($arrayVehiculos as $item) {
                if(strcasecmp ($item->patente , $patente) == 0){
                    $tof = true;
                    break;
                }
            }

            return $tof;
        }

        public static function BuscarPorPatente($patente,$path)
        {
            $arrayVehiculos = validaciones::ArrayObjetosVehiculo($path);

            foreach ($arrayVehiculos as $item) {
                if(strcasecmp ($item->patente , $patente) == 0){
                    vehiculo::MostrarVehiculo($item);
                    break;
                }
                else
                {
                    echo "La Patente ".$patente." No Existe En El Sistema.";
                }
            }
        }

        public static function TraerPorPatente($patente,$path)
        {
            $arrayVehiculos = validaciones::ArrayObjetosVehiculo($path);

            foreach ($arrayVehiculos as $item) {
                if(strcasecmp ($item->patente , $patente) == 0){
                    return $item;
                    break;
                }
                else
                {
                    echo "La Patente ".$patente." No Existe En El Sistema.";
                }
            }
        }

        public static function BuscarPorMarca($marca,$path)
        {
            $arrayVehiculos = validaciones::ArrayObjetosVehiculo($path);

            foreach ($arrayVehiculos as $item) {
                if(strcasecmp ($item->marca , $marca) == 0){
                    vehiculo::MostrarVehiculo($item);
                }
                else
                {
                    echo "La Marca ".$marca." No Existe En El Sistema.";
                }
            }
        }
        
        public static function BuscarPorModelo($modelo,$path)
        {
            $arrayVehiculos = validaciones::ArrayObjetosVehiculo($path);

            foreach ($arrayVehiculos as $item) {
                if(strcasecmp ($item->modelo , $modelo) == 0){
                    vehiculo::MostrarVehiculo($item);
                }
                else
                {
                    echo "El Modelo ".$modelo." No Existe En El Sistema.";
                }
            }
        }

        public static function BuscarTurnoPorTipo($tipo,$path)
        {
            $arrayTurnos = validaciones::ArrayObjetosTurnos($path);

            foreach ($arrayTurnos as $item) {
                if(strcasecmp ($item->tipo , $tipo) == 0){
                    turnos::MostrarTurno($item);
                }
                else
                {
                    echo "No Se Encuentra Ningun Turno Con El Tipo De Servicio ".$tipo.".";
                }
            }
        }

        public static function BuscarTurnoPorFecha($fecha,$path)
        {
            $arrayTurnos = validaciones::ArrayObjetosTurnos($path);

            foreach ($arrayTurnos as $item) {
                if(strcasecmp ($item->fecha , $fecha) == 0){
                    turnos::MostrarTurno($item);
                }
                else
                {
                    echo "No Se Encuentra Ningun Turno Con La Fecha ".$fecha.".";
                }
            }
        }

        public static function QuitarEspacio($array)
        {
            $buffer = str_replace("\r\n","", $array);
            
            return $buffer;
        }

        public static function ArrayObjetosVehiculo($path)
        {
            $arrayVehiculos = array();

            if(file_exists($path))
            {
                $file = fopen($path, "r");

                while(!feof($file))
                {
                    $array = explode(",",fgets($file)); 

                    if($array[0]!=null){
                        $vehi = new vehiculo($array[0],$array[1],$array[2],validaciones::QuitarEspacio($array[3]));
                        array_push($arrayVehiculos,$vehi);
                    }
                }

                fclose($file);

            }
            else
            {
                echo "El Archivo No Existe O No Se Encuentra En La Ruta Especificada";
            }

            

            return $arrayVehiculos;
        }

        public static function ArrayObjetosServicio($path)
        {
            $arrayServicio = array();

            if(file_exists($path))
            {
                $file = fopen($path, "r");

                while(!feof($file))
                {
                    $array = explode(",",fgets($file)); 

                    if($array[0]!=null){
                        $servicio = new servicio($array[0],$array[1],$array[2],validaciones::QuitarEspacio($array[3]));
                        array_push($arrayServicio,$servicio);
                    }
                }

                fclose($file);

            }
            else
            {
                echo "El Archivo No Existe O No Se Encuentra En La Ruta Especificada";
            }

            return $arrayServicio;

        }

        public static function ArrayObjetosTurnos($path)
        {
            $arrayTurnos = array();

            if(file_exists($path))
            {
                $file = fopen($path, "r");

                while(!feof($file))
                {
                    $array = explode(",",fgets($file)); 

                    if($array[0]!=null){
                        $turno = new turnos($array[0],$array[1],$array[2],$array[3],$array[4],validaciones::QuitarEspacio($array[5]));
                        array_push($arrayTurnos,$turno);
                    }
                }

                fclose($file);

            }
            else
            {
                echo "El Archivo No Existe O No Se Encuentra En La Ruta Especificada";
            }

            

            return $arrayTurnos;
        }
    }

?>