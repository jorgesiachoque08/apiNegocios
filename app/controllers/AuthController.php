<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;
use Phalcon\Mvc\Controller;
class AuthController extends Controller {

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
