<?php

namespace App\Models;

use Phalcon\Messages\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Terceros extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $cod;

    /**
     *
     * @var string
     */
    public $razon_social;

    /**
     *
     * @var string
     */
    public $nombres;

    /**
     *
     * @var string
     */
    public $apellidos;

    /**
     *
     * @var string
     */
    public $fecha_nacimiento;

    /**
     *
     * @var integer
     */
    public $cod_tipo_identificacion;

    /**
     *
     * @var string
     */
    public $numero_identificacion;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $telefono;

    /**
     *
     * @var string
     */
    public $celular;

    /**
     *
     * @var integer
     */
    public $cod_estado_tercero;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("db_negocios");
        $this->setSource("terceros");
        $this->hasMany('cod', 'App\Models\Compañias', 'cod_tercero_representante', ['alias' => 'Compañias']);
        $this->hasMany('cod', 'App\Models\Usuarios', 'cod_tercero', ['alias' => 'Usuarios']);
        $this->belongsTo('cod_estado_tercero', 'App\Models\EstadosTerceros', 'cod', ['alias' => 'EstadosTerceros']);
        $this->belongsTo('cod_tipo_identificacion', 'App\Models\TiposIdentificacion', 'cod', ['alias' => 'TiposIdentificacion']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Terceros[]|Terceros|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Terceros|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
