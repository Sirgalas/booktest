<?php

namespace app\Entities\Author\Repositories;

use app\Entities\Author\Entity\Author;
use app\Helpers\RequestHelper;
use RuntimeException;

class AuthorRepository
{
    public function one(int $id): Author
    {
        if(!$Author = Author::findOne($id)) {
            throw new RuntimeException("Author not find");
        }
        return $Author;
    }

    public function find(int $id):? Author
    {
        if(!$Author = Author::findOne($id)) {
            return null;
        }
        return $Author;
    }


    public function save(Author $Author): Author
    {
        if(!$Author->save()){
            throw  new RuntimeException(RequestHelper::errorsToStr($Author->errors));
        }
        return $Author;
    }

    public function remove(int $id): void
    {
        $Author = $this->one($id);
        $Author->delete();
    }

    public static function getAll(): array
    {
        return Author::find()->all();
    }
}