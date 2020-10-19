<?php

use Phalcon\Mvc\Controller;
use App\Models\TiposIdentificacion;
class TiposIdentificacionController extends Controller {

    public function listarAction()
    {
        try{
            $sql = "SELECT ti.*,p.pais FROM tipos_identificacion as ti 
            INNER JOIN paises as p on p.cod = ti.cod_pais";
            $data = $this->db->fetchAll($sql);
            $this->response->setJsonContent(array(
                "code"=>200,
                "status"  => "success",
                "message" => "success",
                "data" =>$data
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
        $TiposIdentificacion = new TiposIdentificacion;
        $TiposIdentificacion->descripcion = $params["descripcion"];
        $TiposIdentificacion->cod_pais = $params["cod_pais"];
        $TiposIdentificacion->abreviatura = $params["abreviatura"];
        try {
            $result = $TiposIdentificacion->save();
            if($result){
                $mensaje = 'Se guardo el tipo de identificación';
            }else{
                $mensaje = 'no se guardo el tipo de identificación';
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
        $TiposIdentificacion = new TiposIdentificacion;
        $TiposIdentificacion->cod = $cod;
        $TiposIdentificacion->descripcion = $params["descripcion"];
        $TiposIdentificacion->cod_pais = $params["cod_pais"];
        $TiposIdentificacion->abreviatura = $params["abreviatura"];
        
        try {
            $result = $TiposIdentificacion->update();
            if($result){
                $mensaje = 'Se actualizo el tipo de identificación';
            }else{
                $mensaje = 'no se actualizo el tipo de identificación, porque no existe';
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

        $TiposIdentificacion = TiposIdentificacion::findFirst(
            [
                'conditions' => 'cod = :id:',
                'bind'       => [
                    'id' => $cod
                ]
            ]
        );
        if($TiposIdentificacion){
            try {
                $result = $TiposIdentificacion->delete();
                if($result){
                    $this->response->setJsonContent(array(
                        "code"=>200,
                            "status"  => "success",
                            "message" =>'Se elimino el tipo de identificación',
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
                    "message" =>'no se elimino el tipo de identificación, porque no existe',
                    "data"=>false
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();
        }
            
        
    }

}