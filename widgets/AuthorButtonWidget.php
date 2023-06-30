<?php

namespace app\widgets;

use app\Entities\User\Entity\User;
use PHPUnit\Framework\Constraint\ArrayHasKey;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class AuthorButtonWidget extends Widget
{
    /** @var User $user */
    public $user;
    public $author_id;

    public function run() {
        $authorArrayId = ArrayHelper::getColumn($this->user->authors,'id');

        if(empty($authorArrayId)) {
            return $this->render('add_button', ['author_id' => $this->author_id]);
        }

        if(!is_bool(array_search($this->author_id,$authorArrayId))) {
            return $this->render('remove_button', ['author_id' => $this->author_id]);
        }

        return $this->render('add_button', ['author_id' => $this->author_id]);
    }
}