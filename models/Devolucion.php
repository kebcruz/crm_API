<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "devolucion".
 *
 * @property int $dev_id
 * @property string $dev_asunto
 * @property string|null $dev_descripcion
 * @property string $dev_fecha_creacion
 * @property string|null $dev_fecha_cierre
 * @property int $dev_fkved_id
 * @property int $dev_fkest_id
 *
 * @property Estatu $devFkest
 * @property VentaDetalle $devFkved
 */
class Devolucion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'devolucion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dev_descripcion', 'dev_fecha_cierre'], 'default', 'value' => null],
            [['dev_asunto', 'dev_fecha_creacion', 'dev_fkved_id', 'dev_fkest_id'], 'required'],
            [['dev_descripcion'], 'string'],
            [['dev_fecha_creacion', 'dev_fecha_cierre'], 'safe'],
            [['dev_fkved_id', 'dev_fkest_id'], 'integer'],
            [['dev_asunto'], 'string', 'max' => 150],
            [['dev_fkest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estatu::class, 'targetAttribute' => ['dev_fkest_id' => 'est_id']],
            [['dev_fkved_id'], 'exist', 'skipOnError' => true, 'targetClass' => VentaDetalle::class, 'targetAttribute' => ['dev_fkved_id' => 'ved_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dev_id' => 'Dev ID',
            'dev_asunto' => 'Dev Asunto',
            'dev_descripcion' => 'Dev Descripcion',
            'dev_fecha_creacion' => 'Dev Fecha Creacion',
            'dev_fecha_cierre' => 'Dev Fecha Cierre',
            'dev_fkved_id' => 'Dev Fkved ID',
            'dev_fkest_id' => 'Dev Fkest ID',
        ];
    }

    /**
     * Gets query for [[DevFkest]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevFkest()
    {
        return $this->hasOne(Estatu::class, ['est_id' => 'dev_fkest_id']);
    }

    /**
     * Gets query for [[DevFkved]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevFkved()
    {
        return $this->hasOne(VentaDetalle::class, ['ved_id' => 'dev_fkved_id']);
    }

}
