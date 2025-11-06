<?php

namespace app\controllers;

use Yii;
use yii\filters\Cors;
use app\models\Empleado;
use app\models\RegistroForm;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\models\forms\LoginForm;

class EmpleadoController extends ActiveController
{
    public $modelClass = 'app\models\Empleado';
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin'                           => ['http://localhost:8100', 'http://localhost:8101'],
                'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'DELETE'],
                'Access-Control-Request-Headers'   => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age'           => 600
            ]
        ];

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],
            'except' => ['index', 'view', 'total', 'buscar', 'login', 'registrar']
        ];

        return $behaviors;
    }
    public function actionTotal($text = "")
    {
        $total = Empleado::find();
        if ($text != '') {
            $total = $total->where(['like', new \yii\db\Expression("CONCAT(emp_nombre, ' ', emp_paterno, ' ', emp_materno)"), $text]);
        }
        $total = $total->count();
        return $total;
    }
    public function actionBuscar($text = "")
    {
        $consulta = Empleado::find()->where(['like', new \yii\db\Expression("CONCAT(emp_nombre, ' ', emp_paterno, ' ', emp_materno)"), $text]);

        $empleados = new ActiveDataProvider([
            'query' => $consulta,
            'pagination' => [
                'pageSize' => 20 // Número de resultados por página
            ],
        ]);

        return $empleados->getModels();
    }
    public function actionLogin()
    {
        $token = '';
        $model = new LoginForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->login()) {
            $token = User::findOne(['username' => $model->username])->auth_key;
        }
        return $token;
    }
    public function actionRegistrar()
    {
        $token = '';
        $model = new RegistroForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $user   = new User();
        $empleado = new Empleado();
        $user->username        = $model->username;
        $user->password        = $model->password;
        $user->status          = User::STATUS_ACTIVE;
        $user->email_confirmed = 1;
        if ($user->save()) {
            $empleado->emp_nombre    = $model->emp_nombre;
            $empleado->emp_paterno   = $model->emp_paterno;
            $empleado->emp_materno   = $model->emp_materno;
            $empleado->emp_telefono  = $model->emp_telefono;
            $empleado->emp_comision      = $model->emp_comision;
            $empleado->emp_hora_entrada      = $model->emp_hora_entrada;
            $empleado->emp_hora_salida      = $model->emp_hora_salida;
            $empleado->emp_fecha_nacimiento      = $model->emp_fecha_nacimiento;
            $empleado->emp_fecha_alta      = $model->emp_fecha_alta;
            $empleado->emp_fkdom_id      = $model->emp_fkdom_id;
            $empleado->emp_fkpuesto_id      = $model->emp_fkpuesto_id;
            $empleado->emp_fkarc_id      = $model->emp_fkarc_id;
            $empleado->emp_fkuser_id      = $user->id;
            if ($empleado->save()) {
                $token = $user->auth_key;
            } else {
                return $user->errors;
            }
        } else {
            return $user;
        }
        return $token;
    }
}
