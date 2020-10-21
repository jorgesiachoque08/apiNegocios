<?php

$app->get(
  '/api/listarEmpresas',
  function() use ($AuthController,$EmpresasController) {
    $user = $AuthController->verificarToken();
    if ($user) {
        return json_encode($EmpresasController->listarAction($user));
    }
  }
);

$app->get(
    '/api/listarTodasEmpresas',
    function() use ($AuthController,$EmpresasController) {
      $user = $AuthController->verificarToken();
      if ($user) {
          return json_encode($EmpresasController->listarTodasAction());
      }
    }
  );

  $app->get(
    '/api/listarEmpresa/{tipoIdent:[0-9]+}/{identificacion:[a-zA-Z\0-9]+}',
    function($tipoIdent,$identificacion) use ($AuthController,$EmpresasController) {
      $user = $AuthController->verificarToken();
      if ($user) {
          return json_encode($EmpresasController->listarEmpresaAction($tipoIdent,$identificacion));
      }
    }
  );

$app->post(
    '/api/agregarEmpresa',
    function() use ($AuthController,$EmpresasController,$validador,$request) {
        $user = $AuthController->verificarToken();
        if ($user) {
            if($request->getJsonRawBody()){
                $_POST = (array)$request->getJsonRawBody();
            }
            
            $validador->setRequeridos(["razon_social","cod_tipo_id","identificacion"]);
            $validador->setEnteros(["cod_tipo_id"]);
            $message = ["message" => [
                "razon_social" => "razon_social es requerida",
                "cod_tipo_id" => "cod_tipo_id es requerido",
                "identificacion" => "identificacion es requerida"
            ]];
            $validador->setMsjCamposRequerid($message);
            $messageEnteros = ["message" => [
                "cod_tipo_id" => "cod_tipo_id tiene que ser de tipo entero"
            ]];
            $validador->setMsjCamposEnteros($messageEnteros);
            
            if($validador->Validando($_POST) === true){
                return  json_encode($EmpresasController->agregarAction($user,$_POST));
            }
        }
    }
);

$app->put(
    '/api/actualizarEmpresa/{cod:[0-9]+}',
    function($cod) use ($AuthController,$EmpresasController,$validador,$request) {
        $user = $AuthController->verificarToken();
        if ($user) {
            if($request->getJsonRawBody()){
                $_PUT = (array)$request->getJsonRawBody();
            }else{
                $_PUT = $request->getPut();
            }

            $validador->setRequeridos(["razon_social","identificacion","cod_tipo_id"]);
            $message = ["message" => [
                "razon_social" => "razon_social es requerida",
                "identificacion" => "identificacion es requerida",
                "cod_tipo_id" => "cod_tipo_id es requerida"
            ]];
            $validador->setMsjCamposRequerid($message);
            $validador->setEnteros(["cod_tipo_id"]);
            $messageEnteros = ["message" => [
                "cod_tipo_id" => "cod_tipo_id tiene que ser de tipo entero"
            ]];
            $validador->setMsjCamposEnteros($messageEnteros);
            if($validador->Validando($_PUT) === true){
                return  json_encode($EmpresasController->actualizarAction($user,$cod,$_PUT));
            }
        }
    }
);

$app->put(
    '/api/cambiarEstadoEmpresa/{cod:[0-9]+}',
    function($cod) use ($AuthController,$EmpresasController,$validador,$request) {
        $user = $AuthController->verificarToken();
        if ($user) {
            if($request->getJsonRawBody()){
                $_PUT = (array)$request->getJsonRawBody();
            }else{
                $_PUT = $request->getPut();
            }
            $validador->setRequeridos(["estado"]);
            $message = ["message" => [
                "estado" => "estado es requerido"
            ]];
            $validador->setMsjCamposRequerid($message);
            $validador->setEnteros(["estado"]);
            $messageEnteros = ["message" => [
                "estado" => "estado tiene que ser de tipo entero"
            ]];
            $validador->setMsjCamposEnteros($messageEnteros);
            if($validador->Validando($_PUT) === true){
                return  json_encode($EmpresasController->cambiarEstadoAction($user,$cod,$_PUT));
            }
        }
    }
);