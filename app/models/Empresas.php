<?php

namespace App\Models;

class Empresas extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $cod_tercero_representante;

    /**
     *
     * @var integer
     */
    public $cod_estado_empresa;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("db_negocios");
        $this->setSource("empresas");
        $this->hasMany('cod', 'App\Models\Perfiles', 'cod_empresa', ['alias' => 'Perfiles']);
        $this->hasMany('cod', 'App\Models\UsuariosEmpresas', 'cod_empresa', ['alias' => 'UsuariosEmpresas']);
        $this->belongsTo('cod_tipo_identificacion', 'App\Models\TiposIdentificacion', 'cod', ['alias' => 'TiposIdentificacion']);
        $this->belongsTo('cod_tercero_representante', 'App\Models\Terceros', 'cod', ['alias' => 'Terceros']);
        $this->belongsTo('cod_estado_empresa', 'App\Models\EstadosEmpresas', 'cod', ['alias' => 'EstadosEmpresas']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Empresas[]|Empresas|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Empresas|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
