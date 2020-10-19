<?php

namespace App\Models;

class Usuarios extends \Phalcon\Mvc\Model
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
    public $usuario;

    /**
     *
     * @var string
     */
    public $clave;

    /**
     *
     * @var integer
     */
    public $cod_estado_usuario;

    /**
     *
     * @var integer
     */
    public $cod_tercero;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("db_negocios");
        $this->setSource("usuarios");
        $this->hasMany('cod', 'App\Models\UsuariosEmpresas', 'cod_usuario', ['alias' => 'UsuariosEmpresas']);
        $this->belongsTo('cod_tercero', 'App\Models\Terceros', 'cod', ['alias' => 'Terceros']);
        $this->belongsTo('cod_estado_usuario', 'App\Models\EstadosUsuarios', 'cod', ['alias' => 'EstadosUsuarios']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios[]|Usuarios|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
