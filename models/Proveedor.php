<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proveedor".
 *
 * @property int $prov_id
 * @property string $prov_nombre
 * @property string $prov_contacto
 * @property int $prov_telefono
 * @property string $prov_correo
 * @property string $prov_fecha_creacion
 * @property int $prov_fkest_id
 * @property int $prov_fkdom_id
 *
 * @property Producto[] $productos
 * @property Domicilio $provFkdom
 * @property Estatu $provFkest
 */
class Proveedor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proveedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prov_nombre', 'prov_contacto', 'prov_telefono', 'prov_correo', 'prov_fecha_creacion', 'prov_fkest_id', 'prov_fkdom_id'], 'required'],
            [['prov_telefono', 'prov_fkest_id', 'prov_fkdom_id'], 'integer'],
            [['prov_fecha_creacion'], 'safe'],
            [['prov_nombre'], 'string', 'max' => 255],
            [['prov_contacto'], 'string', 'max' => 200],
            [['prov_correo'], 'string', 'max' => 50],
            [['prov_fkdom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Domicilio::class, 'targetAttribute' => ['prov_fkdom_id' => 'dom_id']],
            [['prov_fkest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estatu::class, 'targetAttribute' => ['prov_fkest_id' => 'est_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'prov_id' => 'Prov ID',
            'prov_nombre' => 'Prov Nombre',
            'prov_contacto' => 'Prov Contacto',
            'prov_telefono' => 'Prov Telefono',
            'prov_correo' => 'Prov Correo',
            'prov_fecha_creacion' => 'Prov Fecha Creacion',
            'prov_fkest_id' => 'Prov Fkest ID',
            'prov_fkdom_id' => 'Prov Fkdom ID',
        ];
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::class, ['pro_fkproveedor_id' => 'prov_id']);
    }

    /**
     * Gets query for [[ProvFkdom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvFkdom()
    {
        return $this->hasOne(Domicilio::class, ['dom_id' => 'prov_fkdom_id']);
    }

    /**
     * Gets query for [[ProvFkest]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvFkest()
    {
        return $this->hasOne(Estatu::class, ['est_id' => 'prov_fkest_id']);
    }

    public function extraFields()
    {
        return [
            "domicilioNombre" => function () {
                return $this->provFkdom->dom_calle;
            },
            "municipioNombre" => function () {
                return $this->provFkdom && $this->provFkdom->domFkmun
                    ? $this->provFkdom->domFkmun->mun_nombre
                    : null;
            },
            "estadoNombre" => function () {
                return $this->provFkdom
                    && $this->provFkdom->domFkmun
                    && $this->provFkdom->domFkmun->munFkestd
                    ? $this->provFkdom->domFkmun->munFkestd->estd_nombre
                    : null;
            },
            "estatuNombre" => function () {
                return $this->provFkest->est_nombre;
            }
        ];
    }
}
