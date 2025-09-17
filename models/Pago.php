<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pago".
 *
 * @property int $pag_id
 * @property float $pag_monto
 * @property string $pag_fecha_pago
 * @property string|null $pag_referencia
 * @property int $pag_fkmet_id
 *
 * @property Metodo $pagFkmet
 * @property Venta[] $ventas
 */
class Pago extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pago';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pag_referencia'], 'default', 'value' => null],
            [['pag_monto', 'pag_fecha_pago', 'pag_fkmet_id'], 'required'],
            [['pag_monto'], 'number'],
            [['pag_fecha_pago'], 'safe'],
            [['pag_fkmet_id'], 'integer'],
            [['pag_referencia'], 'string', 'max' => 100],
            [['pag_fkmet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metodo::class, 'targetAttribute' => ['pag_fkmet_id' => 'met_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pag_id' => 'Pag ID',
            'pag_monto' => 'Pag Monto',
            'pag_fecha_pago' => 'Pag Fecha Pago',
            'pag_referencia' => 'Pag Referencia',
            'pag_fkmet_id' => 'Pag Fkmet ID',
        ];
    }

    /**
     * Gets query for [[PagFkmet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPagFkmet()
    {
        return $this->hasOne(Metodo::class, ['met_id' => 'pag_fkmet_id']);
    }

    /**
     * Gets query for [[Ventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasMany(Venta::class, ['ven_fkpag_id' => 'pag_id']);
    }

}
