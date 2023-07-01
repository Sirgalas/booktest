<?php

namespace app\Senders;

use yii\base\Component;

interface AbstractSender
{

    public function send(int $user_id,$message): void;
}