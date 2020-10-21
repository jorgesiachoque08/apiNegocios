<?php

use Phalcon\Mvc\Controller;
use App\Models\Empresas;
class EmpresasController extends Controller {

    

    public function listarAction($user)
    {

        try{
            $sql = "SELECT e.*,ti.descripcion as tipoIdentEmpresa,ti.abreviatura as abrevTipoIdentEmpresa,t.razon_social as razonSocialTercero,CONCAT(t.nombres,' ', t.apellidos) as NombreTercero,
            t.fecha_nacimiento,t.email,t.telefono,t.celular,t.numero_identificacion,tit.descripcion as tipoIdentTercero,tit.abreviatura as abrevTipoIdentTercero  FROM empresas as e 
            INNER JOIN tipos_identificacion as ti on ti.cod = e.cod_tipo_identificacion
            INNER JOIN terceros as t on t.cod = e.cod_tercero_representante AND t.cod_estado_tercero = 1
            INNER JOIN tipos_identificacion as tit on tit.cod = t.cod_tipo_identificacion
            WHERE cod_tercero_representante =".$user['cod_tercero'];
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

    public function listarTodasAction()
    {

        try{
            $sql = "SELECT e.*,ti.descripcion as tipoIdentEmpresa,ti.abreviatura as abrevTipoIdentEmpresa,t.razon_social as razonSocialTercero,CONCAT(t.nombres,' ', t.apellidos) as NombreTercero,
            t.fecha_nacimiento,t.email,t.telefono,t.celular,t.numero_identificacion,tit.descripcion as tipoIdentTercero,tit.abreviatura as abrevTipoIdentTercero  FROM empresas as e 
            INNER JOIN tipos_identificacion as ti on ti.cod = e.cod_tipo_identificacion
            INNER JOIN terceros as t on t.cod = e.cod_tercero_representante
            INNER JOIN tipos_identificacion as tit on tit.cod = t.cod_tipo_identificacion";
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
                "message" => 'Excepción capturada (listarTodasAction): ' . $ex->getMessage() . "\n"
            ));
            $this->response->setStatusCode(500);
            $this->response->send();
        }


    }

