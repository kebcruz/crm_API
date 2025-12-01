<?php
namespace app\controllers;

use yii\filters\Cors;
use app\models\Devolucion;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;

class DevolucionController extends ActiveController
{
    public $modelClass = 'app\models\Devolucion';
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

    public function actionTotal($text = "")
    {
        $total = Devolucion::find();
        if ($text != '') {
            /* like sirve para buscar texto, con lo cual texto buscara en los tres primeros campos */
            $total = $total->where(['like', new \yii\db\Expression("CONCAT(dev_asunto, ' ', dev_descripcion, ' ', dev_fecha_creacion)"), $text]);
        }
        $total = $total->count();
        return $total;
    }

    public function actionBuscar($text = "")
    {
        $consulta = Devolucion::find()->where(['like', new \yii\db\Expression("CONCAT(dev_asunto, ' ', dev_descripcion, ' ', dev_fecha_creacion)"), $text]);

        $devolucions = new ActiveDataProvider([
            'query' => $consulta,
            'pagination' => [
                'pageSize' => 20 // Número de resultados por página
            ],
        ]);
        return $devolucions->getModels();
    }

}