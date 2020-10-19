<?php

use Phalcon\Mvc\Controller;
use App\Models\EstadosUsuarios;
class EstadosUsuariosController extends Controller {

    public function listarAction()
    {
        try{
            $EstadosUsuariosRetorno = [];
            $EstadosUsuarios = EstadosUsuarios::find();
            foreach ($EstadosUsuarios as $value) {
                $EstadoUsuario = array(
                    "cod" => (int) $value->cod,
                    "descripcion" => $value->descripcion
                );
                $EstadosUsuariosRetorno[] = $EstadoUsuario;
            }
            $this->response->setJsonContent(array(
                "code"=>200,
                "status"  => "success",
                "message" => "success",
                "data" =>$EstadosUsuariosRetorno
            ));
            $this->response->setStatusCode(200);
            $this->response->send();
        } catch (Exception $ex) {
            $this->response->setJsonContent(array(
                "code" => 500,
                "status" => "error",
                "message" => 'Excepción capturada (listarAction): ' . $ex->getMessage() . "\n"
            ));
            $this->response->setStatusCode(500);
            $this->response->send();
        }
    }

    public function agregarAction($params)
    {
        $EstadosUsuarios = new EstadosUsuarios;
        $EstadosUsuarios->descripcion = $params["descripcion"];
        try {
            $result = $EstadosUsuarios->save();
            if($result){
                $mensaje = 'Se guardo el EstadoUsuario';
            }else{
                $mensaje = 'no se guardo el EstadoUsuario';
            }
            $this->response->setJsonContent(array(
                "code"=>200,
                    "status"  => "success",
                    "message" => $mensaje,
                    "data"=>$result
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();
        } catch (Exception $ex) {
            $this->response->setJsonContent(array(
                "code"=>500,
                    "status"  => "error",
                    "message" => 'Excepción capturada (agregarAction): ' . $ex->getMessage() . "\n",
            ));
            $this->response->setStatusCode(500, $ex->getMessage());
            $this->response->send();
        }


    }

    public function actualizarAction($cod,$params)
    {
        $EstadosUsuarios = new EstadosUsuarios;
        $EstadosUsuarios->cod = $cod;
        $EstadosUsuarios->descripcion = $params["descripcion"];
        try {
            $result = $EstadosUsuarios->update();
            if($result){
                $mensaje = 'Se actualizo el EstadoUsuario';
            }else{
                $mensaje = 'no se actualizo el EstadoUsuario, porque no existe';
            }
            $this->response->setJsonContent(array(
                "code"=>200,
                    "status"  => "success",
                    "message" => $mensaje,
                    "data"=>$result
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();
        } catch (Exception $ex) {
            $this->response->setJsonContent(array(
                "code"=>500,
                    "status"  => "error",
                    "message" => 'Excepción capturada (actualizarAction): ' . $ex->getMessage() . "\n",
            ));
            $this->response->setStatusCode(500, $ex->getMessage());
            $this->response->send();
        }
    }

    public function eliminarAction($cod)
    {

        $EstadosUsuarios = EstadosUsuarios::findFirst(
            [
                'conditions' => 'cod = :id:',
                'bind'       => [
                    'id' => $cod
                ]
            ]
        );
        if($EstadosUsuarios){
            try {
                $result = $EstadosUsuarios->delete();
                if($result){
                    $this->response->setJsonContent(array(
                        "code"=>200,
                            "status"  => "success",
                            "message" =>'Se elimino el EstadoUsuario',
                            "data"=>$result
                    ));
                }
                $this->response->setStatusCode(200, "success");
                $this->response->send();
            } catch (Exception $ex) {
                $this->response->setJsonContent(array(
                    "code"=>500,
                        "status"  => "error",
                        "message" => 'Excepción capturada (actualizarAction): ' . $ex->getMessage() . "\n",
                ));
                $this->response->setStatusCode(500, $ex->getMessage());
                $this->response->send();
            }

        }else{
            $this->response->setJsonContent(array(
                "code"=>200,
                    "status"  => "success",
                    "message" =>'no se elimino el EstadoUsuario, porque no existe',
                    "data"=>false
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();
        }
            
        
    }

}