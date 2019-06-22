<?php
include_once "usuario.php";
include_once "IApiUsable.php";

class usuarioApi extends usuario implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $userNAme = $ArrayDeParametros['userName'];
        $password = $ArrayDeParametros['password'];

        $myUser = new usuario();
        $myUser->userName = $userNAme;
        $myUser->password = $password;
        $myUser->Insertar();
        $response->getBody()->write("usuario ingresado al sistema.");

        return $response;
    }
}
