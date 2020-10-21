<?php

namespace App\Models;

class UsuariosEmpresas extends \Phalcon\Mvc\Model
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
    public $cod_empresa;

    /**
     *
     * @var integer
     */
    public $cod_usuario;

    /**
     *
     * @var integer
     */
    public $cod_perfil;

    /**
     *
     * @var integer
     */
    public $cod_estado_ue;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("db_negocios");
        $this->setSource("usuarios_empresas");
        $this->belongsTo('cod_perfil', 'App\Models\Perfiles', 'cod', ['alias' => 'Perfiles']);
        $this->belongsTo('cod_empresa', 'App\Models\Empresas', 'cod', ['alias' => 'Empresas']);
        $this->belongsTo('cod_usuario', 'App\Models\Usuarios', 'cod', ['alias' => 'Usuarios']);
        $this->belongsTo('cod_estado_ue', 'App\Models\EstadosEu', 'cod', ['alias' => 'EstadosEu']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UsuariosEmpresas[]|UsuariosEmpresas|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UsuariosEmpresas|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
