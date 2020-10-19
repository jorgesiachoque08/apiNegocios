<?php
$app->post(
    '/api/login',
    function() use ($AuthController) {
      return json_encode($AuthController->loginAction());
    }
);

$app->get(
  '/api/login',
  function() use ($AuthController) {
    return json_encode($AuthController->loginAction());
  }
);