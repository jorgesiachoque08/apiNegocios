<?php

use Phalcon\Mvc\Controller;
use App\Models\Usuarios;
use App\Models\Terceros;
class UsuariosController extends Controller {

    

    public function RegistrarAction($params)
    {
        //SELECT * FROM terceros WHERE email='jorgesiachoque08@gmail.com' OR numero_identificacion = 100000
        $Terceros = Terceros::findFirst(
            [
                'conditions' => 'email= :email: OR numero_identificacion = :identificacion: ',
                'bind'       => [
                    'email' => $params["email"],
                    'identificacion' => $params["identificacion"]
                ]
            ]
        );
        if(!isset($Terceros)){
            $Terceros = new Terceros;
            $Terceros->nombres = $params["nombres"];
            $Terceros->apellidos = $params["apellidos"];
            $Terceros->nombrfecha_nacimientoes = $params["fecha_nac"];
            $Terceros->cod_tipo_identificacion  = $params["cod_tipo_id"];
            $Terceros->numero_identificacion  = $params["identificacion"];
            $Terceros->email  = $params["email"];
            $Terceros->cod_estado_tercero  = 1;
            if(isset($params["razon_social"])){
                $Terceros->razon_social  = $params["razon_social"];
            }else{
                $Terceros->razon_social  = $params["nombres"]." ".$params["apellidos"];;
            }
            
            if(isset($params["telefono"])){
                $Terceros->telefono  = $params["telefono"];
            }
    
            if(isset($params["celular"])){
                $Terceros->celular  = $params["celular"];
            }

            /* $Usuarios = new Usuarios;



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
            } */
        }else{
            $this->response->setJsonContent(array(
                "code"=>200,
                    "status"  => "success",
                    "message" => "ya se encuentra un usuario registrado con este email o identificación",
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();

        }


    }


}