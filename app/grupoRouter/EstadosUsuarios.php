<?php
// Validador Params
$app->get(
  '/api/listarEstadosUsuarios',
  function() use ($EstadosUsuariosController) {
    return json_encode($EstadosUsuariosController->listarAction());
  }
);

$app->post(
    '/api/agregarEstadoUsuario',
    function() use ($EstadosUsuariosController,$validador,$request) {
        if($request->getJsonRawBody()){
          $_POST = (array)$request->getJsonRawBody();
        }
      
        $validador->setRequeridos(["descripcion"]);
        $message = ["message" => [
          "descripcion" => "descripcion es requerida"
        ]];
        $validador->setMsjCamposRequerid($message);
        if($validador->Validando($_POST) === true){
          return  json_encode($EstadosUsuariosController->agregarAction($_POST));
        }
    }
  );

  $app->put(
    '/api/actualizarEstadoUsuario/{cod:[0-9]+}',
    function($cod) use ($EstadosUsuariosController,$validador,$request) {
        if($request->getJsonRawBody()){
          $_PUT = (array)$request->getJsonRawBody();
        }else{
          $_PUT = $request->getPut();
        }
      
        $validador->setRequeridos(["descripcion"]);
        $message = ["message" => [
          "descripcion" => "descripcion es requerida"
        ]];

        $validador->setMsjCamposRequerid($message);
        if($validador->Validando($_PUT) === true){
          return  json_encode($EstadosUsuariosController->actualizarAction($cod,$_PUT));
        }
    }
  );

  $app->delete(
    '/api/eliminarEstadoUsuario/{cod:[0-9]+}',
    function($cod) use ($EstadosUsuariosController) {
        return  json_encode($EstadosUsuariosController->eliminarAction($cod));
    }
  );