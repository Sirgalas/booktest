<?php

declare(strict_types=1);

namespace app\controllers;

use app\Entities\User\Entity\PermissionEnum;
use app\Entities\User\Services\UserMessageService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MessageController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['visible'],
                            'allow' => true,
                            'roles' => [PermissionEnum::GUEST]
                        ],
                    ],
                ],

            ]
        );
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
        }catch (NotFoundHttpException $e) {
            Yii::error($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
}