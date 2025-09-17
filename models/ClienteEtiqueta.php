<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente_etiqueta".
 *
 * @property int $clet_id
 * @property int $clet_fkcli_id
 * @property int $clet_fketi_id
 *
 * @property Cliente $cletFkcli
 * @property Etiqueta $cletFketi
 */
class ClienteEtiqueta extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente_etiqueta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clet_fkcli_id', 'clet_fketi_id'], 'required'],
            [['clet_fkcli_id', 'clet_fketi_id'], 'integer'],
            [['clet_fkcli_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['clet_fkcli_id' => 'cli_id']],
            [['clet_fketi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Etiqueta::class, 'targetAttribute' => ['clet_fketi_id' => 'eti_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'clet_id' => 'Clet ID',
            'clet_fkcli_id' => 'Clet Fkcli ID',
            'clet_fketi_id' => 'Clet Fketi ID',
        ];
    }

    /**
     * Gets query for [[CletFkcli]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCletFkcli()
    {
        return $this->hasOne(Cliente::class, ['cli_id' => 'clet_fkcli_id']);
    }

    /**
     * Gets query for [[CletFketi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCletFketi()
    {
        return $this->hasOne(Etiqueta::class, ['eti_id' => 'clet_fketi_id']);
    }

    public function extraFields()
    {
        return [
            "clienteNombre" => function () {
                return $this->cletFkcli ? $this->cletFkcli->cli_nombre : null;
            },
            "etiquetaNombre" => function () {
                return $this->cletFketi ? $this->cletFketi->eti_nombre : null;
            }
        ];
    }
}

