<?php

use Phalcon\Mvc\Controller;
use App\Models\Usuarios;
use App\Models\UsuariosEmpresas;
use App\Models\Empresas;
class UsuariosController extends Controller {

    

    public function listarAction($user)
    {
        try{
            $sql = "SELECT u.usuario,t.*,ti.descripcion as tipoIdentTercero,ti.abreviatura as abrevTipoIdentTercero FROM usuarios as u 
            INNER JOIN terceros as t on t.cod = u.cod_tercero
            INNER JOIN tipos_identificacion as ti on ti.cod = t.cod_tipo_identificacion
            WHERE u.cod =".$user['id'];
            $data = $this->db->fetchOne($sql);
            if($data){
                $empresas = $this->db->fetchAll("SELECT * FROM empresas WHERE cod_tercero_representante = ".$user['cod_tercero']);
                $data["empresas"] = $empresas;
                $subscripcionEmpresas = $this->db->fetchAll("SELECT * FROM usuarios_empresas as ue
                                                            INNER JOIN empresas as c on c.cod = ue.cod_empresa 
                                                            WHERE ue.cod_usuario = ".$user['cod_tercero']." AND c.cod_estado_empresa = 1");
                $data["subscripcionEmpresas"] = $subscripcionEmpresas;
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

    public function afiliarseEmpresaAction($user,$codEmpresa)
    {
        $Empresas = Empresas::findFirst(
            [
                'conditions' => 'cod= :cod:',
                'bind'       => [
                    'cod' => $codEmpresa,

                ]
            ]
        );

        if ($Empresas) {
            if(!($Empresas->cod_tercero_representante == $user["cod_tercero"]) ){
                $UsuariosEmpresas = UsuariosEmpresas::findFirst(
                    [
                        'conditions' => 'cod_usuario= :cod_usuario: AND cod_empresa= :cod_empresa:',
                        'bind'       => [
                            'cod_usuario' => $user['id'],
                            'cod_empresa' => $codEmpresa,
        
                        ]
                    ]
                );

                if($UsuariosEmpresas){
                    $this->response->setJsonContent(array(
                        "code"=>200,
                            "status"  => "success",
                            "message" => "ya tienes una solicitud de afiliacion a esta empresa",
                            "data" =>false
                    ));
                    $this->response->setStatusCode(200,"OK");
                    $this->response->send();
                }else{
                    $UsuariosEmpresas = new UsuariosEmpresas;
                    $UsuariosEmpresas->cod_empresa = $codEmpresa;
                    $UsuariosEmpresas->cod_usuario = $user['id'];
                    $UsuariosEmpresas->cod_estado_ue = 2;
                    try {
                        $result = $UsuariosEmpresas->save();
                        if($result){
                            $mensaje = 'Se guardo la solicitud de afiliacion';
                        }else{
                            $mensaje = 'No se guardo la solicitud de afiliacion';
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
                                "message" => 'Excepción capturada (afiliarseEmpresaAction): ' . $ex->getMessage() . "\n",
                        ));
                        $this->response->setStatusCode(500, $ex->getMessage());
                        $this->response->send();
                    }

                }

            }else{
                $this->response->setJsonContent(array(
                    "code"=>200,
                        "status"  => "success",
                        "message" => "eres el representante de la empresa, no puedes afiliarte a ella",
                        "data" =>false
                ));
                $this->response->setStatusCode(200,"OK");
                $this->response->send();
            }
            # code...
        }else{
            $this->response->setJsonContent(array(
                "code"=>200,
                    "status"  => "success",
                    "message" => "esta empresa no se encuentra registrada",
                    "data" =>false
            ));
            $this->response->setStatusCode(200,"OK");
            $this->response->send();
        }
        
    }

    public function CambiarEstadoSolicitudAction($user,$params)
    {
        $UsuariosEmpresas = UsuariosEmpresas::findFirst(
            [
                'conditions' => 'cod :cod:',
                'bind'       => [
                    'cod' => $params['codSolicitud'],

                ]
            ]
        );

        if($UsuariosEmpresas){

        }else{
            $this->response->setJsonContent(array(
                "code"=>200,
                    "status"  => "success",
                    "message" => "No existe esta solicitud",
                    "data" =>false
            ));
            $this->response->setStatusCode(200,"OK");
            $this->response->send();
        }
    }

}