<?php
use Phalcon\Mvc\Controller;
use App\Models\Terceros;
class TercerosController extends Controller {

    public function ActualizarAction($user,$params)
    {
        $Terceros = new Terceros;
        $Terceros->cod = $user["cod_tercero"];
        $Terceros->nombres = $params["nombres"];
        $Terceros->apellidos = $params["apellidos"];
        $Terceros->fecha_nacimiento = $params["fecha_nac"];
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

        try {
            $result = $Terceros->update();
            if($result){
                $mensaje = 'El tercero se actualizo exitosamente';
            }else{
                $mensaje = 'Error al actualizar el tercero';
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
                    "data" =>false
            ));
            $this->response->setStatusCode(500, $ex->getMessage());
            $this->response->send();
        }
 
       /* 
        if(!isset($Terceros)){
            
            if (!isset($Usuarios)) {
               
                //SELECT * FROM usuarios WHERE usuario = 'jorgesiachoque08'
                $Usuarios = Usuarios::findFirst(
                    [
                        'conditions' => 'usuario= :usuario:',
                        'bind'       => [
                            'usuario' => $params["usuario"]
                        ]
                    ]
                );
                
                try {
                    $result = $Terceros->save();
                    if($result){
                        $Usuarios = new Usuarios;
                        $Usuarios->usuario = $params["usuario"];
                        $Usuarios->clave = password_hash($params["clave"],PASSWORD_DEFAULT);
                        $Usuarios->cod_estado_usuario = 1;
                        $Usuarios->cod_tercero = $Terceros->cod;
                        $result = $Usuarios->save();
                        if($result){
                            $mensaje = 'El usuario se registro exitosamente';
                        }else{
                            $mensaje = 'Error al registrar el Usuario';
                        }
                    }else{
                        $mensaje = 'Error al registrar el Tercero';
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
                            "data" =>false
                    ));
                    $this->response->setStatusCode(500, $ex->getMessage());
                    $this->response->send();
                }
                
            }else{
                $this->response->setJsonContent(array(
                    "code"=>200,
                        "status"  => "success",
                        "message" => "el username ".$params["usuario"]." ya se encuentra registrado",
                        "data" =>false
                ));
                $this->response->setStatusCode(200, "success");
                $this->response->send();
            }
        }else{
            $this->response->setJsonContent(array(
                "code"=>200,
                    "status"  => "success",
                    "message" => "ya se encuentra un usuario registrado con este email o identificación",
                    "data" =>false
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();

        } */


    }
    
}
