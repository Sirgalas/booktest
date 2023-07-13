<?php

namespace app\Queue;

use app\Entities\Author\Entity\Author;
use app\Senders\AbstractSender;
use yii\helpers\ArrayHelper;

class MessageJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    /**
     * @var AbstractSender $sender
     */
    public $sender;

    public $author_id;

    public $book_title;

    public function execute($queue)
    {
        $author = Author::findOne($this->author_id);
        $usersIdSubscribeAuthor = ArrayHelper::getColumn($author->users,'id');
        $message = sprintf("%s add book %s",$author->getFullName(),$this->book_title);

        foreach ($usersIdSubscribeAuthor as $userIdSubscribeAuthor ) {
            $this->sender->send($userIdSubscribeAuthor,$message);
        }
    }
}