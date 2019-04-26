<?php

include_once "proveedor.php";

class pedidos{

    public $idProveedor;
    public $producto;
    public $cantidad;
    
    public function __construct($id,$prod,$can) {
        $this->idProveedor = $id;
        $this->producto = $prod;
        $this->cantidad =$can;
    }

    public static function HacerPedido()
    {
        $idProveedor = $_POST['id'];

        $varible = proveedor::ConsultarProveedorID($idProveedor);

        if(!is_numeric($varible)){
            $producto = $_POST['producto'];
            $cantidad = $_POST['cantidad'];

            $pedido = new pedidos($idProveedor,$producto,$cantidad);

            pedidos::GuardarPedido($pedido);
        }
        else{
            echo $varible;
        }

    }

    public static function GuardarPedido($producto)
    {       
        if(file_exists("./archivos/pedidos.txt"))
        {
            $file = fopen("./archivos/pedidos.txt", "a");

            fwrite($file, "$producto->idProveedor,$producto->producto,$producto->cantidad\r\n");

            fclose($file);
        }
        else
        {
            $file = fopen("./archivos/pedidos.txt", "w");

            fwrite($file, "$producto->idProveedor,$producto->producto,$producto->cantidad\r\n");

            fclose($file);
        }
        
    }

    public static function ArrayObjetosPedidos()
    {
        $arrayPedidos = array();

        if(file_exists("./archivos/pedidos.txt"))
        {
            $file = fopen("./archivos/pedidos.txt", "r");

            while(!feof($file))
            {
                $array = explode(",",fgets($file)); 

                if($array[0]!=null){
                    $ped = new pedidos($array[0],$array[1],$array[2]);
                    array_push($arrayPedidos,$ped);
                }
            }

            fclose($file);

        }

        return $arrayPedidos;
    }

    public static function ListarPedidos(){

        $arrayProveedores = proveedor::ArrayObjetosProveedor();
        $arrayPedidos = pedidos::ArrayObjetosPedidos();

        foreach ($arrayProveedores as $proveedor) {
            
            foreach ($arrayPedidos as $pedido) {
                
                if($proveedor->id == $pedido->idProveedor){
                
                    echo "ID proveedor : ".$proveedor->id."<br>
                          Nombre Proveedor : ".$proveedor->nombre."<br>
                          Producto : ".$pedido->producto."<br>
                          Cantidad : ".$pedido->cantidad."<br><br>";
                          
                }
            }
        }
    }

    public static function ListarPedidoProveedor(){
        $idProveedor = $_GET['id'];

        $arrayPedidos = pedidos::ArrayObjetosPedidos();

        echo "Pedidos realizados por el ID : ".$idProveedor."<br><br>";
        
        foreach ($arrayPedidos as $pedidos) {
            if($idProveedor == $pedidos->idProveedor){
                echo "Producto : ".$pedidos->producto."<br>
                      Cantidad : ".$pedidos->cantidad."<br><br>";
            }
        }
    }
}




?>