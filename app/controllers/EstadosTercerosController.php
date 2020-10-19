<?php

use Phalcon\Mvc\Controller;
use App\Models\EstadosTerceros;
class EstadosTercerosController extends Controller {

    public function listarAction()
    {
        try{
            $EstadosTercerosRetorno = [];
            $EstadosTerceros = EstadosTerceros::find();
            foreach ($EstadosTerceros as $value) {
                $EstadoTercero = array(
                    "cod" => (int) $value->cod,
                    "descripcion" => $value->descripcion
                );
                $EstadosTercerosRetorno[] = $EstadoTercero;
            }
            $this->response->setJsonContent(array(
                "code"=>200,
                "status"  => "success",
                "message" => "success",
                "data" =>$EstadosTercerosRetorno
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
        $EstadosTerceros = new EstadosTerceros;
        $EstadosTerceros->descripcion = $params["descripcion"];
        try {
            $result = $EstadosTerceros->save();
            if($result){
                $mensaje = 'Se guardo el EstadoTercero';
            }else{
                $mensaje = 'no se guardo el EstadoTercero';
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
        $EstadosTerceros = new EstadosTerceros;
        $EstadosTerceros->cod = $cod;
        $EstadosTerceros->descripcion = $params["descripcion"];
        try {
            $result = $EstadosTerceros->update();
            if($result){
                $mensaje = 'Se actualizo el EstadoTercero';
            }else{
                $mensaje = 'no se actualizo el EstadoTercero, porque no existe';
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

        $EstadosTerceros = EstadosTerceros::findFirst(
            [
                'conditions' => 'cod = :id:',
                'bind'       => [
                    'id' => $cod
                ]
            ]
        );
        if($EstadosTerceros){
            try {
                $result = $EstadosTerceros->delete();
                if($result){
                    $this->response->setJsonContent(array(
                        "code"=>200,
                            "status"  => "success",
                            "message" =>'Se elimino el EstadoTercero',
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
                    "message" =>'no se elimino el EstadoTercero, porque no existe',
                    "data"=>false
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();
        }
            
        
    }

}