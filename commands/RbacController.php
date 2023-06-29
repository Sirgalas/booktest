<?php

namespace app\commands;

use app\Entities\User\Entity\PermissionEnum;
use app\Entities\User\Entity\User;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $adminPermission = $auth->createPermission(PermissionEnum::ADMIN);
        $auth->add($adminPermission);


        $userPermission = $auth->createPermission(PermissionEnum::USER);
        $auth->add($userPermission);


        $guestPermission = $auth->createPermission(PermissionEnum::GUEST);
        $auth->add($guestPermission);


        $guest = $auth->createRole(User::GUEST);
        $auth->add($guest);
        $auth->addChild($guest, $guestPermission);

        $user = $auth->createRole(User::USER);
        $auth->add($user);
        $auth->addChild($user, $userPermission);
        $auth->addChild($user,$guest);


        $admin = $auth->createRole(User::ADMIN);
        $auth->add($admin);
        $auth->addChild($admin, $adminPermission);
        $auth->addChild($admin,$user);

    }
}