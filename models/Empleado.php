<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empleado".
 *
 * @property int $emp_id
 * @property string $emp_nombre
 * @property string $emp_paterno
 * @property string $emp_materno
 * @property int $emp_telefono
 * @property float $emp_comision
 * @property string $emp_hora_entrada
 * @property string $emp_hora_salida
 * @property string $emp_fecha_nacimiento
 * @property string $emp_fecha_alta
 * @property string|null $emp_fecha_baja
 * @property int $emp_fkdom_id
 * @property int $emp_fkpuesto_id
 * @property int $emp_fkarc_id
 *
 * @property Archivo $empFkarc
 * @property Domicilio $empFkdom
 * @property Puesto $empFkpuesto
 * @property Venta[] $ventas
 */
class Empleado extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empleado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_fecha_baja'], 'default', 'value' => null],
            [['emp_nombre', 'emp_paterno', 'emp_materno', 'emp_telefono', 'emp_comision', 'emp_hora_entrada', 'emp_hora_salida', 'emp_fecha_nacimiento', 'emp_fecha_alta', 'emp_fkdom_id', 'emp_fkpuesto_id', 'emp_fkarc_id'], 'required'],
            [['emp_telefono', 'emp_fkdom_id', 'emp_fkpuesto_id', 'emp_fkarc_id'], 'integer'],
            [['emp_comision'], 'number'],
            [['emp_hora_entrada', 'emp_hora_salida', 'emp_fecha_nacimiento', 'emp_fecha_alta', 'emp_fecha_baja'], 'safe'],
            [['emp_nombre', 'emp_paterno', 'emp_materno'], 'string', 'max' => 50],
            [['emp_fkarc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Archivo::class, 'targetAttribute' => ['emp_fkarc_id' => 'arc_id']],
            [['emp_fkdom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Domicilio::class, 'targetAttribute' => ['emp_fkdom_id' => 'dom_id']],
            [['emp_fkpuesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Puesto::class, 'targetAttribute' => ['emp_fkpuesto_id' => 'pue_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_id' => 'Emp ID',
            'emp_nombre' => 'Emp Nombre',
            'emp_paterno' => 'Emp Paterno',
            'emp_materno' => 'Emp Materno',
            'emp_telefono' => 'Emp Telefono',
            'emp_comision' => 'Emp Comision',
            'emp_hora_entrada' => 'Emp Hora Entrada',
            'emp_hora_salida' => 'Emp Hora Salida',
            'emp_fecha_nacimiento' => 'Emp Fecha Nacimiento',
            'emp_fecha_alta' => 'Emp Fecha Alta',
            'emp_fecha_baja' => 'Emp Fecha Baja',
            'emp_fkdom_id' => 'Emp Fkdom ID',
            'emp_fkpuesto_id' => 'Emp Fkpuesto ID',
            'emp_fkarc_id' => 'Emp Fkarc ID',
        ];
    }

    /**
     * Gets query for [[EmpFkarc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpFkarc()
    {
        return $this->hasOne(Archivo::class, ['arc_id' => 'emp_fkarc_id']);
    }

    /**
     * Gets query for [[EmpFkdom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpFkdom()
    {
        return $this->hasOne(Domicilio::class, ['dom_id' => 'emp_fkdom_id']);
    }

    /**
     * Gets query for [[EmpFkpuesto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpFkpuesto()
    {
        return $this->hasOne(Puesto::class, ['pue_id' => 'emp_fkpuesto_id']);
    }

    /**
     * Gets query for [[Ventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasMany(Venta::class, ['ven_fkemp_id' => 'emp_id']);
    }

    public function extraFields()
    {
        return[
            "archivo" =>function(){
                return $this->empFkarc;
            },
            "domicilioNombre" =>function(){
                return $this->empFkdom->dom_calle;
            },
            "municipioNombre" => function () {
            return $this->empFkdom && $this->empFkdom->domFkmun
                ? $this->empFkdom->domFkmun->mun_nombre
                :null;
            },
            "puestoNombre" =>function(){
                return $this->empFkpuesto->pue_nombre;
            }
        ];
    }
}
