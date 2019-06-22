<?php

include_once "AccesoDatos.php";

class usuario
{
    public $id;
    public $userName;
    public $password;

    public function Insertar()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into usuario (userName,password)values(:userName,:password)");
        $consulta->bindValue(':userName', $this->userName, PDO::PARAM_STR);
        $consulta->bindValue(':password', $this->password, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();

    }
}
