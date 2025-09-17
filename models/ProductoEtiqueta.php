<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto_etiqueta".
 *
 * @property int $pret_id
 * @property int $pret_fkpro_id
 * @property int $pret_fketi_id
 *
 * @property Etiqueta $pretFketi
 * @property Producto $pretFkpro
 */
class ProductoEtiqueta extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto_etiqueta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pret_fkpro_id', 'pret_fketi_id'], 'required'],
            [['pret_fkpro_id', 'pret_fketi_id'], 'integer'],
            [['pret_fketi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Etiqueta::class, 'targetAttribute' => ['pret_fketi_id' => 'eti_id']],
            [['pret_fkpro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::class, 'targetAttribute' => ['pret_fkpro_id' => 'pro_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pret_id' => 'Pret ID',
            'pret_fkpro_id' => 'Pret Fkpro ID',
            'pret_fketi_id' => 'Pret Fketi ID',
        ];
    }

    /**
     * Gets query for [[PretFketi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPretFketi()
    {
        return $this->hasOne(Etiqueta::class, ['eti_id' => 'pret_fketi_id']);
    }

    /**
     * Gets query for [[PretFkpro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPretFkpro()
    {
        return $this->hasOne(Producto::class, ['pro_id' => 'pret_fkpro_id']);
    }

}
