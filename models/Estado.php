<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estado".
 *
 * @property int $estd_id
 * @property string $estd_nombre
 * @property int $estd_fkpai_id
 *
 * @property Pais $estdFkpai
 * @property Municipio[] $municipios
 */
class Estado extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estd_nombre', 'estd_fkpai_id'], 'required'],
            [['estd_fkpai_id'], 'integer'],
            [['estd_nombre'], 'string', 'max' => 100],
            [['estd_fkpai_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::class, 'targetAttribute' => ['estd_fkpai_id' => 'pai_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'estd_id' => 'Estd ID',
            'estd_nombre' => 'Estd Nombre',
            'estd_fkpai_id' => 'Estd Fkpai ID',
        ];
    }

    /**
     * Gets query for [[EstdFkpai]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstdFkpai()
    {
        return $this->hasOne(Pais::class, ['pai_id' => 'estd_fkpai_id']);
    }

    /**
     * Gets query for [[Municipios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipios()
    {
        return $this->hasMany(Municipio::class, ['mun_fkestd_id' => 'estd_id']);
    }

    public function extraFields()
    {
        return[
            "paisNombre" =>function(){
                return $this->estdFkpai->pai_nombre;
            }
        ];
    }
}
