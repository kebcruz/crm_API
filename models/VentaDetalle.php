<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "venta_detalle".
 *
 * @property int $ved_id
 * @property int $ved_cantidad
 * @property float $ved_precio
 * @property int|null $ved_descuento
 * @property float $ved_subtotal
 * @property int $ved_fkven_id
 * @property int $ved_fkpro_id
 *
 * @property Devolucion[] $devolucions
 * @property Producto $vedFkpro
 * @property Venta $vedFkven
 */
class VentaDetalle extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venta_detalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ved_descuento'], 'default', 'value' => null],
            [['ved_cantidad', 'ved_precio', 'ved_subtotal', 'ved_fkven_id', 'ved_fkpro_id'], 'required'],
            [['ved_cantidad', 'ved_descuento', 'ved_fkven_id', 'ved_fkpro_id'], 'integer'],
            [['ved_precio', 'ved_subtotal'], 'number'],
            [['ved_fkpro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::class, 'targetAttribute' => ['ved_fkpro_id' => 'pro_id']],
            [['ved_fkven_id'], 'exist', 'skipOnError' => true, 'targetClass' => Venta::class, 'targetAttribute' => ['ved_fkven_id' => 'ven_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ved_id' => 'Ved ID',
            'ved_cantidad' => 'Ved Cantidad',
            'ved_precio' => 'Ved Precio',
            'ved_descuento' => 'Ved Descuento',
            'ved_subtotal' => 'Ved Subtotal',
            'ved_fkven_id' => 'Ved Fkven ID',
            'ved_fkpro_id' => 'Ved Fkpro ID',
        ];
    }

    /**
     * Gets query for [[Devolucions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevolucions()
    {
        return $this->hasMany(Devolucion::class, ['dev_fkved_id' => 'ved_id']);
    }

    /**
     * Gets query for [[VedFkpro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVedFkpro()
    {
        return $this->hasOne(Producto::class, ['pro_id' => 'ved_fkpro_id']);
    }

    /**
     * Gets query for [[VedFkven]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVedFkven()
    {
        return $this->hasOne(Venta::class, ['ven_id' => 'ved_fkven_id']);
    }

}
