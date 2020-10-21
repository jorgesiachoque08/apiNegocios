<?php

$app->get(
  '/api/listarDataUser',
  function() use ($AuthController,$UsuariosController) {
    $user = $AuthController->verificarToken();
    if ($user) {
        return json_encode($UsuariosController->listarAction($user));
    }
    
    
  }
);

$app->put(
  '/api/afiliarseEmpresa/{codEmpresa:[0-9]+}',
  function($codEmpresa) use ($AuthController,$UsuariosController) {
    $user = $AuthController->verificarToken();
    if ($user) {
        return json_encode($UsuariosController->afiliarseEmpresaAction($user,$codEmpresa));
    }
    
    
  }
);