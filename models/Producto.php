<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property int $pro_id
 * @property string $pro_nombre
 * @property string|null $pro_caracteristica
 * @property float $pro_precio
 * @property string|null $pro_sku
 * @property int|null $pro_descuento
 * @property int $pro_stock
 * @property string $pro_fecha_creacion
 * @property int $pro_fkcat_id
 * @property int $pro_fkproveedor_id
 * @property int $pro_fkest_id
 * @property int|null $pro_fkarc_id
 * @property int $pro_fkcol_id
 *
 * @property Archivo $proFkarc
 * @property Categoria $proFkcat
 * @property Color $proFkcol
 * @property Estatu $proFkest
 * @property Proveedor $proFkproveedor
 * @property ProductoEtiqueta[] $productoEtiquetas
 * @property VentaDetalle[] $ventaDetalles
 */
class Producto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pro_caracteristica', 'pro_sku', 'pro_descuento', 'pro_fkarc_id'], 'default', 'value' => null],
            [['pro_nombre', 'pro_precio', 'pro_stock', 'pro_fecha_creacion', 'pro_fkcat_id', 'pro_fkproveedor_id', 'pro_fkest_id', 'pro_fkcol_id'], 'required'],
            [['pro_caracteristica'], 'string'],
            [['pro_precio'], 'number'],
            [['pro_descuento', 'pro_stock', 'pro_fkcat_id', 'pro_fkproveedor_id', 'pro_fkest_id', 'pro_fkarc_id', 'pro_fkcol_id'], 'integer'],
            [['pro_fecha_creacion'], 'safe'],
            [['pro_nombre'], 'string', 'max' => 100],
            [['pro_sku'], 'string', 'max' => 20],
            [['pro_sku'], 'unique'],
            [['pro_fkarc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Archivo::class, 'targetAttribute' => ['pro_fkarc_id' => 'arc_id']],
            [['pro_fkcat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['pro_fkcat_id' => 'cat_id']],
            [['pro_fkcol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::class, 'targetAttribute' => ['pro_fkcol_id' => 'col_id']],
            [['pro_fkest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estatu::class, 'targetAttribute' => ['pro_fkest_id' => 'est_id']],
            [['pro_fkproveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedor::class, 'targetAttribute' => ['pro_fkproveedor_id' => 'prov_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pro_id' => 'Pro ID',
            'pro_nombre' => 'Pro Nombre',
            'pro_caracteristica' => 'Pro Caracteristica',
            'pro_precio' => 'Pro Precio',
            'pro_sku' => 'Pro Sku',
            'pro_descuento' => 'Pro Descuento',
            'pro_stock' => 'Pro Stock',
            'pro_fecha_creacion' => 'Pro Fecha Creacion',
            'pro_fkcat_id' => 'Pro Fkcat ID',
            'pro_fkproveedor_id' => 'Pro Fkproveedor ID',
            'pro_fkest_id' => 'Pro Fkest ID',
            'pro_fkarc_id' => 'Pro Fkarc ID',
            'pro_fkcol_id' => 'Pro Fkcol ID',
        ];
    }

    /**
     * Gets query for [[ProFkarc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProFkarc()
    {
        return $this->hasOne(Archivo::class, ['arc_id' => 'pro_fkarc_id']);
    }

    /**
     * Gets query for [[ProFkcat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProFkcat()
    {
        return $this->hasOne(Categoria::class, ['cat_id' => 'pro_fkcat_id']);
    }

    /**
     * Gets query for [[ProFkcol]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProFkcol()
    {
        return $this->hasOne(Color::class, ['col_id' => 'pro_fkcol_id']);
    }

    /**
     * Gets query for [[ProFkest]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProFkest()
    {
        return $this->hasOne(Estatu::class, ['est_id' => 'pro_fkest_id']);
    }

    /**
     * Gets query for [[ProFkproveedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProFkproveedor()
    {
        return $this->hasOne(Proveedor::class, ['prov_id' => 'pro_fkproveedor_id']);
    }

    /**
     * Gets query for [[ProductoEtiquetas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductoEtiquetas()
    {
        return $this->hasMany(ProductoEtiqueta::class, ['pret_fkpro_id' => 'pro_id']);
    }

    /**
     * Gets query for [[VentaDetalles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentaDetalles()
    {
        return $this->hasMany(VentaDetalle::class, ['ved_fkpro_id' => 'pro_id']);
    }

    public function extraFields()
    {
        return[
            "archivoRuta" =>function(){
                return $this->proFkarc->arc_ruta;
            },
            "categoriaNombre" =>function(){
                return $this->proFkcat->cat_nombre;
            },
        ];
    }
}
