<?php
// Validador Params
$app->get(
  '/api/listarEstadosTerceros',
  function() use ($EstadosTercerosController) {
    return json_encode($EstadosTercerosController->listarAction());
  }
);

$app->post(
    '/api/agregarEstadoTercero',
    function() use ($EstadosTercerosController,$validador,$request) {
        if($request->getJsonRawBody()){
            $_POST = (array)$request->getJsonRawBody();
        }
        
        $validador->setRequeridos(["descripcion"]);
        $message = ["message" => [
            "descripcion" => "descripcion es requerida"
        ]];
        $validador->setMsjCamposRequerid($message);
        if($validador->Validando($_POST) === true){
            return  json_encode($EstadosTercerosController->agregarAction($_POST));
        }
    }
);

$app->put(
    '/api/actualizarEstadoTercero/{cod:[0-9]+}',
    function($cod) use ($EstadosTercerosController,$validador,$request) {
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
            return  json_encode($EstadosTercerosController->actualizarAction($cod,$_PUT));
        }
    }
);

$app->delete(
    '/api/eliminarEstadoTercero/{cod:[0-9]+}',
    function($cod) use ($EstadosTercerosController) {
        return  json_encode($EstadosTercerosController->eliminarAction($cod));
    }
);