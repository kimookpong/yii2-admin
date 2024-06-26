<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\rest\Controller;
use yii\httpclient\Client;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['localhost'],
                    'Access-Control-Request-Method' => ['GET', 'POST'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,
                    'Access-Control-Allow-Headers' => ['*'],
                ],
            ],
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actionIndex($module, $action)
    {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Access denied.');
        }
        // $userCheck = User::findOne(['auth_key' => Yii::$app->user->identity->auth_key]);
        // if (empty($userCheck)) {
        //     throw new \yii\web\ForbiddenHttpException('Access denied.');
        // }
        $headers = Yii::$app->request->headers;
        if (!$headers->has('X-Requested-With') || $headers->get('X-Requested-With') !== 'XMLHttpRequest') {
            throw new \yii\web\ForbiddenHttpException('Access denied.');
        }
        if (empty(Yii::$app->params['api'][$module][$action])) {
            throw new \yii\web\NotFoundHttpException('API not found.');
        }
        $params = Yii::$app->request->post();
        $method = 'GET';
        if (!empty($params['method'])) {
            $method = $params['method'];
        }
        $params['api_key'] = Yii::$app->params['api_key'];
        $apiPath = Yii::$app->params['api'][$module][$action];
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod($method)
            ->setUrl($apiPath)
            ->setData($params)
            ->send();
        if ($response->isOk) {
            return $response->data;
        }
        throw new \yii\web\BadRequestHttpException('API not work.');
    }
}
