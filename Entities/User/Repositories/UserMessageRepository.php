<?php

namespace app\Entities\User\Repositories;

use app\Entities\User\Entity\User;
use app\Entities\User\Entity\UserMessage;
use app\Helpers\HelperView;
use app\Helpers\RequestHelper;
use \RuntimeException;
use yii\web\NotFoundHttpException;

class UserMessageRepository
{
    public static function save(UserMessage $userMessage): UserMessage
    {
        if(!$userMessage->save()) {
            throw new RuntimeException(RequestHelper::errorsToStr($userMessage->errors));
        }
        return $userMessage;
    }

    public static function findByUserId(User $user): array
    {
        return UserMessage::find()->where(['user_id' => $user->id, 'is_view' => false])->all();
    }
}