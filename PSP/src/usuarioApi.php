<?php

include_once "../src/usuario.php";
include_once "../src/AutentificadorJWT.php";

class usuarioApi extends usuario
{
    public function Alta($request, $response, $args)
    {
        $objRespuesta = new stdClass();

        $arrayDatos = $request->getParsedBody();

        $nombre = $arrayDatos['usuario'];
        $clave = $arrayDatos['clave'];
        $sexo = $arrayDatos['sexo'];
        $perfil = $arrayDatos['perfil'];
        $id = $arrayDatos['id'];

        $newUser = usuario::constructorParam($nombre, $clave, $sexo, $perfil, $id);

        if ($newUser->InsertarBD()) {
            $objRespuesta->respuesta = "Usuario Ingresado Con Exito.";
        } else {
            $objRespuesta->respuesta = "Error Al Ingresar Usuario";
        }

        return $objRespuesta->respuesta;

    }

    public function _login($request, $response, $args)
    {
        $objRespuesta = new stdClass();
        $newUser = new stdClass();

        $arrayDatos = $request->getParsedBody();

        $usuario = $arrayDatos['usuario'];
        $clave = $arrayDatos['clave'];

        $newUser = usuario::TraerUsuario($usuario, $clave);

        if ($newUser != false) {
            $token = AutentificadorJWT::CrearToken($newUser);
            $objRespuesta->respuesta = "Bienvenido " . $usuario . "<br>Su Token Es : " . $token;
        } else {
            $objRespuesta->respuesta = "El usuario no existe o la contraseña es invalida.";
        }

        return $objRespuesta->respuesta;
    }

    public function ListaUsuarios($request, $response, $args)
    {
        $objRespuesta = new stdClass();

        $objRespuesta->respuesta = "";

        $flag = 0;

        $usuarios = usuario::TraerTodos();

        foreach ($usuarios as $user) {
            if ($flag == 0) {
                $objRespuesta->respuesta .= $user->MostrarUsuario();
                $flag = 1;
                continue;
            }
            $objRespuesta->respuesta .= "<br><br>";
            $objRespuesta->respuesta .= $user->MostrarUsuario();
        }

        return $objRespuesta->respuesta;
    }
}
