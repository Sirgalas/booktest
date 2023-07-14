<?php

declare(strict_types=1);

namespace app\controllers;

use app\api\components\Helper;
use app\Entities\User\Entity\PermissionEnum;
use app\Entities\User\Services\UserMessageService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MessageController extends RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        'options',
                    ],
                ],
                [
                    'actions' => ['visible'],
                    'allow' => true,
                    'roles' => [PermissionEnum::GUEST]
                ],
            ],
        ];

        return $behaviors;
    }

    private UserMessageService $service;

    public function __construct($id, $module, UserMessageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionVisible(int $id)
    {
        try {
            $this->service->userIsVisible($id);
            Yii::$app->response->setStatusCode(200, 'Success');
            return ['status' => 'ok'];
        }catch (NotFoundHttpException $e) {
            Yii::error($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            Yii::$app->response->setStatusCode(400, 'Bad request');
            return ["error" => $e->getMessage()];
        }
    }
}