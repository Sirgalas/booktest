<?php

declare(strict_types=1);

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\rest\Controller;

class RestController extends Controller
{
    public function beforeAction($action)
    {
        \Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Access-Control-Request-Method' => ['POST','GET','PUT','DELETE','OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Request-Headers'   => [
                    'Origin',
                    'Content-Type',
                    'Accept',
                ],
            ],

        ];

        return $behaviors;
    }

    public function actions()
    {
        return [
            'options' => [
                'class' => 'app\components\OptionsAction',
            ],
        ];
    }
}