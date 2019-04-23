<?php

class proveedor{

        public $id;
        public $nombre;
        public $email;

        public function __construct($ID,$nom,$correo) {
            $this->id = $ID;
            $this->nombre = $nom;
            $this->email = $correo;
        }

        public static function CargarProveedor()
        {

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $foto = $_FILES['imagen'];
            
            if(isset($foto))
            {
                proveedor::TrabajarConFoto();
            }

            if(file_exists("./archivos/proveedores.txt"))
            {
                $file = fopen("./archivos/proveedores.txt", "a");

                fwrite($file, "$id,$nombre,$email\r\n");

                fclose($file);
            }
            else
            {
                $file = fopen("./archivos/proveedores.txt", "w");

                fwrite($file, "$id,$nombre,$email\r\n");

                fclose($file);
            }
            
        }

        public static function TrabajarConFoto()
        {
            $nombreViejo = $_FILES['imagen']['tmp_name'];
            $nombre = $_POST['nombre'];
            $id = $_POST['id'];

            $extensionFile = explode(".",$_FILES['imagen']['name']);
            $nombreNuevo = "./fotos/".$id .".".$nombre .".".$extensionFile[1];

            if(file_exists($nombreNuevo))
            {
            move_uploaded_file($nombreViejo, $nombreNuevo);
            }
            else
            {
                move_uploaded_file($nombreViejo, $nombreNuevo);
            } 

        }

        public static function MostrarProveedor($proveedor)
        {
            echo "ID: ".$proveedor->id."<br>
                  Nombre : ".$proveedor->nombre."<br>
                  email : ".$proveedor->email."<br><br>";
        }

        public static function Proveedores()
        {
            $arrayProveedores = array();

            if(file_exists("./archivos/proveedores.txt"))
            {
                $file = fopen("./archivos/proveedores.txt", "r");

                while(!feof($file))
                {
                    $array = explode(",",fgets($file)); 

                    if($array[0]!=null){
                        $prov = new proveedor($array[0],$array[1],$array[2]);
                        array_push($arrayProveedores,$prov);
                    }
                }

                fclose($file);

            }

            foreach ($arrayProveedores as $variable) {
                proveedor::MostrarProveedor($variable);
            }

            
        }

        public static function ConsultarProveedorID($id)
        {
            $retorno;

            if(file_exists("./archivos/proveedores.txt")){
            
                $file = fopen("./archivos/proveedores.txt","r");
                $arrayProveedores = array();
                $flag = false;
                
                while(!feof($file)){
                    
                $array = explode(",",fgets($file));    
                    
                    if($array[0]!=null){
                        $prov = new proveedor($array[0],$array[1],$array[2]);
                        array_push($arrayProveedores,$prov);
                    }

                }

                fclose($file);

                foreach ($arrayProveedores as $variable) {
                    if($variable->id == $id){
                        $flag = true;
                        $retorno = $variable;
                    }
                }

                if($flag == false){
                    $retorno = "no existe el proveedor con el ID : ".$id;
                }
            }

            return $retorno;
        }

        public static function ConsultarProveedorNom()
        {
            $nombre = $_GET['nombre'];

            if(file_exists("./archivos/proveedores.txt")){
            
                $file = fopen("./archivos/proveedores.txt","r");
                $arrayProveedores = array();
                $flag = false;
                
                while(!feof($file)){
                    
                $array = explode(",",fgets($file));    
                    
                    if($array[0]!=null){
                        $prov = new proveedor($array[0],$array[1],$array[2]);
                        array_push($arrayProveedores,$prov);
                    }

                }

                fclose($file);

                foreach ($arrayProveedores as $variable) {
                    if($variable->nombre == $nombre){
                        proveedor::MostrarProveedor($variable);
                        $flag = true;
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

        public static function ArrayObjetosProveedor()
        {
            $arrayProveedores = array();

            if(file_exists("./archivos/proveedores.txt"))
            {
                $file = fopen("./archivos/proveedores.txt", "r");

                while(!feof($file))
                {
                    $array = explode(",",fgets($file)); 

                    if($array[0]!=null){
                        $prov = new proveedor($array[0],$array[1],$array[2]);
                        array_push($arrayProveedores,$prov);
                    }
                }

                fclose($file);

            }

            return $arrayProveedores;
        }


}




?>