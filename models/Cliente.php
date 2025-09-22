<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $cli_id
 * @property string $cli_nombre
 * @property string $cli_paterno
 * @property string $cli_materno
 * @property int $cli_telefono
 * @property string $cli_correo
 * @property string $cli_fecha_registro
 * @property int $cli_fkdom_id
 *
 * @property Domicilio $cliFkdom
 * @property ClienteEtiqueta[] $clienteEtiquetas
 * @property Venta[] $ventas
 */
class Cliente extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cli_nombre', 'cli_paterno', 'cli_materno', 'cli_telefono', 'cli_correo', 'cli_fecha_registro', 'cli_fkdom_id'], 'required'],
            [['cli_telefono', 'cli_fkdom_id'], 'integer'],
            [['cli_fecha_registro'], 'safe'],
            [['cli_nombre', 'cli_paterno', 'cli_materno', 'cli_correo'], 'string', 'max' => 50],
            [['cli_fkdom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Domicilio::class, 'targetAttribute' => ['cli_fkdom_id' => 'dom_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cli_id' => 'Cli ID',
            'cli_nombre' => 'Cli Nombre',
            'cli_paterno' => 'Cli Paterno',
            'cli_materno' => 'Cli Materno',
            'cli_telefono' => 'Cli Telefono',
            'cli_correo' => 'Cli Correo',
            'cli_fecha_registro' => 'Cli Fecha Registro',
            'cli_fkdom_id' => 'Cli Fkdom ID',
        ];
    }

    /**
     * Gets query for [[CliFkdom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliFkdom()
    {
        return $this->hasOne(Domicilio::class, ['dom_id' => 'cli_fkdom_id']);
    }

    /**
     * Gets query for [[ClienteEtiquetas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClienteEtiquetas()
    {
        return $this->hasMany(ClienteEtiqueta::class, ['clet_fkcli_id' => 'cli_id']);
    }

    /**
     * Gets query for [[Ventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasMany(Venta::class, ['ven_fkcli_id' => 'cli_id']);
    }
    
    public function extraFields()
    {
        return[
            "domicilioNombre" =>function(){
                return $this->cliFkdom->dom_calle;
            },
            "municipioNombre" => function () {
            return $this->cliFkdom && $this->cliFkdom->domFkmun
                ? $this->cliFkdom->domFkmun->mun_nombre
                :null;
            }
        ];
    }

}
