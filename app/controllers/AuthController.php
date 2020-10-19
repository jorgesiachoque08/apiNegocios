<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;
use Phalcon\Mvc\Controller;
use App\Models\Usuarios;
use App\Models\Terceros;
class AuthController extends Controller {

    public function registrarAction($params)
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
        $this->response->setJsonContent(array(
            "code"=>200,
                "status"  => "success",
                "message" => $Terceros
        ));
        $this->response->setStatusCode(200, "success");
        $this->response->send();
        return;
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
    
    public function loginAction(){
        // $user = array(
        //     "id_usuario"=> 1,
        //     "username"  => "jorge siachoque",
        // );

        // $getConfig = $this->config;
        // $getConfig->jwt->data->data = $user;
        // $this->response->setJsonContent(array(
        //     "status"  => 200,
        //     "expira" =>3600,
        //     "token" => JWT::encode($getConfig->jwt->data, $getConfig->jwt->key)
        // ));

        // //devolvemos un 200, todo ha ido bien
        // $this->response->setStatusCode(200, "OK");
        // $this->response->send();
        try{
            $sql = "select * from paises";

            //$data = $this->db->query($sql);;
            $data = $this->db->fetchAll($sql);
            return [
                "code" => 200,
                "status" => "success",
                "data" => $data
            ];

        } catch (Exception $e) {
            return [
                "code" => 500,
                "status" => "error",
                "message" => $e->getMessage()
            ];
        } 
    }
    
    public function verificarToken(){
        
        $headers = apache_request_headers();
        if(isset($headers['Authorization'])){
            list($jwt) = sscanf( $headers['Authorization'], 'Bearer %s');
            if ($jwt) {
                /* $token = JWT::decode($jwt, $this->config->jwt->key,array('HS256'));
                print_r( $token); */

                try {
                    //JWT::$leeway = 60; // 60 seconds
                    $user = JWT::decode($jwt, $this->config->jwt->key,array('HS256'));
                } catch (ExpiredException $e) {
                    $this->response->setJsonContent(array(
                        "status"=>405,
                        "mensaje"=>"El token Expiro"
                    ));
                    $this->response->setStatusCode(405, $e->getMessage());
                    $this->response->send();
                }catch(Exception $e){
                    $this->response->setJsonContent(array(
                        "status"=>401,
                        "mensaje"=>"Unauthorized"
                    ));
                    $this->response->setStatusCode(401, "Unauthorized");
                    $this->response->send();
                }
               
            } else {
                $this->response->setJsonContent(array(
                    "status"=>401,
                    "mensaje"=>"Unauthorized"
                ));

                $this->response->setStatusCode(401, "401 Unauthorized");
                $this->response->send();
            }
        }else{
            $this->response->setJsonContent(array(
                "status"=>403,
                "mensaje"=>"Forbidden"
            ));

            $this->response->setStatusCode(403, "403 Forbidden");
            $this->response->send();
        }

    }
    
}
