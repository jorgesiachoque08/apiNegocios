<?php

namespace App\Models;

class Funciones extends \Phalcon\Mvc\Model
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
    public $descripcion;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("db_negocios");
        $this->setSource("funciones");
        $this->hasMany('cod', 'App\Models\FuncionesPerfiles', 'cod_funcion', ['alias' => 'FuncionesPerfiles']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Funciones[]|Funciones|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Funciones|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
