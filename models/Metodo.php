<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "metodo".
 *
 * @property int $met_id
 * @property string $met_nombre
 * @property string|null $met_descripcion
 *
 * @property Pago[] $pagos
 */
class Metodo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['met_descripcion'], 'default', 'value' => null],
            [['met_nombre'], 'required'],
            [['met_descripcion'], 'string'],
            [['met_nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'met_id' => 'Met ID',
            'met_nombre' => 'Met Nombre',
            'met_descripcion' => 'Met Descripcion',
        ];
    }

    /**
     * Gets query for [[Pagos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPagos()
    {
        return $this->hasMany(Pago::class, ['pag_fkmet_id' => 'met_id']);
    }

}
