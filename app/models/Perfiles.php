<?php

namespace App\Models;

class Perfiles extends \Phalcon\Mvc\Model
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
     *
     * @var integer
     */
    public $cod_compañia;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("db_negocios");
        $this->setSource("perfiles");
        $this->hasMany('cod', 'App\Models\FuncionesPerfiles', 'cod_perfil', ['alias' => 'FuncionesPerfiles']);
        $this->hasMany('cod', 'App\Models\UsuariosEmpresas', 'cod_perfil', ['alias' => 'UsuariosEmpresas']);
        $this->belongsTo('cod_compañia', 'App\Models\Compañias', 'cod', ['alias' => 'Compañias']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Perfiles[]|Perfiles|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Perfiles|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
