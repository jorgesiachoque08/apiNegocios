<?php

namespace App\Models;

class EstadosEmpresas extends \Phalcon\Mvc\Model
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
        $this->setSource("estados_empresas");
        $this->hasMany('cod', 'App\Models\Compañias', 'cod_estado_empresa', ['alias' => 'Compañias']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return EstadosEmpresas[]|EstadosEmpresas|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return EstadosEmpresas|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
