<?php
// Validador Params
$app->get(
  '/api/listarFunciones',
  function() use ($FuncionesController) {
    return json_encode($FuncionesController->listarAction());
  }
);

$app->post(
    '/api/agregarFuncion',
    function() use ($FuncionesController,$validador,$request) {
        if($request->getJsonRawBody()){
            $_POST = (array)$request->getJsonRawBody();
        }
        
        $validador->setRequeridos(["descripcion"]);
        $message = ["message" => [
            "descripcion" => "descripcion es requerida"
        ]];
        $validador->setMsjCamposRequerid($message);
        if($validador->Validando($_POST) === true){
            return  json_encode($FuncionesController->agregarAction($_POST));
        }
    }
);

$app->put(
    '/api/actualizarFuncion/{cod:[0-9]+}',
    function($cod) use ($FuncionesController,$validador,$request) {
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
            return  json_encode($FuncionesController->actualizarAction($cod,$_PUT));
        }
    }
);

$app->delete(
    '/api/eliminarFuncion/{cod:[0-9]+}',
    function($cod) use ($FuncionesController) {
        return  json_encode($FuncionesController->eliminarAction($cod));
    }
);