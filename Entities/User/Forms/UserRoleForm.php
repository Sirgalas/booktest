<?php

namespace app\Entities\User\Forms;

use app\Entities\Book\Entity\Book;
use app\Entities\User\Entity\Auth\AuthItem;
use app\Entities\User\Entity\User;
use yii\base\Model;

class UserRoleForm extends Model
{
    public $role;

    public function __construct(User $user,$config = [])
    {
        if(is_object($user->assignment)) {
            $this->role = $user->assignment->item_name;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [
                ['role'],
                'exist',
                'skipOnError' => true,
                'targetClass' => AuthItem::class,
                'targetAttribute' => ['role' => 'name']
            ],
        ];
    }
}