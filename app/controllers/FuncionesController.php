<?php

use Phalcon\Mvc\Controller;
use App\Models\Funciones;
class FuncionesController extends Controller {

    public function listarAction()
    {
        try{
            $FuncionesRetorno = [];
            $Funciones = Funciones::find();
            foreach ($Funciones as $value) {
                $Funcion = array(
                    "cod" => (int) $value->cod,
                    "descripcion" => $value->descripcion
                );
                $FuncionesRetorno[] = $Funcion;
            }
            $this->response->setJsonContent(array(
                "code"=>200,
                "status"  => "success",
                "message" => "success",
                "data" =>$FuncionesRetorno
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
        $Funciones = new Funciones;
        $Funciones->descripcion = $params["descripcion"];
        try {
            $result = $Funciones->save();
            if($result){
                $mensaje = 'Se guardo la Funcion';
            }else{
                $mensaje = 'no se guardo la Funcion';
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
        $Funciones = new Funciones;
        $Funciones->cod = $cod;
        $Funciones->descripcion = $params["descripcion"];
        try {
            $result = $Funciones->update();
            if($result){
                $mensaje = 'Se actualizo la Funcion';
            }else{
                $mensaje = 'no se actualizo la Funcion, porque no existe';
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

        $Funciones = Funciones::findFirst(
            [
                'conditions' => 'cod = :id:',
                'bind'       => [
                    'id' => $cod
                ]
            ]
        );
        if($Funciones){
            try {
                $result = $Funciones->delete();
                if($result){
                    $this->response->setJsonContent(array(
                        "code"=>200,
                            "status"  => "success",
                            "message" =>'Se elimino la Funcion',
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
                    "message" =>'no se elimino la Funcion, porque no existe',
                    "data"=>false
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();
        }
            
        
    }

}