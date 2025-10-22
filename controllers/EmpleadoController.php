<?php
namespace app\controllers;

use yii\filters\Cors;
use app\models\Empleado;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;

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
                'Origin'                           => ['http://localhost:8100','http://localhost:8101'],
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
            'except' => ['index', 'view', 'total', 'buscar']
        ];

        return $behaviors;
    }
    public function actionTotal($text="") {
        $total = Empleado::find();
        if($text != '') {
            $total = $total->where(['like', new \yii\db\Expression("CONCAT(emp_nombre, ' ', emp_paterno, ' ', emp_materno)"), $text]);
        }
        $total = $total->count();
        return $total;
    }
    public function actionBuscar($text="")
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
}