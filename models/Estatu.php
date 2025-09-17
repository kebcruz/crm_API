<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estatu".
 *
 * @property int $est_id
 * @property string $est_nombre
 * @property string|null $est_descripcion
 *
 * @property Devolucion[] $devolucions
 * @property Producto[] $productos
 * @property Proveedor[] $proveedors
 */
class Estatu extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estatu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['est_descripcion'], 'default', 'value' => null],
            [['est_nombre'], 'required'],
            [['est_descripcion'], 'string'],
            [['est_nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'est_id' => 'Est ID',
            'est_nombre' => 'Est Nombre',
            'est_descripcion' => 'Est Descripcion',
        ];
    }

    /**
     * Gets query for [[Devolucions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevolucions()
    {
        return $this->hasMany(Devolucion::class, ['dev_fkest_id' => 'est_id']);
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::class, ['pro_fkest_id' => 'est_id']);
    }

    /**
     * Gets query for [[Proveedors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProveedors()
    {
        return $this->hasMany(Proveedor::class, ['prov_fkest_id' => 'est_id']);
    }

}
