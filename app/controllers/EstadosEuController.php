<?php

use Phalcon\Mvc\Controller;
use App\Models\EstadosEu;
class EstadosEuController extends Controller {

    public function listarAction()
    {
        try{
            $EstadosEuRetorno = [];
            $EstadosEu = EstadosEu::find();
            foreach ($EstadosEu as $value) {
                $EstadoEu = array(
                    "cod" => (int) $value->cod,
                    "descripcion" => $value->descripcion
                );
                $EstadosEuRetorno[] = $EstadoEu;
            }
            $this->response->setJsonContent(array(
                "code"=>200,
                "status"  => "success",
                "message" => "success",
                "data" =>$EstadosEuRetorno
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
        $EstadosEu = new EstadosEu;
        $EstadosEu->descripcion = $params["descripcion"];
        try {
            $result = $EstadosEu->save();
            if($result){
                $mensaje = 'Se guardo el Estado empresa usuario';
            }else{
                $mensaje = 'no se guardo el Estado empresa usuario';
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
        $EstadosEu = new EstadosEu;
        $EstadosEu->cod = $cod;
        $EstadosEu->descripcion = $params["descripcion"];
        try {
            $result = $EstadosEu->update();
            if($result){
                $mensaje = 'Se actualizo el Estado empresa usuario';
            }else{
                $mensaje = 'no se actualizo el Estado empresa usuario, porque no existe';
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

        $EstadosEu = EstadosEu::findFirst(
            [
                'conditions' => 'cod = :id:',
                'bind'       => [
                    'id' => $cod
                ]
            ]
        );
        if($EstadosEu){
            try {
                $result = $EstadosEu->delete();
                if($result){
                    $this->response->setJsonContent(array(
                        "code"=>200,
                            "status"  => "success",
                            "message" =>'Se elimino el Estado empresa usuario',
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
                    "message" =>'no se elimino el Estado empresa usuario, porque no existe',
                    "data"=>false
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();
        }
            
        
    }

}