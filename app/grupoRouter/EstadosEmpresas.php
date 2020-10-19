<?php
// Validador Params
$app->get(
  '/api/listarEstadosEmpresas',
  function() use ($EstadosEmpresasController) {
    return json_encode($EstadosEmpresasController->listarAction());
  }
);

$app->post(
    '/api/agregarEstadoEmpresa',
    function() use ($EstadosEmpresasController,$validador,$request) {
        if($request->getJsonRawBody()){
            $_POST = (array)$request->getJsonRawBody();
        }
        
        $validador->setRequeridos(["descripcion"]);
        $message = ["message" => [
            "descripcion" => "descripcion es requerida"
        ]];
        $validador->setMsjCamposRequerid($message);
        if($validador->Validando($_POST) === true){
            return  json_encode($EstadosEmpresasController->agregarAction($_POST));
        }
    }
);

$app->put(
    '/api/actualizarEstadoEmpresa/{cod:[0-9]+}',
    function($cod) use ($EstadosEmpresasController,$validador,$request) {
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
            return  json_encode($EstadosEmpresasController->actualizarAction($cod,$_PUT));
        }
    }
);

$app->delete(
    '/api/eliminarEstadoEmpresa/{cod:[0-9]+}',
    function($cod) use ($EstadosEmpresasController) {
        return  json_encode($EstadosEmpresasController->eliminarAction($cod));
    }
);