<?php

include_once "proveedor.php";

class validaciones{

    public static function IngresoDatos()
    {
        $tof = false;

        if(isset($_POST['id'])&&isset($_POST['nombre'])&&isset($_POST['email'])&&isset($_FILES['imagen']))
        {
            $tof = true;
        }

        return $tof;
    }

    public static function ConsultarPorID($id,$path)
    {
        $retorno = "";

        if(file_exists($path)){
        
            $file = fopen($path,"r");
            $arrayProveedores = array();
            $flag = false;
            
            while(!feof($file)){
                
            $array = explode(",",fgets($file));    
                
                if($array[0]!=null){
                    $prov = new proveedor($array[0],$array[1],$array[2],$array[3]);
                    array_push($arrayProveedores,$prov);
                }

            }

            fclose($file);

            $arrayProveedores = proveedor::QuitarEspacio($arrayProveedores);

            foreach ($arrayProveedores as $variable) {
                if($variable->id == $id){
                    $flag = true;
                    $retorno = $variable;
                    break;
                }
            }

            if($flag == false){
                $retorno = "no existe el proveedor con el ID : ".$id;
            }
        }

        return $retorno;
    }

    public static function ConsultarPorNombre($nombre,$path)
    {

        if(file_exists($path)){
        
            $file = fopen($path,"r");
            $arrayProveedores = array();
            $flag = false;
            
            while(!feof($file)){
                
            $array = explode(",",fgets($file));    
                
                if($array[0]!=null){
                    $prov = new proveedor($array[0],$array[1],$array[2],$array[3]);
                    array_push($arrayProveedores,$prov);
                }

            }

            fclose($file);

            foreach ($arrayProveedores as $variable) {
                if($variable->nombre == $nombre){
                    proveedor::MostrarProveedor($variable);
                    $flag = true;
                    break;
                }
            }

            if($flag == false){
                echo "no existe el proveedor : ".$nombre;
            }

        }
        else{
            echo "No existe el archivo";
        }
    }

    public static function existeID($path,$id)
    {
        $tof = false;

        $arrayProveedores = proveedor::ArrayObjetosProveedor($path);
            
        foreach ($arrayProveedores as $item) {
            if($item->id == $id)
            {
                $tof = true;
                break;
            }
        }

        return $tof;
       
    }
}

    


?>