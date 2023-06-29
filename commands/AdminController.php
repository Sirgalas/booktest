<?php

namespace app\commands;

use app\Entities\User\Entity\User;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class AdminController extends Controller
{

    public function actionIndex($username,$email,$password)
    {
        $user = User::create(
            $username,
            $email,
            $password
        );

        $user->save($user);

        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole(User::ADMIN);
        $auth->assign($authorRole, $user->getId());

        $this->stdout("ok\n", Console::FG_GREEN);
    }
}