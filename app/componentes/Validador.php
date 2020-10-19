<?php
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Digit as DigitValidator;
use Phalcon\Validation\Validator\Email;
use \Phalcon\Http\Response;

class Validador {
    protected $requeridos;
    protected $msjCamposRequerid;
    protected $enteros;
    protected $msjCamposEnteros;
    protected $email;
    protected $msjCamposEmail;


    public function Validando($params)
    {
        $validador = new Validation();
        $response = new Response();
        $messagesRetorno = [];
        
        
        if(isset($this->requeridos) && isset($this->msjCamposRequerid)){
            $this->validandoRequeridos($validador);
        }

        if(isset($this->enteros) && isset($this->msjCamposEnteros)){
            $this->validandoEnteros($validador);
        }

        if(isset($this->email) && isset($this->msjCamposEmail)){
            $this->validandoEmails($validador);
        }

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

    public function validandoEnteros($validador)
    {
        $validador->add(
            $this->getEnteros(),
            new DigitValidator(
                $this->getMsjCamposEnteros()
            )
        );
    }
    public function validandoEmails($validador)
    {
        $validador->add(
            $this->getEmail(),
            new Email(
                $this->getMsjCamposEmail()
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

    public function setEnteros($enteros)
    {
       $this->enteros = $enteros;
    }

    public function setMsjCamposEnteros($msjCamposEnteros)
    {
        $this->msjCamposEnteros = $msjCamposEnteros;
    }

    public function getEnteros()
    {
        return $this->enteros;
    }

    public function getMsjCamposEnteros()
    {
        return $this->msjCamposEnteros;
    }

    public function setEmail($email)
    {
       $this->email = $email;
    }

    public function setMsjCamposEmail($msjCamposEmail)
    {
        $this->msjCamposEmail = $msjCamposEmail;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMsjCamposEmail()
    {
        return $this->msjCamposEmail;
    }

}