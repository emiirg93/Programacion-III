<?php

include_once "validaciones.php";

class vehiculo{

    public $marca;
    public $modelo;
    public $patente;
    public $precio;

    public function __construct($mar,$mod,$pat,$pre) {
        $this->marca = $mar;
        $this->modelo = $mod;
        $this->patente = $pat;
        $this->precio = $pre;
    }

    public static function CargarVehiculo($path)
    {

        if(validaciones::IngresoDatosVehiculo())
        {

            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $patente = $_POST['patente'];
            $precio = $_POST['precio'];

            if(!validaciones::patenteExiste($patente,$path))
            {
                if(file_exists($path))
                {
                    $file = fopen($path, "a");

                    fwrite($file, "$marca,$modelo,$patente,$precio\r\n");

                    fclose($file);
                }
                else
                {
                    $file = fopen($path, "w");

                    fwrite($file, "$marca,$modelo,$patente,$precio\r\n");

                    fclose($file);
                }
            }
            else
            {
                echo "La Patente ".$patente." Ya Existe En El Sistema.";
            }        
        }
        else
        {
            echo "Falta Ingresar Alguno De Los Siguientes Datos (marca,modelo,patente,precio).";
        }
        
    }

    public static function MostrarVehiculo($vehiculo)
    {
        echo    "Marca: ".$vehiculo->marca."<br>
                Modelo : ".$vehiculo->modelo."<br>
                Patente : ".$vehiculo->patente."<br>
                Precio : ".$vehiculo->precio."<br><br>";
    }

    public static function ConsultarVehiculo($path)
    {
            if(isset($_GET['marca']))
            {
                validaciones::BuscarPorMarca($_GET['marca'],$path);
            }
            else if(isset($_GET['patente']))
            {
                validaciones::BuscarPorPatente($_GET['patente'],$path);
            }
            else if(isset($_GET['modelo']))
            {
                validaciones::BuscarPorModelo($_GET['modelo'],$path);
            }
            else
            {
                echo "No Se Ingreso Ningun Criterio De Busqueda (marca,modelo,patente).";
            }
    }

}





?>