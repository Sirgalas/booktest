<?php

namespace app\Entities\User\Forms;

use app\Entities\User\Entity\User;
use yii\base\Model;

class MessageForm extends Model
{

    public $id;
    public $user_id;
    public $message;
    public $created_at;
    public $updated_at;
    public $is_view;

    public function rules()
    {
        return [
            [['user_id', 'is_view'], 'integer'],
            [['message'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
}