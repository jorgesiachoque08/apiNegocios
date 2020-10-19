<?php
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Http\Response;

class Validador {
    protected $requeridos;
    protected $msjCamposRequerid;


    public function Validando($params)
    {
        $validador = new Validation();
        $response = new Response();
        $messagesRetorno = [];
        
        $this->validandoRequeridos($validador);
        try {
            $messages = $validador->validate($params);

            if (count($messages)) {
                foreach ($messages as $message) {
                    
                    $messagesRetorno[$message->getField()][] = $message->getMessage();
                }
               $response->setJsonContent(array(
                    "code"=>400,
                    "status"=>"error",
                    "mensaje"=>$messagesRetorno
                ));
               $response->setStatusCode(200, "success");
               $response->send();
            }else{
                return true;
            }
        } catch (Exception $e) {
           $response->setJsonContent(array(
                "code"=>400,
                "status"=>"error",
                "mensaje"=>"Parametros invalidos"
            ));
           $response->setStatusCode(400, "error");
           $response->send();
        }
    }

    public function validandoRequeridos($validador)
    {
        $validador->add(
            $this->getRequeridos(),
            new PresenceOf(
                $this->getMsjCamposRequerid()
            )
        );
    }

    public function setRequeridos($requeridos)
    {
       $this->requeridos = $requeridos;
    }

    public function setMsjCamposRequerid($msjCamposRequerid)
    {
        $this->msjCamposRequerid = $msjCamposRequerid;
    }

    public function getRequeridos()
    {
        return $this->requeridos;
    }

    public function getMsjCamposRequerid()
    {
        return $this->msjCamposRequerid;
    }

}