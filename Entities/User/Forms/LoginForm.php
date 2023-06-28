<?php

namespace app\Entities\User\Forms;

use app\Entities\User\Entity\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email','email'],
            ['rememberMe', 'boolean'],
        ];
    }


}
