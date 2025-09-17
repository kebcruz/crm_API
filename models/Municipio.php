<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipio".
 *
 * @property int $mun_id
 * @property string $mun_nombre
 * @property int $mun_fkestd_id
 *
 * @property Domicilio[] $domicilios
 * @property Estado $munFkestd
 */
class Municipio extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'municipio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mun_nombre', 'mun_fkestd_id'], 'required'],
            [['mun_fkestd_id'], 'integer'],
            [['mun_nombre'], 'string', 'max' => 100],
            [['mun_fkestd_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::class, 'targetAttribute' => ['mun_fkestd_id' => 'estd_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mun_id' => 'Mun ID',
            'mun_nombre' => 'Mun Nombre',
            'mun_fkestd_id' => 'Mun Fkestd ID',
        ];
    }

    /**
     * Gets query for [[Domicilios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDomicilios()
    {
        return $this->hasMany(Domicilio::class, ['dom_fkmun_id' => 'mun_id']);
    }

    /**
     * Gets query for [[MunFkestd]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMunFkestd()
    {
        return $this->hasOne(Estado::class, ['estd_id' => 'mun_fkestd_id']);
    }

    public function extraFields()
    {
        return[
            "estadoNombre" =>function(){
                return $this->munFkestd->estd_nombre;
            }
        ];
    }
}
