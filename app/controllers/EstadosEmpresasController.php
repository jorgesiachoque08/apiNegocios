<?php

use Phalcon\Mvc\Controller;
use App\Models\EstadosEmpresas;
class EstadosEmpresasController extends Controller {

    public function listarAction()
    {
        try{
            $EstadosEmpresasRetorno = [];
            $EstadosEmpresas = EstadosEmpresas::find();
            foreach ($EstadosEmpresas as $value) {
                $EstadoEmpresa = array(
                    "cod" => (int) $value->cod,
                    "descripcion" => $value->descripcion
                );
                $EstadosEmpresasRetorno[] = $EstadoEmpresa;
            }
            $this->response->setJsonContent(array(
                "code"=>200,
                "status"  => "success",
                "message" => "success",
                "data" =>$EstadosEmpresasRetorno
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
        $EstadosEmpresas = new EstadosEmpresas;
        $EstadosEmpresas->descripcion = $params["descripcion"];
        try {
            $result = $EstadosEmpresas->save();
            if($result){
                $mensaje = 'Se guardo el EstadoEmpresa';
            }else{
                $mensaje = 'no se guardo el EstadoEmpresa';
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
        $EstadosEmpresas = new EstadosEmpresas;
        $EstadosEmpresas->cod = $cod;
        $EstadosEmpresas->descripcion = $params["descripcion"];
        try {
            $result = $EstadosEmpresas->update();
            if($result){
                $mensaje = 'Se actualizo el EstadoEmpresa';
            }else{
                $mensaje = 'no se actualizo el EstadoEmpresa, porque no existe';
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

        $EstadosEmpresas = EstadosEmpresas::findFirst(
            [
                'conditions' => 'cod = :id:',
                'bind'       => [
                    'id' => $cod
                ]
            ]
        );
        if($EstadosEmpresas){
            try {
                $result = $EstadosEmpresas->delete();
                if($result){
                    $this->response->setJsonContent(array(
                        "code"=>200,
                            "status"  => "success",
                            "message" =>'Se elimino el EstadoEmpresa',
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
                    "message" =>'no se elimino el EstadoEmpresa, porque no existe',
                    "data"=>false
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();
        }
            
        
    }

}