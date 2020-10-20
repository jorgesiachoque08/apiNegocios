<?php

$app->post(
  '/api/RegistrarUsuario',
  function() use ($AuthController,$validador,$request) {
    if($request->getJsonRawBody()){
        $_POST = (array)$request->getJsonRawBody();
    }
    
    $validador->setRequeridos(["nombres","apellidos","fecha_nac","cod_tipo_id","identificacion","email","usuario","clave"]);
    $message = ["message" => [
        "nombres" => "nombres es requerido",
        "apellidos" => "apellidos es requerido",
        "fecha_nac" => "fecha_nac es requerida",
        "cod_tipo_id" => "cod_tipo_id es requerido",
        "identificacion" => "identificacion es requerida",
        "email" => "email es requerido",
        "usuario" => "usuario es requerido",
        "clave" => "clave es requerido"
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

    if ($validador->Validando($_POST) === true) {
      return json_encode($AuthController->registrarAction($_POST));
    }
    
  }
);

$app->post(
    '/api/login',
    function() use ($AuthController,$validador,$request) {
      if($request->getJsonRawBody()){
        $_POST = (array)$request->getJsonRawBody();
      }
      
      $validador->setRequeridos(["usuario","clave"]);
      $message = ["message" => [
        "usuario" => "usuario es requerido",
        "clave" => "clave es requerido"
      ]];
      $validador->setMsjCamposRequerid($message);
      if ($validador->Validando($_POST) === true) {
        return json_encode($AuthController->loginAction($_POST));
      }
    }
);
