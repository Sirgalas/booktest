<?php

namespace app\Entities\User\Repositories;

use app\Entities\Book\Entity\Book;
use app\Entities\User\Entity\User;
use app\Helpers\RequestHelper;
use RuntimeException;

class UserRepository
{
    public function one(int $id): User
    {
        if(!$user = User ::findOne($id)) {
            throw new RuntimeException("User not find");
        }
        return $user;
    }

    public function find(int $id):? User
    {
        if(!$user = User ::findOne($id)) {
            return null;
        }
        return $user;
    }


    public function save(User $user): User
    {
        if(!$user->save()){
            throw  new RuntimeException(RequestHelper::errorsToStr($user->errors));
        }
        return $user;
    }

    public function remove(int $id): void
    {
        $user = $this->one($id);
        $user->delete();
    }
}