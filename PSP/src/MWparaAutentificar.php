<?php

include_once "../src/AutentificadorJWT.php";

class MWparaAutentificar
{
    /**
     * @api {any} /MWparaAutenticar/  Verificar Usuario
     * @apiVersion 0.1.0
     * @apiName VerificarUsuario
     * @apiGroup MIDDLEWARE
     * @apiDescription  Por medio de este MiddleWare verifico las credeciales antes de ingresar al correspondiente metodo
     *
     * @apiParam {ServerRequestInterface} request  El objeto REQUEST.
     * @apiParam {ResponseInterface} response El objeto RESPONSE.
     * @apiParam {Callable} next  The next middleware callable.
     *
     * @apiExample Como usarlo:
     *    ->add(\MWparaAutenticar::class . ':VerificarUsuario')
     */
    public function VerificarUsuario($request, $response, $next)
    {

        $objetoRespuesta = new stdClass();
        $objetoRespuesta->respuesta = "";

        $ArrayDeParametros = $request->getParsedBody();
        $token = $ArrayDeParametros['token'];

        try {
            AutentificadorJWT::VerificarToken($token);
            $objetoRespuesta->esValido = true;
        } catch (Exception $e) {
            $objetoRespuesta->exception = $e->getMessage();
            $objetoRespuesta->esValido = false;
        }

        if ($objetoRespuesta->esValido) {
            $datos = AutentificadorJWT::ObtenerData($token);

            if ($datos->perfil == "admin") {
                $response = $next($request, $response);
            } else {
                $objetoRespuesta->respuesta = "Hola.";
            }
        } else {
            $objetoRespuesta->respuesta = "Solo Usuarios Registrados";
            $objetoRespuesta->token = $token;
        }

        if ($objetoRespuesta->respuesta != "") {
            $nueva = $response->withJson($objetoRespuesta, 401);
            return $nueva;
        }

        return $response;

    }
}
