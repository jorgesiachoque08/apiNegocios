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
        "email" => "email es requerido"
    ]];
    $validador->setMsjCamposRequerid($message);
    if(isset($_POST["telefono"]) && isset($_POST["celular"])){
      $campos = ["cod_tipo_id","identificacion","telefono","celular"];
      $messageEnteros = ["message" => [
        "cod_tipo_id" => "cod_tipo_id tiene que ser de tipo entero",
        "identificacion" => "identificacion tiene que ser de tipo entero",
        "telefono" => "cod_pais tiene que ser de tipo entero",
        "celular" => "cod_pais tiene que ser de tipo entero",
    ]];
    }else if(isset($_POST["telefono"])){
      $campos = ["cod_tipo_id","identificacion","telefono"];
      $messageEnteros = ["message" => [
        "cod_tipo_id" => "cod_tipo_id tiene que ser de tipo entero",
        "identificacion" => "identificacion tiene que ser de tipo entero",
        "telefono" => "cod_pais tiene que ser de tipo entero"
    ]];
    }else if(isset($_POST["celular"])){
      $campos = ["cod_tipo_id","identificacion","celular"];
      $messageEnteros = ["message" => [
        "cod_tipo_id" => "cod_tipo_id tiene que ser de tipo entero",
        "identificacion" => "identificacion tiene que ser de tipo entero",
        "celular" => "cod_pais tiene que ser de tipo entero",
    ]];
    }else{
      $campos = ["cod_tipo_id","identificacion"];
      $messageEnteros = ["message" => [
        "cod_tipo_id" => "cod_tipo_id tiene que ser de tipo entero",
        "identificacion" => "identificacion tiene que ser de tipo entero"
    ]];
    }
  
    $validador->setEnteros($campos);
    $validador->setMsjCamposEnteros($messageEnteros);
    $validador->setEmail(["email"]);
    $messageEmails = ["message" => [
      "email" => "email no es valido"
  ]];
    $validador->setMsjCamposEmail($messageEmails);
    if ($validador->Validando($_POST) === true) {
      return json_encode($AuthController->registrarAction($_POST));
    }
    
  }
);

$app->post(
    '/api/login',
    function() use ($AuthController) {
      return json_encode($AuthController->loginAction());
    }
);

$app->get(
  '/api/login',
  function() use ($AuthController) {
    return json_encode($AuthController->loginAction());
  }
);