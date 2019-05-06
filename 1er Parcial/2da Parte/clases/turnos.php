<?php

include_once "vehiculo.php";
include_once "validaciones.php";

class turnos extends vehiculo{

    public $fecha;
    public $tipo;

    public function __construct($mar,$mod,$pat,$pre,$fec,$ti) {
        parent::__construct($mar,$mod,$pat,$pre);
        $this->fecha=$fec;
        $this->tipo=$ti;
    }

    public static function SacarTurno($pathVehiculo,$pathTurnos)
    {
        if(validaciones::IngresoDatosTurno())
        {
            $fecha = $_GET['fecha'];
            $tipo = $_GET['tipo'];

            if(validaciones::PatenteExiste($_GET['patente'],$pathVehiculo))
            {
                $vehiculo = validaciones::TraerPorPatente($_GET['patente'],$pathVehiculo);
                
                if(validaciones::IngresoTipoTurno())
                {
                    if(file_exists($pathTurnos))
                    {
                        $file = fopen($pathTurnos, "a");

                        fwrite($file, "$vehiculo->marca,$vehiculo->modelo,$vehiculo->patente,$vehiculo->precio,$fecha,$tipo\r\n");

                        fclose($file);
                    }
                    else
                    {
                        $file = fopen($pathTurnos, "w");

                        fwrite($file, "$vehiculo->marca,$vehiculo->modelo,$vehiculo->patente,$vehiculo->precio,$fecha,$tipo\r\n");

                        fclose($file);
                    }
                }
                else
                {
                    echo "Ingrese Un Tipo De Servicio Valido (10.000km , 20.000km , 50.000km).";
                }
            }
            else
            {
                echo "La Patente ".$_GET['patente']." Ingresada Es Inexistente";
            }
        }
        else
        {
            echo "Falta Ingresar Alguno De Los Siguientes Datos (patente,fecha,tipo).";
        }
    }
    
    public static function MostrarTurno($turno)
    {
        echo    "
                Fecha: ".$turno->fecha."<br>
                ------------------------------------<br>
                AUTO<br>
                Marca: ".$turno->marca."<br>
                Modelo : ".$turno->modelo."<br>
                Patente : ".$turno->patente."<br>
                Precio : ".$turno->precio."<br>
                ------------------------------------<br>
                Tipo De Servicio : ".$turno->tipo."<br><br>";

    }

    public static function Turnos($path)
    {
        $arrayTurnos = validaciones::ArrayObjetosTurnos($path);

        foreach ($arrayTurnos as $item) {
            turnos::MostrarTurno($item);
        }
    }

    public static function Inscripciones($path)
    {
        if(isset($_GET['tipo']))
        {
            if(validaciones::IngresoTipoTurno())
            {
                validaciones::BuscarTurnoPorTipo($_GET['tipo'],$path);
            }
            else
            {
                echo "Ingrese Un Tipo De Servicio Valido (10.000km , 20.000km , 50.000km).";
            }
            
        }
        else if(isset($_GET['fecha']))
        {
            validaciones::BuscarTurnoPorFecha($_GET['fecha'],$path);
        }
    }

}






?>