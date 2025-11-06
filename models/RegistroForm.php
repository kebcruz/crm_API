<?php
namespace app\models;

use yii\base\Model;

class RegistroForm extends Model
{
    public $username;
    public $password;
    public $emp_nombre;
    public $emp_paterno;
    public $emp_materno;
    public $emp_telefono;
    public $emp_comision;
    public $emp_hora_entrada;
    public $emp_hora_salida;
    public $emp_fecha_nacimiento;
    public $emp_fecha_alta;
    public $emp_fkdom_id;
    public $emp_fkpuesto_id;
    public $emp_fkarc_id;

    public function rules() 
    {
        return [
            ['username', 'unique'],
            [['username', 'password'], 'trim'],
            [['username', 'password', 'emp_nombre', 'emp_paterno', 'emp_materno', 'emp_telefono', 'emp_comision', 'emp_hora_entrada', 'emp_hora_salida', 'emp_fecha_nacimiento', 'emp_fecha_alta', 'emp_fkdom_id', 'emp_fkpuesto_id', 'emp_fkarc_id'], 'required'],
            [['emp_telefono', 'emp_fkdom_id', 'emp_fkpuesto_id', 'emp_fkarc_id'], 'integer'],
            [['emp_comision'], 'number'],
            [['emp_hora_entrada', 'emp_hora_salida', 'emp_fecha_nacimiento', 'emp_fecha_alta', 'emp_fecha_baja'], 'safe'],
            [['emp_nombre', 'emp_paterno', 'emp_materno'], 'string', 'max' => 50],
        ];
    }
}