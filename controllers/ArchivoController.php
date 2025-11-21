<?php

namespace app\controllers;

use yii\filters\Cors;
use app\models\Archivo;
use yii\web\UploadedFile;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;

class ArchivoController extends ActiveController
{
    public $modelClass = 'app\models\Archivo';
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
            'except' => ['index', 'view', 'total', 'buscar', 'upload']
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new Archivo();
        $model->load(\Yii::$app->request->post(), '');

        if ($model->save()) {
            \Yii::$app->response->statusCode = 201;
            return $model;
        } else {
            \Yii::$app->response->statusCode = 422;
            return $model->getErrors();
        }
    }

    // Acción para subir archivos
    public function actionUpload()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $file = UploadedFile::getInstanceByName('file');

        if (!$file) {
            \Yii::$app->response->statusCode = 400;
            return ['error' => 'No se ha subido ningún archivo'];
        }

        // Validar tipo de archivo
        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
        $fileExtension = strtolower($file->getExtension());

        if (!in_array($fileExtension, $allowedTypes)) {
            \Yii::$app->response->statusCode = 400;
            return ['error' => 'Tipo de archivo no permitido'];
        }

        // Crear directorio si no existe
        $uploadPath = \Yii::getAlias('@webroot/uploads/archivos/');
        $datePath = date('Y/m/d');
        $fullPath = $uploadPath . $datePath;

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0777, true);
        }

        // Generar nombre único
        $fileName = time() . '_' . $file->name;
        $filePath = $fullPath . '/' . $fileName;

        if ($file->saveAs($filePath)) {
            // Devolver la ruta relativa para guardar en la base de datos
            return [
                'ruta' => "uploads/archivos/{$datePath}/{$fileName}",
                'nombre' => $file->name,
                'tamanio' => $file->size,
                'tipo' => $fileExtension
            ];
        } else {
            \Yii::$app->response->statusCode = 500;
            return ['error' => 'Error al guardar el archivo'];
        }
    }

    public function actionTotal($text = "")
    {
        $total = Archivo::find();
        if ($text != '') {
            /* like sirve para buscar texto, con lo cual texto buscara en los tres primeros campos */
            $total = $total->where(['like', new \yii\db\Expression("CONCAT(arc_nombre, ' ', arc_tipo)"), $text]);
        }
        $total = $total->count();
        return $total;
    }

    public function actionBuscar($text = "")
    {
        $consulta = Archivo::find()->where(['like', new \yii\db\Expression("CONCAT(arc_nombre, ' ', arc_tipo)"), $text]);

        $archivos = new ActiveDataProvider([
            'query' => $consulta,
            'pagination' => [
                'pageSize' => 20 // Número de resultados por página
            ],
        ]);
        return $archivos->getModels();
    }
}
