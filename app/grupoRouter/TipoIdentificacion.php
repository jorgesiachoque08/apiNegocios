<?php

$app->get(
  '/api/listarTiposIdentificacion',
  function() use ($TiposIdentificacionController) {
    return json_encode($TiposIdentificacionController->listarAction());
  }
);

$app->post(
    '/api/agregarTipoIdentificacion',
    function() use ($TiposIdentificacionController,$validador,$request) {
        if($request->getJsonRawBody()){
            $_POST = (array)$request->getJsonRawBody();
        }
        
        $validador->setRequeridos(["descripcion","cod_pais","abreviatura"]);
        $validador->setEnteros(["cod_pais"]);
        $message = ["message" => [
            "descripcion" => "descripcion es requerida",
            "cod_pais" => "cod_pais es requerida",
            "abreviatura" => "abreviatura es requerida"
        ]];
        $validador->setMsjCamposRequerid($message);
        $messageEnteros = ["message" => [
            "cod_pais" => "cod_pais tiene que ser de tipo entero"
        ]];
        $validador->setMsjCamposEnteros($messageEnteros);
        
        if($validador->Validando($_POST) === true){
            return  json_encode($TiposIdentificacionController->agregarAction($_POST));
        }
    }
);

$app->put(
    '/api/actualizarTipoIdentificacion/{cod:[0-9]+}',
    function($cod) use ($TiposIdentificacionController,$validador,$request) {
        if($request->getJsonRawBody()){
            $_PUT = (array)$request->getJsonRawBody();
        }else{
            $_PUT = $request->getPut();
        }

        $validador->setRequeridos(["descripcion","cod_pais","abreviatura"]);
        $message = ["message" => [
            "descripcion" => "descripcion es requerida",
            "cod_pais" => "cod_pais es requerida",
            "abreviatura" => "abreviatura es requerida"
        ]];
        $validador->setMsjCamposRequerid($message);
        $validador->setEnteros(["cod_pais"]);
        $messageEnteros = ["message" => [
            "cod_pais" => "cod_pais tiene que ser de tipo entero"
        ]];
        $validador->setMsjCamposEnteros($messageEnteros);
        if($validador->Validando($_PUT) === true){
            return  json_encode($TiposIdentificacionController->actualizarAction($cod,$_PUT));
        }
    }
);

$app->delete(
    '/api/eliminarTipoIdentificacion/{cod:[0-9]+}',
    function($cod) use ($TiposIdentificacionController) {
        return  json_encode($TiposIdentificacionController->eliminarAction($cod));
    }
);