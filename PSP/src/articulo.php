<?php

include_once "../src/AccesoDatos.php";

class articulo
{
    public $idCompra;
    public $idComprador;
    public $nombre;
    public $fecha;
    public $precio;

    public static function constructorFalso($compradorID, $compraID, $name, $date, $pre)
    {
        $articulo = new articulo();

        $articulo->idComprador = $compradorID;
        $articulo->nombre = $name;
        $articulo->fecha = $date;
        $articulo->precio = $pre;
        $articulo->idCompra = $compraID;

        return $articulo;
    }

    public function InsertarBD()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into articulos (nombre,fecha,precio,idComprador,idCompra)values(:nombre,:fecha,:precio,:idComprador,:idCompra)");

        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':idComprador', $this->idComprador, PDO::PARAM_INT);
        $consulta->bindValue(':idCompra', $this->idCompra, PDO::PARAM_INT);

        return $consulta->execute();
    }

    public static function ComprasUsuario($idUsuario)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM articulos WHERE idCOmprador = :idUsuario ");
        $consulta->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $consulta->execute();

        $compras = $consulta->fetchAll(PDO::FETCH_CLASS, "articulo");

        return $compras;
    }

    public static function TodasLasCompras()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM articulos WHERE 1 = 1 ");
        $consulta->execute();

        $compras = $consulta->fetchAll(PDO::FETCH_CLASS, "articulo");

        return $compras;
    }

    public function MostrarUno()
    {
        return $respuesta = "ID de Compra: " . $this->idCompra . "<br>
                      ID de Comprador: " . $this->idComprador . "<br>
                      -------------------------------------- <br>
                      Producto : " . $this->nombre . "<br>
                      Fecha De Compra : " . $this->fecha . "<br>
                      Precio : " . $this->precio;
    }

    public static function MostrarTodos($arrayCompras)
    {
        $objRespuesta = new stdClass();

        $objRespuesta->respuesta = "";

        $flag = 0;
        foreach ($arrayCompras as $compra) {
            if ($flag == 0) {
                $objRespuesta->respuesta .= "Listado De Compras
                <br>--------------------------------------<br><br>";
                $objRespuesta->respuesta .= $compra->MostrarUno();
                $flag = 1;
                continue;
            }

            $objRespuesta->respuesta .= "<br><br>";
            $objRespuesta->respuesta .= $compra->MostrarUno();
        }

        return $objRespuesta->respuesta;
    }
}
