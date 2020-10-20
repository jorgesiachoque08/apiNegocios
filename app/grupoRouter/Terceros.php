<?php

$app->put(
  '/api/actualizarTercero',
  function() use ($AuthController,$TercerosController,$validador,$request) {
    $user = $AuthController->verificarToken();
    if ($user) {
        if($request->getJsonRawBody()){
            $_PUT = (array)$request->getJsonRawBody();
        }else{
            $_PUT = $request->getPut();
        }
        
        $validador->setRequeridos(["nombres","apellidos","fecha_nac","cod_tipo_id","identificacion","email"]);
        $message = ["message" => [
            "nombres" => "nombres es requerido",
            "apellidos" => "apellidos es requerido",
            "fecha_nac" => "fecha_nac es requerida",
            "cod_tipo_id" => "cod_tipo_id es requerido",
            "identificacion" => "identificacion es requerida",
            "email" => "email es requerido"
        ]];
        $validador->setMsjCamposRequerid($message);
        $campos = ["cod_tipo_id"];
        $messageEnteros = ["message" => [
            "cod_tipo_id" => "cod_tipo_id tiene que ser de tipo entero",
        ]];
        $validador->setEnteros($campos);
        $validador->setMsjCamposEnteros($messageEnteros);
        $validador->setEmail(["email"]);
        $messageEmails = ["message" => [
          "email" => "email no es valido"
        ]];
        $validador->setMsjCamposEmail($messageEmails);
        $validador->setFechas(["fecha_nac"]);
        $messageFechas = [
          "format" => [
            "fecha_nac" => "Y-m-d",
          ],
          "message" => [
          "fecha_nac" => "fecha_nac no es valida formt(Y-m-d)"
        ]];
        $validador->setMsjCamposFechas($messageFechas);
    
        if ($validador->Validando($_PUT) === true) {
          return json_encode($TercerosController->actualizarAction($user,$_PUT));
        }
    }
    
    
  }
);