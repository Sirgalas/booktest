<?php

namespace app\Senders;

use app\Entities\User\Entity\UserMessage;
use app\Entities\User\Forms\MessageForm;
use app\Entities\User\Repositories\UserMessageRepository;
use app\Helpers\RequestHelper;
use Yii;

class FlashSend implements AbstractSender
{
    public function send(int $user_id, $message): void
    {
        try{
            $messageUser = UserMessage::create($user_id, $message);
            UserMessageRepository::save($messageUser);
        } catch (\RuntimeException $e) {
            Yii::info([
                'error' => $e->getMessage(),
                'class' => self::class,
                'string' => 22
            ]);
        }
    }
}