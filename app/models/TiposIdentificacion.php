<?php

namespace App\Models;

class TiposIdentificacion extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $cod;

    /**
     *
     * @var integer
     */
    public $cod_pais;

    /**
     *
     * @var string
     */
    public $descripcion;

    /**
     *
     * @var string
     */
    public $abreviatura;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("db_negocios");
        $this->setSource("tipos_identificacion");
        $this->hasMany('cod', 'App\Models\Compañias', 'cod_tipo_identificacion', ['alias' => 'Compañias']);
        $this->hasMany('cod', 'App\Models\Terceros', 'cod_tipo_identificacion', ['alias' => 'Terceros']);
        $this->belongsTo('cod_pais', 'App\Models\Paises', 'cod', ['alias' => 'Paises']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TiposIdentificacion[]|TiposIdentificacion|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TiposIdentificacion|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}