    public function listarEmpresaAction($tipoIdent,$identificacion)
    {

        try{
            $sql = "SELECT e.*,ti.descripcion as tipoIdentEmpresa,ti.abreviatura as abrevTipoIdentEmpresa,t.razon_social as razonSocialTercero,CONCAT(t.nombres,' ', t.apellidos) as NombreTercero,
            t.fecha_nacimiento,t.email,t.telefono,t.celular,t.numero_identificacion,tit.descripcion as tipoIdentTercero,tit.abreviatura as abrevTipoIdentTercero  FROM empresas as e 
            INNER JOIN tipos_identificacion as ti on ti.cod = e.cod_tipo_identificacion
            INNER JOIN terceros as t on t.cod = e.cod_tercero_representante AND t.cod_estado_tercero = 1
            INNER JOIN tipos_identificacion as tit on tit.cod = t.cod_tipo_identificacion
            WHERE cod_estado_empresa = 1 AND e.cod_tipo_identificacion = ".$tipoIdent." AND e.numero_identificacion = '".$identificacion."'";
            $data = $this->db->fetchOne($sql);
            
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
                "message" => 'Excepción capturada (listarEmpresaAction): ' . $ex->getMessage() . "\n"
            ));
            $this->response->setStatusCode(500);
            $this->response->send();
        }


    }

    public function agregarAction($user,$params)
    {
        $Empresas = Empresas::findFirst(
            [
                'conditions' => 'cod_tipo_identificacion=:cod_tipo_id: AND numero_identificacion=:identificacion: ',
                'bind'       => [
                    'identificacion' => $params["identificacion"],
                    'cod_tipo_id' => $params["cod_tipo_id"]
                ]
            ]
        );
        
        if(!isset($Empresas)){
            $Empresas = new Empresas();
            $Empresas->razon_social = $params["razon_social"];
            $Empresas->cod_tipo_identificacion = $params["cod_tipo_id"];
            $Empresas->numero_identificacion = $params["identificacion"];
            $Empresas->cod_tercero_representante = $user["cod_tercero"];
            $Empresas->cod_estado_empresa = 1;
            $result = $Empresas->save();
            if($result){
                $mensaje = 'La empresa se registro exitosamente';
            }else{
                $mensaje = 'Error al registrar la empresa';
            }
            $this->response->setJsonContent(array(
                "code"=>200,
                    "status"  => "success",
                    "message" => $mensaje,
                    "data"=>$result
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();
        
        }else{
            $this->response->setJsonContent(array(
                "code"=>200,
                "status"  => "success",
                "message" => "La empresa ya se encuentra registrada",
                "data" =>false
            ));
            $this->response->setStatusCode(200);
            $this->response->send();
        }
        
    }

    public function actualizarAction($user,$cod,$params)
    {
        //AND cod <> :cod: 
        $Empresas = Empresas::findFirst(
            [
                'conditions' => 'cod= :cod:',
                'bind'       => [
                    'cod' => $cod,

                ]
            ]
        );
       
        if(isset($Empresas)){
            
            if($Empresas->cod_tercero_representante == $user["cod_tercero"] ){
            
                $Empresas = Empresas::findFirst(
                    [
                        'conditions' => 'numero_identificacion= :identificacion: AND cod_tipo_identificacion = :cod_tipo_id: ',
                        'bind'       => [
                            'identificacion'=> $params["identificacion"],
                            'cod_tipo_id'=> $params["cod_tipo_id"]
        
                        ]
                    ]
                );

                if(!isset($Empresas) || $Empresas->cod == $cod){
                    $Empresa = new Empresas();
                    $Empresa->cod = $cod;
                    $Empresa->razon_social = $params["razon_social"];
                    $Empresa->cod_tipo_identificacion = $params["cod_tipo_id"];
                    $Empresa->numero_identificacion = $params["identificacion"];
                    $Empresa->cod_tercero_representante = $user["cod_tercero"];
                    $Empresa->cod_estado_empresa = 1;
                    

                    try {
                        $result = $Empresa->update();
                        if($result){
                            $mensaje = 'La empresa se actualizo exitosamente';
                        }else{
                            $mensaje = 'Error al actualizar la empresa';
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
                                "data" =>false
                        ));
                        $this->response->setStatusCode(500, $ex->getMessage());
                        $this->response->send();
                    }
                }else{
    
                    $this->response->setJsonContent(array(
                        "code"=>200,
                            "status"  => "success",
                            "message" => "esta identificacion ya la tiene otra empresa registrada",
                            "data" =>false
                    ));
                    $this->response->setStatusCode(200,"OK");
                    $this->response->send();
                }

            }else{
                $this->response->setJsonContent(array(
                    "code"=>200,
                        "status"  => "success",
                        "message" => "No eres el representante de esta empresa",
                        "data" =>false
                ));
                $this->response->setStatusCode(200,"OK");
                $this->response->send();
            }
           
        }else{
            $this->response->setJsonContent(array(
                "code"=>200,
                    "status"  => "success",
                    "message" => "Esta empresa no esta registrada",
                    "data" =>false
            ));
            $this->response->setStatusCode(200,"OK");
            $this->response->send();

        }

    }

    public function cambiarEstadoAction($user,$cod,$params)
    {

        $Empresas = Empresas::findFirst(
            [
                'conditions' => 'cod = :cod:',
                'bind'       => [
                    'cod' => $cod
                ]
            ]
        );
        if($Empresas){
            if($Empresas->cod_tercero_representante == $user["cod_tercero"] ){
                try {
                    $Empresas->cod_estado_empresa = $params['estado'];
                    $result = $Empresas->update();
                    if($result){
                        $mensaje ='Se Cambio el estado a la empresa';
                    }else{
                        $mensaje ='error al cambiar el estado a la empresa';
                    }
                    $this->response->setJsonContent(array(
                        "code"=>200,
                            "status"  => "success",
                            "message" =>$mensaje,
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
            }else{
                $this->response->setJsonContent(array(
                    "code"=>200,
                        "status"  => "success",
                        "message" => "No eres el representante de esta empresa",
                        "data" =>false
                ));
                $this->response->setStatusCode(200,"OK");
                $this->response->send();
            }

        }else{
            $this->response->setJsonContent(array(
                "code"=>200,
                    "status"  => "success",
                    "message" =>'no se cambio el estado a la empresa, porque no existe',
                    "data"=>false
            ));
            $this->response->setStatusCode(200, "success");
            $this->response->send();
        }
            
        
    }
}