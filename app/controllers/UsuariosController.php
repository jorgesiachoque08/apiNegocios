<?php

use Phalcon\Mvc\Controller;
use App\Models\Usuarios;
use App\Models\Terceros;
class UsuariosController extends Controller {

    

    public function listarAction($user)
    {
        try{
            $sql = "SELECT u.usuario,t.* FROM usuarios as u 
            INNER JOIN terceros as t on t.cod = u.cod_tercero
            WHERE u.cod = ".$user['id'];
            $data = $this->db->fetchOne($sql);
            if($data){
                $this->db->fetch("selec");
                $data["empresas"] = [];
                $data["subscripcionEmpresas"] = [];
            }

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


}