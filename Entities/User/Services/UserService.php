<?php

namespace app\Entities\User\Services;

use app\Entities\User\Forms\LoginForm;
use app\Entities\User\Entity\User;
use app\Entities\User\Forms\SignupForm;
use Yii;

class UserService
{
    public function signup(SignupForm $signupForm):User
    {
        $user=User::create(
            $signupForm->username,
            $signupForm->email,
            $signupForm->password
        );

        $user->save($user);
        return $user;
    }

    public function auth(LoginForm $form): User
    {
        $user = User::findByUsername($form->email);
        if(!$user || !$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined user or password.');
        }

        return $user;
    }

}