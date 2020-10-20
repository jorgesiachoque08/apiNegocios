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