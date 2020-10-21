<?php
// Validador Params
$app->get(
  '/api/listarEstadosAfiliacion',
  function() use ($EstadosEuController) {
    return json_encode($EstadosEuController->listarAction());
  }
);

$app->post(
    '/api/agregarEstadosAfiliacion',
    function() use ($EstadosEuController,$validador,$request) {
        if($request->getJsonRawBody()){
            $_POST = (array)$request->getJsonRawBody();
        }
        
        $validador->setRequeridos(["descripcion"]);
        $message = ["message" => [
            "descripcion" => "descripcion es requerida"
        ]];
        $validador->setMsjCamposRequerid($message);
        if($validador->Validando($_POST) === true){
            return  json_encode($EstadosEuController->agregarAction($_POST));
        }
    }
);

$app->put(
    '/api/actualizarEstadosAfiliacion/{cod:[0-9]+}',
    function($cod) use ($EstadosEuController,$validador,$request) {
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
            return  json_encode($EstadosEuController->actualizarAction($cod,$_PUT));
        }
    }
);

$app->delete(
    '/api/eliminarEstadosAfiliacion/{cod:[0-9]+}',
    function($cod) use ($EstadosEuController) {
        return  json_encode($EstadosEuController->eliminarAction($cod));
    }
);