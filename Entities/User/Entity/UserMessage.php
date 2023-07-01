<?php

namespace app\Entities\User\Entity;

use app\Entities\User\Forms\MessageForm;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_message".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $message
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $is_view
 *
 * @property User $user
 */
class UserMessage extends \yii\db\ActiveRecord
{
    public static function create(int $user_id, $message): self
    {
        $message = new static();
        $message->user_id = $user_id;
        $message->message = $message;
        return $message;
    }

    public function edit(): void
    {
        $this->is_view = true;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_message';
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_view' => 'Is View',
        ];
    }


    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
