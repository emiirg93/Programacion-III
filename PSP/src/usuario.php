<?php

include_once "../src/AccesoDatos.php";

class usuario
{
    public $usuario;
    public $clave;
    public $sexo;
    public $perfil;
    public $id;

    public static function constructorParam($name, $key, $sex, $profile, $ID)
    {
        $user = new usuario();

        $user->usuario = $name;
        $user->clave = $key;
        $user->sexo = $sex;
        $user->perfil = $profile;
        $user->id = $ID;

        return $user;
    }

    public function InsertarBD()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into usuarios (usuario,clave,sexo,perfil,id)values(:usuario,:clave,:sexo,:perfil,:id)");
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':sexo', $this->sexo, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $consulta->execute();
    }

    public static function TraerUsuario($usuario, $clave)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select * from usuarios WHERE usuario=:user and clave=:key");
        $consulta->bindValue(':user', $usuario, PDO::PARAM_STR);
        $consulta->bindValue(':key', $clave, PDO::PARAM_STR);
        $consulta->execute();
        $userBuscado = $consulta->fetchObject('usuario');
        return $userBuscado;
    }

    public static function TraerTodos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select * from usuarios");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");
    }

    public function MostrarUsuario()
    {
        return "ID : " . $this->id . "<br>
                ----------------------------------------<br>
                Nombre Usuario : " . $this->usuario . "<br>
                Sexo : " . $this->sexo . "<br>
                Perfil : " . $this->perfil;
    }
}
