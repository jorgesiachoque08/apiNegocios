<?php
// Validador Params
$app->get(
  '/api/listarPaises',
  function() use ($PaisesController) {
    return json_encode($PaisesController->listarAction());
  }
);

$app->post(
  '/api/agregarPais',
  function() use ($PaisesController,$validador,$request) {
      if($request->getJsonRawBody()){
        $_POST = (array)$request->getJsonRawBody();
      }
    
      $validador->setRequeridos(["pais"]);
      $message = ["message" => [
        "pais" => "pais es requerido"
      ]];
      $validador->setMsjCamposRequerid($message);
      if($validador->Validando($_POST) === true){
        return  json_encode($PaisesController->agregarAction($_POST));
      }
  }
);

$app->put(
  '/api/actualizarPais/{cod:[0-9]+}',
  function($cod) use ($PaisesController,$validador,$request) {
      if($request->getJsonRawBody()){
        $_PUT = (array)$request->getJsonRawBody();
      }else{
        $_PUT = $request->getPut();
      }
    
      $validador->setRequeridos(["pais"]);
      $message = ["message" => [
        "pais" => "pais es requerido"
      ]];
      $validador->setMsjCamposRequerid($message);
      if($validador->Validando($_PUT) === true){
        return  json_encode($PaisesController->actualizarAction($cod,$_PUT));
      }
  }
);

$app->delete(
  '/api/eliminarPais/{cod:[0-9]+}',
  function($cod) use ($PaisesController) {
      return  json_encode($PaisesController->eliminarAction($cod));
  }
);