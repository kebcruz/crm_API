<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "venta".
 *
 * @property int $ven_id
 * @property string $ven_fecha_venta
 * @property float $ven_total
 * @property int $ven_fkcli_id
 * @property int $ven_fkemp_id
 * @property int $ven_fkpag_id
 *
 * @property Cliente $venFkcli
 * @property Empleado $venFkemp
 * @property Pago $venFkpag
 * @property VentaDetalle[] $ventaDetalles
 */
class Venta extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ven_fecha_venta', 'ven_total', 'ven_fkcli_id', 'ven_fkemp_id', 'ven_fkpag_id'], 'required'],
            [['ven_fecha_venta'], 'safe'],
            [['ven_total'], 'number'],
            [['ven_fkcli_id', 'ven_fkemp_id', 'ven_fkpag_id'], 'integer'],
            [['ven_fkcli_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['ven_fkcli_id' => 'cli_id']],
            [['ven_fkemp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::class, 'targetAttribute' => ['ven_fkemp_id' => 'emp_id']],
            [['ven_fkpag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pago::class, 'targetAttribute' => ['ven_fkpag_id' => 'pag_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ven_id' => 'Ven ID',
            'ven_fecha_venta' => 'Ven Fecha Venta',
            'ven_total' => 'Ven Total',
            'ven_fkcli_id' => 'Ven Fkcli ID',
            'ven_fkemp_id' => 'Ven Fkemp ID',
            'ven_fkpag_id' => 'Ven Fkpag ID',
        ];
    }

    /**
     * Gets query for [[VenFkcli]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenFkcli()
    {
        return $this->hasOne(Cliente::class, ['cli_id' => 'ven_fkcli_id']);
    }

    /**
     * Gets query for [[VenFkemp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenFkemp()
    {
        return $this->hasOne(Empleado::class, ['emp_id' => 'ven_fkemp_id']);
    }

    /**
     * Gets query for [[VenFkpag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenFkpag()
    {
        return $this->hasOne(Pago::class, ['pag_id' => 'ven_fkpag_id']);
    }

    /**
     * Gets query for [[VentaDetalles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentaDetalles()
    {
        return $this->hasMany(VentaDetalle::class, ['ved_fkven_id' => 'ven_id']);
    }

    public function extraFields()
    {
        return[
            "clienteNombre" =>function(){
                return $this->venFkcli->cli_nombre;
            },
            "empleadoNombre" =>function(){
                return $this->venFkemp->emp_nombre;
            },
             "pagoReferencia" =>function(){
                return $this->venFkpag->pag_referencia;
            },
            'ventaDetalles',
        ];
    }

}
