<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "domicilio".
 *
 * @property int $dom_id
 * @property string $dom_calle
 * @property string|null $dom_numero
 * @property int|null $dom_cp
 * @property int $dom_fkmun_id
 *
 * @property Cliente[] $clientes
 * @property Municipio $domFkmun
 * @property Empleado[] $empleados
 * @property Proveedor[] $proveedors
 */
class Domicilio extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domicilio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dom_numero', 'dom_cp'], 'default', 'value' => null],
            [['dom_calle', 'dom_fkmun_id'], 'required'],
            [['dom_cp', 'dom_fkmun_id'], 'integer'],
            [['dom_calle'], 'string', 'max' => 100],
            [['dom_numero'], 'string', 'max' => 5],
            [['dom_fkmun_id'], 'exist', 'skipOnError' => true, 'targetClass' => Municipio::class, 'targetAttribute' => ['dom_fkmun_id' => 'mun_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dom_id' => 'Dom ID',
            'dom_calle' => 'Dom Calle',
            'dom_numero' => 'Dom Numero',
            'dom_cp' => 'Dom Cp',
            'dom_fkmun_id' => 'Dom Fkmun ID',
        ];
    }

    /**
     * Gets query for [[Clientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::class, ['cli_fkdom_id' => 'dom_id']);
    }

    /**
     * Gets query for [[DomFkmun]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDomFkmun()
    {
        return $this->hasOne(Municipio::class, ['mun_id' => 'dom_fkmun_id']);
    }

    /**
     * Gets query for [[Empleados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleado::class, ['emp_fkdom_id' => 'dom_id']);
    }

    /**
     * Gets query for [[Proveedors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProveedors()
    {
        return $this->hasMany(Proveedor::class, ['prov_fkdom_id' => 'dom_id']);
    }

    public function extraFields()
    {
        return[
            "municipioNombre" =>function(){
                return $this->domFkmun->mun_nombre;
            }
        ];
    }
}
