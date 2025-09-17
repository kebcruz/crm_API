<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "color".
 *
 * @property int $col_id
 * @property string $col_nombre
 *
 * @property Etiqueta[] $etiquetas
 * @property Producto[] $productos
 */
class Color extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['col_nombre'], 'required'],
            [['col_nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'col_id' => 'Col ID',
            'col_nombre' => 'Col Nombre',
        ];
    }

    /**
     * Gets query for [[Etiquetas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEtiquetas()
    {
        return $this->hasMany(Etiqueta::class, ['eti_fkcol_id' => 'col_id']);
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::class, ['pro_fkcol_id' => 'col_id']);
    }

}
