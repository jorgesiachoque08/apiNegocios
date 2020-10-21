<?php

use Phalcon\Http\Request;

$request = new Request();

//Controladores
$AuthController = new AuthController();
$PaisesController = new PaisesController();
$EstadosUsuariosController = new EstadosUsuariosController();
$EstadosTercerosController = new EstadosTercerosController();
$EstadosEmpresasController = new EstadosEmpresasController();
$FuncionesController = new FuncionesController();
$TiposIdentificacionController = new TiposIdentificacionController();
$TercerosController = new TercerosController();
$UsuariosController = new UsuariosController();
$EmpresasController = new EmpresasController();
$EstadosEuController = new EstadosEuController();

//Componentes
$validador = new Validador();


//Grupo de rutas
include APP_PATH.'/grupoRouter/Auth.php';
include APP_PATH.'/grupoRouter/Paises.php';
include APP_PATH.'/grupoRouter/EstadosUsuarios.php';
include APP_PATH.'/grupoRouter/EstadosTerceros.php';
include APP_PATH.'/grupoRouter/EstadosEmpresas.php';
include APP_PATH.'/grupoRouter/Funciones.php';
include APP_PATH.'/grupoRouter/TipoIdentificacion.php';
include APP_PATH.'/grupoRouter/Terceros.php';
include APP_PATH.'/grupoRouter/Usuarios.php';
include APP_PATH.'/grupoRouter/Empresas.php';
include APP_PATH.'/grupoRouter/EstadoEu.php';

/* $app->get(
  '/api/listarUsuarios',
  function() use ($AuthController) {
    return json_encode($AuthController->verificarToken());
  }
); */

$app->notFound(function () use ($app) {
    return json_encode(["status"=>404,"mensaje"=>"Ruta no existe","data"=>false]);
});

$app->handle($_SERVER["REQUEST_URI"]);