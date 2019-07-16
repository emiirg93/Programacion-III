<?php

include_once "../src/AutentificadorJWT.php";

class MWGuardarInfoEnDB
{
    public function GuardarDatosEnDB($request, $response, $next)
    {
        $objRespuesta = new stdClass();
        $objRespuesta->respuesta = "";

        $ruta = $request->getRequestTarget();
        $body = $request->getParsedBody();
        $metodo = $request->getMethod();
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $hora = date('g:i a');
        $usuario = "";

        if (isset($_POST['token'])) {
            $token = $_POST['token'];
            $usuarioLogueado = AutentificadorJWT::ObtenerData($token);
            $usuario = $usuarioLogueado->usuario;
        } else {
            $usuario = $body['usuario'];
        }

        if ($this->InsertarBD($usuario, $metodo, $ruta, $hora)) {
            $response = $next($request, $response);
        } else {
            $objRespuesta->respuesta = "Error En La Base De Datos";
            return $response->withJson($objRespuesta, 401);
        }

        return $response;
    }

    public function InsertarBD($user, $method, $path, $hour)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into datos (usuario,metodo,ruta,hora)values(:usuario,:metodo,:ruta,:hora)");
        $consulta->bindValue(':usuario', $user, PDO::PARAM_STR);
        $consulta->bindValue(':metodo', $method, PDO::PARAM_STR);
        $consulta->bindValue(':ruta', $path, PDO::PARAM_STR);
        $consulta->bindValue(':hora', $hour, PDO::PARAM_STR);

        return $consulta->execute();
    }
}
