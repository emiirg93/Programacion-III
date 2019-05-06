<?php

class servicio{

    public $id;
    public $tipo;
    public $precio;
    public $demora;

    public function __construct($ID,$ti,$pre,$dem) {
        $this->id = $ID;
        $this->tipo = $ti;
        $this->precio = $pre;
        $this->demora = $dem;
    }

    public static function CargarServicio($path)
    {
        if(validaciones::IngresoDatosServicio()){

            $id = $_POST['id'];
            $tipo = $_POST['tipo'];
            $precio = $_POST['precio'];
            $demora = $_POST['demora'];

            if(file_exists($path))
            {
                $arrayServicio = validaciones::ArrayObjetosServicio($path);
            
                if(count($arrayServicio)<3)
                {
                    $file = fopen($path, "a");

                    fwrite($file, "$id,$tipo,$precio,$demora\r\n");

                    fclose($file);
                }
                else
                {
                   echo "Ya Se Ingresaron Los 3 Tipos De Servicios";
                }
            } 
            else
            {
                $file = fopen($path, "w");

                fwrite($file, "$id,$tipo,$precio,$demora\r\n");

                fclose($file);
            }
        }
        else
        {
            echo "Falta Ingresar Alguno De Los Siguientes Datos (id,tipo,precio,demora).";
        }
    }
}




?>