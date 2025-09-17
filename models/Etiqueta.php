<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "etiqueta".
 *
 * @property int $eti_id
 * @property string $eti_nombre
 * @property int $eti_fkcol_id
 *
 * @property ClienteEtiqueta[] $clienteEtiquetas
 * @property Color $etiFkcol
 * @property ProductoEtiqueta[] $productoEtiquetas
 */
class Etiqueta extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'etiqueta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eti_nombre', 'eti_fkcol_id'], 'required'],
            [['eti_fkcol_id'], 'integer'],
            [['eti_nombre'], 'string', 'max' => 100],
            [['eti_fkcol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::class, 'targetAttribute' => ['eti_fkcol_id' => 'col_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'eti_id' => 'Eti ID',
            'eti_nombre' => 'Eti Nombre',
            'eti_fkcol_id' => 'Eti Fkcol ID',
        ];
    }

    /**
     * Gets query for [[ClienteEtiquetas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClienteEtiquetas()
    {
        return $this->hasMany(ClienteEtiqueta::class, ['clet_fketi_id' => 'eti_id']);
    }

    /**
     * Gets query for [[EtiFkcol]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEtiFkcol()
    {
        return $this->hasOne(Color::class, ['col_id' => 'eti_fkcol_id']);
    }

    /**
     * Gets query for [[ProductoEtiquetas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductoEtiquetas()
    {
        return $this->hasMany(ProductoEtiqueta::class, ['pret_fketi_id' => 'eti_id']);
    }

    public function extraFields()
    {
        return[
            "colorNombre" =>function(){
                return $this->etiFkcol->col_nombre;
            }
        ];
    }
}
