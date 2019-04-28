<?php

include_once "validaciones.php";

class proveedor{

    public $id;
    public $nombre;
    public $email;
    public $foto;

    public function __construct($ID,$nom,$correo,$nomFoto) {
        $this->id = $ID;
        $this->nombre = $nom;
        $this->email = $correo;
        $this->foto = $nomFoto;
    }

    public static function CargarProveedor()
    {
                    
        if (validaciones::ingresoDatos()) {
            
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $path = "./archivos/proveedores.txt";

            if(!(validaciones::existeID($path,$id))){
                $nombreFoto = proveedor::TrabajarConFoto($path,"./backUpFotos/","./fotos/");

                if(file_exists($path))
                {
                    $file = fopen($path, "a");

                    fwrite($file, "$id,$nombre,$email,$nombreFoto\r\n");

                    fclose($file);
                }
                else
                {
                    $file = fopen($path, "w");

                    fwrite($file, "$id,$nombre,$email,$nombreFoto\r\n");

                    fclose($file);
                }
            }else
            {
                echo "el ID ingresado ya existe<br>Ingrese un nuevo ID.";
            }
            
        }else
        {
            echo "Error!<br>Ingrese todos los datos (id,nombre,email,foto)";
        }
    }

    public static function idFoto($nombre)
    {
        $separacionBarra = explode('/',$nombreNuevo);
        
        $separacion = $separacionBarra[2];

        $array = explode('.',$separacion);

        return $array[0];
    }
    
    public static function QuitarEspacio($array)
    {
        for ($i=0; $i < count($array) ; $i++) { 

            $buffer = str_replace("\r\n","", $array[$i]->foto);
            $array[$i]->foto = $buffer;
        }

        return $array;
    }

    public static function SepararRuta($objeto,$caracter,$index)
    {
        $array = explode($caracter,$objeto->foto);
        return $array[$index];
    }

    public static function TrabajarConFoto($pathArchivo,$rutaBackUp,$ruta)
    {
        $nombreViejo = $_FILES['imagen']['tmp_name'];

        $nombreNuevo = proveedor::changeImgName($_FILES['imagen']['name'],$ruta);

        $objeto = validaciones::ConsultarPorID($_POST['id'],$pathArchivo);

        if(is_a($objeto,'proveedor')){
            
            $arrayNombre = proveedor::SepararRuta($objeto,'/',2); 

            if (file_exists($objeto->foto))  {

                rename($objeto->foto,$rutaBackUp.$arrayNombre);
                move_uploaded_file($nombreViejo, $nombreNuevo);
            }
        }
        else{
            move_uploaded_file($nombreViejo, $nombreNuevo);
        }
        
        return $nombreNuevo;

    }
     
    public static function changeImgName($nameImg,$path)
    {
        $arrayNameImg=explode('.',$nameImg);
        $date = new \DateTime('America/Argentina/Buenos_Aires');
        //$date = new \DateTime('+5 day');
        $fecha= $date->format('d-m-Y');
        $arrayNameImg[0]=$path.$_POST['id'].".".$fecha;
        $nameImg=$arrayNameImg[0].".".$arrayNameImg[1];
        return $nameImg;
    }

    public static function MostrarProveedor($proveedor)
    {
        echo    "ID: ".$proveedor->id."<br>
                Nombre : ".$proveedor->nombre."<br>
                email : ".$proveedor->email."<br><br>";
    }

    public static function Proveedores($path)
    {
        $arrayProveedores = proveedor::ArrayObjetosProveedor($path);

        foreach ($arrayProveedores as $variable) {
            proveedor::MostrarProveedor($variable);
        }
    }

    public static function ArrayObjetosProveedor($path)
    {
        $arrayProveedores = array();

        if(file_exists($path))
        {
            $file = fopen($path, "r");

            while(!feof($file))
            {
                $array = explode(",",fgets($file)); 

                if($array[0]!=null){
                    $prov = new proveedor($array[0],$array[1],$array[2],$array[3]);
                    array_push($arrayProveedores,$prov);
                }
            }

            fclose($file);

        }

        return $arrayProveedores;
    }

    public static function GuardarUno($proveedor,$path)
    {
        if(file_exists($path))
        {
            $file = fopen($path, "a");    
            fwrite($file, "$proveedor->id,$proveedor->nombre,$proveedor->email,$proveedor->foto");

            fclose($file);
        }
    }

    public static function GuardarArrayProveedores($array,$path)
    {       
        $file = fopen($path, "w");

        fclose($file);
        foreach ($array as $proveedor) {
            proveedor::GuardarUno($proveedor,$path);
        }
    }
    
    public static function Modificar()
    {

        if(validaciones::ingresoDatos()){
            
            $id = $_POST['id'];
            $path = "./archivos/proveedores.txt";
            
            $proveedor = validaciones::ConsultarPorID($id,$path);
            
            if($proveedor != null)
            {
                if(is_a($proveedor,'proveedor')){
                    $arrayProveedores = Proveedor::ArrayObjetosProveedor($path);
                    for ($i=0; $i <count($arrayProveedores) ; $i++) { 
                        
                        if($arrayProveedores[$i]->id == $proveedor->id){
                            
                            $nombreFoto = proveedor::TrabajarConFoto($path,"./backUpFotos/","./fotos/");
                            $nuevoProveedor = new proveedor ($_POST['id'],$_POST['nombre'],$_POST['email'],$nombreFoto."\r\n");
                            $arrayProveedores[$i] = $nuevoProveedor;
                    
                            break;
                        }
                    }
                    
    
                    proveedor::GuardarArrayProveedores($arrayProveedores,$path);
                }
                else
                {
                    echo $proveedor;
                }
            }else
            {
                echo "El archivo no existe o la ruta esta mal especificada";
            }
        }else
        {
            echo "Error<br>Falta ingresas alguno de los siguientes datos (id,nombre,email,foto)";
        }
    }
    /*
    public static function CuerpoHTML($directory,$archivo)
    {
        $string = "<!DOCTYPE>
        <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>Imágenes dinámicas de una carpeta en php</title>
        </head>

        <body>
        <p>./".$directory."/".$archivo."</p>
        <img src= '".$directory."/".$archivo."' alt = 'Foto'>
        </body>
        </html>";

        return $string;
    }

    public static function ListarFotosBack()
    {
        $path = "./archivos/proveedores.txt";

        $arrayProveedores = proveedor::ArrayObjetosProveedor($path);

        $directory = "backUpFotos";

        $array = dir($directory);

        while (($archivo = $array->read()) !== false)
        {   
            echo Proveedor::CuerpoHTML($directory,$archivo);
        }

        $array->close();
    }

    */

    public static function ListarFotosBack()
    {
        $path = "./archivos/proveedores.txt";

        $arrayProveedores = proveedor::ArrayObjetosProveedor($path);
        $arrayFotos = array();

        $directory = "backUpFotos";

        $array = dir($directory);

        while (($archivo = $array->read()) !== false)
        {   
            array_push($arrayFotos,$archivo);
        }

        $array->close();

        foreach ($arrayProveedores as $prov) {
            echo "Nombre Poveedor : ".$prov->nombre."<br>";
            
            foreach ($arrayFotos as $nomFoto) {
                $array = explode('.',$nomFoto);

                if($prov->id == $array[0]){
                    echo $nomFoto."<br>";
                }
            }
        }

        
    }


}
?>