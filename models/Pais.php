<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pais".
 *
 * @property int $pai_id
 * @property string $pai_nombre
 *
 * @property Estado[] $estados
 */
class Pais extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pais';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pai_nombre'], 'required'],
            [['pai_nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pai_id' => 'Pai ID',
            'pai_nombre' => 'Pai Nombre',
        ];
    }

    /**
     * Gets query for [[Estados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstados()
    {
        return $this->hasMany(Estado::class, ['estd_fkpai_id' => 'pai_id']);
    }

}
